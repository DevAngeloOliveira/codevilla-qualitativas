<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({
    turmas: Array,
    disciplinas: Array,
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
        <div class="container">
            <div class="page-header">
                <h1>Avaliações Qualitativas</h1>
                <p>Selecione a turma, disciplina e trimestre para avaliar os alunos</p>
            </div>

            <div class="card" style="max-width: 700px; margin: 0 auto;">
                <h2 class="card-title">Iniciar Avaliação</h2>

                <div class="space-y-4">
                    <div class="form-group">
                        <label>Turma</label>
                        <select v-model="turmaSelecionada" required class="form-control">
                            <option value="">Selecione uma turma</option>
                            <option v-for="turma in turmas" :key="turma.id" :value="turma.uuid">
                                {{ turma.nome }} - {{ turma.ano_letivo }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Disciplina</label>
                        <select v-model="disciplinaSelecionada" required class="form-control">
                            <option value="">Selecione uma disciplina</option>
                            <option v-for="disciplina in disciplinas" :key="disciplina.id" :value="disciplina.id">
                                {{ disciplina.nome }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Trimestre</label>
                        <select v-model="trimestreSelecionado" required class="form-control">
                            <option value="">Selecione o trimestre</option>
                            <option value="1">1º Trimestre</option>
                            <option value="2">2º Trimestre</option>
                            <option value="3">3º Trimestre</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="iniciarAvaliacao" class="btn btn-primary">
                            Iniciar Avaliação
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-semibold text-codevilla-text mb-4">Como funciona a avaliação?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="card">
                        <h3 class="font-semibold text-codevilla-primary mb-2">1. Selecione</h3>
                        <p class="text-sm text-codevilla-muted">
                            Escolha a turma, disciplina e trimestre que deseja avaliar
                        </p>
                    </div>
                    <div class="card">
                        <h3 class="font-semibold text-codevilla-primary mb-2">2. Avalie</h3>
                        <p class="text-sm text-codevilla-muted">
                            Para cada aluno, avalie os 12 critérios qualitativos de 0 a 4
                        </p>
                    </div>
                    <div class="card">
                        <h3 class="font-semibold text-codevilla-primary mb-2">3. Nota Automática</h3>
                        <p class="text-sm text-codevilla-muted">
                            A nota final é calculada automaticamente com base nos critérios
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
