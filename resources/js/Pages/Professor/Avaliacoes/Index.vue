<script setup>
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import { ref } from 'vue';
import { ClipboardDocumentCheckIcon } from '@heroicons/vue/24/outline';

defineProps({
    turmas: { type: Array, default: () => [] },
    disciplinas: { type: Array, default: () => [] },
});

const turmaSelecionada = ref('');
const disciplinaSelecionada = ref('');
const trimestreSelecionado = ref('');

const iniciarAvaliacao = () => {
    if (!turmaSelecionada.value || !disciplinaSelecionada.value || !trimestreSelecionado.value) {
        alert('Por favor, selecione turma, disciplina e trimestre.');
        return;
    }

    router.get(route('professor.avaliacoes.alunos', {
        turma: turmaSelecionada.value,
        disciplina: disciplinaSelecionada.value,
        trimestre: trimestreSelecionado.value,
    }));
};
</script>

<template>
    <Head title="Avaliações" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-codevilla-text">Avaliações Qualitativas</h1>
                    <p class="mt-1 text-sm text-codevilla-muted">Selecione a turma, disciplina e trimestre para avaliar os alunos</p>
                </div>

                <!-- Formulário de Seleção -->
                <div class="max-w-2xl mx-auto mb-8">
                    <Card title="Iniciar Avaliação">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Turma</label>
                                <select
                                    v-model="turmaSelecionada"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-codevilla-accent focus:ring focus:ring-codevilla-accent focus:ring-opacity-50"
                                >
                                    <option value="">Selecione uma turma</option>
                                    <option v-for="turma in turmas" :key="turma.id" :value="turma.uuid">
                                        {{ turma.nome }} - {{ turma.ano_letivo }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Disciplina</label>
                                <select
                                    v-model="disciplinaSelecionada"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-codevilla-accent focus:ring focus:ring-codevilla-accent focus:ring-opacity-50"
                                >
                                    <option value="">Selecione uma disciplina</option>
                                    <option v-for="disciplina in disciplinas" :key="disciplina.id" :value="disciplina.id">
                                        {{ disciplina.nome }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Trimestre</label>
                                <select
                                    v-model="trimestreSelecionado"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-codevilla-accent focus:ring focus:ring-codevilla-accent focus:ring-opacity-50"
                                >
                                    <option value="">Selecione o trimestre</option>
                                    <option value="1">1º Trimestre</option>
                                    <option value="2">2º Trimestre</option>
                                    <option value="3">3º Trimestre</option>
                                </select>
                            </div>
                        </div>

                        <template #footer>
                            <div class="flex justify-end">
                                <button
                                    type="button"
                                    @click="iniciarAvaliacao"
                                    class="inline-flex items-center px-4 py-2 bg-codevilla-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-codevilla-accent focus:outline-none focus:ring-2 focus:ring-codevilla-accent focus:ring-offset-2 transition"
                                >
                                    <ClipboardDocumentCheckIcon class="w-5 h-5 mr-2" />
                                    Iniciar Avaliação
                                </button>
                            </div>
                        </template>
                    </Card>
                </div>

                <!-- Como funciona -->
                <div>
                    <h2 class="text-xl font-semibold text-codevilla-text mb-4">Como funciona a avaliação?</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <Card>
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-codevilla-primary/10 rounded-full mb-3">
                                    <span class="text-2xl font-bold text-codevilla-primary">1</span>
                                </div>
                                <h3 class="font-semibold text-codevilla-text mb-2">Selecione</h3>
                                <p class="text-sm text-codevilla-muted">
                                    Escolha a turma, disciplina e trimestre que deseja avaliar
                                </p>
                            </div>
                        </Card>
                        <Card>
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-codevilla-primary/10 rounded-full mb-3">
                                    <span class="text-2xl font-bold text-codevilla-primary">2</span>
                                </div>
                                <h3 class="font-semibold text-codevilla-text mb-2">Avalie</h3>
                                <p class="text-sm text-codevilla-muted">
                                    Para cada aluno, avalie os 12 critérios qualitativos de 0 a 4
                                </p>
                            </div>
                        </Card>
                        <Card>
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-codevilla-primary/10 rounded-full mb-3">
                                    <span class="text-2xl font-bold text-codevilla-primary">3</span>
                                </div>
                                <h3 class="font-semibold text-codevilla-text mb-2">Nota Automática</h3>
                                <p class="text-sm text-codevilla-muted">
                                    A nota final é calculada automaticamente com base nos critérios
                                </p>
                            </div>
                        </Card>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
