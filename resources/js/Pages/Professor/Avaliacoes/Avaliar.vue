<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    aluno: Object,
    disciplina: Object,
    trimestre: String,
    criterios: Array,
    avaliacao: Object,
    valoresCriterios: Object,
    alunoAnterior: Object,
    proximoAluno: Object,
});

// Inicializar valores dos critérios
const criteriosValores = ref({});
props.criterios.forEach(criterio => {
    criteriosValores.value[criterio.id] = props.valoresCriterios[criterio.id] ?? 0;
});

const form = useForm({
    aluno_id: props.aluno.id,
    disciplina_id: props.disciplina.id,
    trimestre: props.trimestre,
    criterios: criteriosValores.value,
    observacoes: props.avaliacao?.observacoes ?? '',
});

// Calcular nota final em tempo real
const notaFinal = computed(() => {
    let somaPonderada = 0;
    let somaPesos = 0;

    props.criterios.forEach(criterio => {
        const valor = criteriosValores.value[criterio.id] || 0;
        const peso = parseFloat(criterio.peso) || 0;
        somaPonderada += (valor / 4) * peso;
        somaPesos += peso;
    });

    if (somaPesos === 0) {
        return '0.00';
    }

    const nota = (somaPonderada / somaPesos) * 10;
    return isNaN(nota) ? '0.00' : nota.toFixed(2);
});

// Sincronizar mudanças nos sliders
watch(criteriosValores, (newVal) => {
    form.criterios = { ...newVal };
}, { deep: true });

const salvarAvaliacao = () => {
    form.post(route('professor.avaliacoes.store'), {
        preserveScroll: true,
        onSuccess: () => {
            // Avaliação salva
        },
    });
};

const getValorLabel = (valor) => {
    const labels = {
        0: 'Não desenvolvido',
        1: 'Pouco desenvolvido',
        2: 'Parcialmente desenvolvido',
        3: 'Bem desenvolvido',
        4: 'Plenamente desenvolvido',
    };
    return labels[valor] || '';
};
</script>

