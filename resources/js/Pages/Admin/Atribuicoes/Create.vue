<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    professores: Array,
    turmas: Array,
    disciplinas: Array,
});

const form = useForm({
    professor_id: '',
    turma_id: '',
    disciplina_id: '',
});

const submit = () => {
    form.post(route('admin.atribuicoes.store'));
};
</script>

<template>
    <Head title="Nova Atribuição" />

    <AuthenticatedLayout>
        <div class="container">
            <div class="page-header">
                <div>
                    <Link :href="route('admin.atribuicoes.index')" class="text-codevilla-accent hover:underline mb-2 inline-block">
                        ← Voltar para atribuições
                    </Link>
                    <h1>Nova Atribuição</h1>
                    <p>Atribua um professor a uma turma e disciplina</p>
                </div>
            </div>

            <form @submit.prevent="submit" class="card" style="max-width: 700px; margin: 0 auto;">
                <h2 class="card-title">Informações da Atribuição</h2>

                <div class="space-y-4">
                    <!-- Professor -->
                    <div class="form-group">
                        <label>Professor *</label>
                        <select v-model="form.professor_id" class="form-control" required>
                            <option value="">Selecione um professor</option>
                            <option v-for="professor in professores" :key="professor.id" :value="professor.id">
                                {{ professor.name }} ({{ professor.email }})
                            </option>
                        </select>
                        <p v-if="form.errors.professor_id" class="error-message">
                            {{ form.errors.professor_id }}
                        </p>
                    </div>

                    <!-- Turma -->
                    <div class="form-group">
                        <label>Turma *</label>
                        <select v-model="form.turma_id" class="form-control" required>
                            <option value="">Selecione uma turma</option>
                            <option v-for="turma in turmas" :key="turma.id" :value="turma.id">
                                {{ turma.nome }} - {{ turma.turno }} ({{ turma.ano_letivo }})
                            </option>
                        </select>
                        <p v-if="form.errors.turma_id" class="error-message">
                            {{ form.errors.turma_id }}
                        </p>
                    </div>

                    <!-- Disciplina -->
                    <div class="form-group">
                        <label>Disciplina *</label>
                        <select v-model="form.disciplina_id" class="form-control" required>
                            <option value="">Selecione uma disciplina</option>
                            <option v-for="disciplina in disciplinas" :key="disciplina.id" :value="disciplina.id">
                                {{ disciplina.nome }}
                            </option>
                        </select>
                        <p v-if="form.errors.disciplina_id" class="error-message">
                            {{ form.errors.disciplina_id }}
                        </p>
                    </div>

                    <div v-if="form.errors.error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        {{ form.errors.error }}
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <Link :href="route('admin.atribuicoes.index')" class="btn btn-secondary">
                        Cancelar
                    </Link>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? 'Salvando...' : 'Criar Atribuição' }}
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