<template>
    <Head :title="`Avaliar ${aluno.nome}`" />

    <AuthenticatedLayout>
        <div class="container">
            <div class="page-header">
                <div>
                    <Link
                        v-if="aluno?.turma?.uuid && disciplina?.id && trimestre"
                        :href="route('professor.avaliacoes.alunos', {
                            turma: aluno.turma.uuid,
                            disciplina: disciplina.id,
                            trimestre: trimestre,
                        })"
                        class="inline-block mb-2 text-codevilla-accent hover:underline"
                    >
                        ← Voltar para lista de alunos
                    </Link>
                    <h1>Avaliar Aluno</h1>
                    <p>{{ aluno.turma.nome }} - {{ disciplina.nome }} - {{ trimestre }}º Trimestre</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
                <!-- Sidebar com info do aluno -->
                <div class="lg:col-span-1">
                    <div class="sticky card top-4">
                        <div class="mb-4 text-center">
                            <img
                                :src="aluno.foto_url"
                                :alt="aluno.nome"
                                class="object-cover w-32 h-32 mx-auto border-4 rounded-full border-codevilla-border"
                            />
                        </div>

                        <h3 class="mb-2 font-semibold text-center text-codevilla-text">
                            {{ aluno.nome }}
                        </h3>

                        <p class="mb-4 text-sm text-center text-codevilla-muted">
                            Nº {{ aluno.numero_chamada }}
                        </p>

                        <div class="p-4 text-center rounded-lg bg-codevilla-bg">
                            <p class="mb-1 text-sm text-codevilla-muted">Nota Final</p>
                            <p class="text-3xl font-bold text-codevilla-primary">
                                {{ notaFinal }}
                            </p>
                        </div>

                        <!-- Navegação entre alunos -->
                        <div class="mt-6 space-y-2">
                            <Link
                                v-if="alunoAnterior && disciplina?.id"
                                :href="route('professor.avaliacoes.avaliar', {
                                    aluno: alunoAnterior.uuid,
                                    disciplina: disciplina.id,
                                    trimestre: trimestre,
                                })"
                                class="block w-full text-sm text-left btn btn-secondary"
                            >
                                <span class="block">← Anterior</span>
                                <span class="block mt-1 text-xs">{{ alunoAnterior.nome }}</span>
                            </Link>

                            <Link
                                v-if="proximoAluno && disciplina?.id"
                                :href="route('professor.avaliacoes.avaliar', {
                                    aluno: proximoAluno.uuid,
                                    disciplina: disciplina.id,
                                    trimestre: trimestre,
                                })"
                                class="block w-full text-sm text-left btn btn-secondary"
                            >
                                <span class="block">Próximo →</span>
                                <span class="block mt-1 text-xs">{{ proximoAluno.nome }}</span>
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Formulário de avaliação -->
                <div class="lg:col-span-3">
                    <form @submit.prevent="salvarAvaliacao">
                        <div class="card">
                            <h2 class="card-title">Critérios de Avaliação</h2>
                            <p class="mb-6 text-sm text-codevilla-muted">
                                Avalie cada critério de 0 a 4. A nota final será calculada automaticamente.
                            </p>

                            <div class="space-y-6">
                                <div
                                    v-for="criterio in criterios"
                                    :key="criterio.id"
                                    class="p-5 bg-white border border-gray-200 rounded-lg"
                                >
                                    <div class="mb-4">
                                        <h3 class="mb-1 text-base font-semibold text-codevilla-text">
                                            {{ criterio.nome }}
                                        </h3>
                                        <p class="mb-2 text-sm text-codevilla-muted">
                                            {{ criterio.descricao }}
                                        </p>
                                        <span class="inline-block px-2 py-1 text-xs text-white rounded bg-codevilla-accent">
                                            Peso: {{ criterio.peso }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-5 gap-3">
                                        <label
                                            v-for="(label, valor) in {
                                                0: 'Não desenvolvido',
                                                1: 'Pouco desenvolvido',
                                                2: 'Parcialmente desenvolvido',
                                                3: 'Bem desenvolvido',
                                                4: 'Plenamente desenvolvido'
                                            }"
                                            :key="valor"
                                            class="relative flex flex-col items-center justify-center transition-all border-2 rounded-lg cursor-pointer group"
                                            :class="criteriosValores[criterio.id] == valor
                                                ? 'border-codevilla-primary bg-codevilla-primary text-white'
                                                : 'border-gray-300 hover:border-codevilla-accent hover:bg-gray-50'"
                                        >
                                            <input
                                                type="radio"
                                                :name="`criterio_${criterio.id}`"
                                                :value="parseInt(valor)"
                                                v-model.number="criteriosValores[criterio.id]"
                                                class="absolute opacity-0"
                                            />
                                            <div class="flex flex-col items-center justify-center p-4">
                                                <span class="mb-2 text-3xl font-bold"
                                                    :class="criteriosValores[criterio.id] == valor
                                                        ? 'text-white'
                                                        : 'text-codevilla-primary'">
                                                    {{ valor }}
                                                </span>
                                                <span class="text-xs leading-tight text-center"
                                                    :class="criteriosValores[criterio.id] == valor
                                                        ? 'text-white'
                                                        : 'text-gray-600'">
                                                    {{ label }}
                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div v-if="form.errors" class="mt-4">
                                <div v-for="(error, key) in form.errors" :key="key" class="text-sm text-red-600">
                                    {{ error }}
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 mt-6">
                                <Link
                                    :href="route('professor.avaliacoes.alunos', {
                                        turma: aluno.turma.id,
                                        disciplina: disciplina.id,
                                        trimestre: trimestre,
                                    })"
                                    class="btn btn-secondary"
                                >
                                    Cancelar
                                </Link>
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    :disabled="form.processing"
                                >
                                    {{ form.processing ? 'Salvando...' : 'Salvar Avaliação' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.slider {
    width: 100%;
    height: 6px;
    border-radius: 5px;
    background: linear-gradient(to right, #dde2f4 0%, #2E63BF 100%);
    outline: none;
    -webkit-appearance: none;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #1A2E6B;
    cursor: pointer;
    border: 3px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.slider::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #1A2E6B;
    cursor: pointer;
    border: 3px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.criterio-item {
    background: #f4f6fb;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #dde2f4;
}
</style>
