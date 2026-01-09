<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    turma: Object,
});

const form = useForm({
    nome: props.turma.nome,
    ano_letivo: props.turma.ano_letivo,
    turno: props.turma.turno,
    segmento: props.turma.segmento,
    ativa: props.turma.ativa,
});

const submit = () => {
    form.put(route('admin.turmas.update', props.turma.uuid));
};
</script>

<template>
    <Head title="Editar Turma" />

    <AuthenticatedLayout>
        <div class="container">
            <div class="page-header">
                <div>
                    <Link :href="route('admin.turmas.index')" class="text-codevilla-accent hover:underline mb-2 inline-block">
                        ← Voltar para turmas
                    </Link>
                    <h1>Editar Turma</h1>
                    <p>Atualize as informações da turma</p>
                </div>
            </div>

            <form @submit.prevent="submit" class="card" style="max-width: 700px; margin: 0 auto;">
                <h2 class="card-title">Informações da Turma</h2>

                <div class="space-y-4">
                    <!-- Nome da Turma -->
                    <div class="form-group">
                        <label>Nome da Turma *</label>
                        <input
                            v-model="form.nome"
                            type="text"
                            class="form-control"
                            placeholder="Ex: 6º Ano A"
                            required
                        />
                        <p v-if="form.errors.nome" class="error-message">
                            {{ form.errors.nome }}
                        </p>
                    </div>

                    <!-- Ano Letivo -->
                    <div class="form-group">
                        <label>Ano Letivo *</label>
                        <input
                            v-model.number="form.ano_letivo"
                            type="number"
                            min="2020"
                            max="2099"
                            class="form-control"
                            required
                        />
                        <p v-if="form.errors.ano_letivo" class="error-message">
                            {{ form.errors.ano_letivo }}
                        </p>
                    </div>

                    <!-- Turno -->
                    <div class="form-group">
                        <label>Turno *</label>
                        <select v-model="form.turno" class="form-control" required>
                            <option value="Matutino">Matutino</option>
                            <option value="Vespertino">Vespertino</option>
                        </select>
                        <p v-if="form.errors.turno" class="error-message">
                            {{ form.errors.turno }}
                        </p>
                    </div>

                    <!-- Segmento -->
                    <div class="form-group">
                        <label>Segmento</label>
                        <input
                            v-model="form.segmento"
                            type="text"
                            class="form-control"
                            placeholder="Ex: Ensino Fundamental II"
                        />
                        <p v-if="form.errors.segmento" class="error-message">
                            {{ form.errors.segmento }}
                        </p>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label class="check-inline">
                            <input
                                v-model="form.ativa"
                                type="checkbox"
                            />
                            <span>Turma ativa</span>
                        </label>
                    </div>

                    <div v-if="turma.alunos && turma.alunos.length > 0" class="bg-codevilla-bg p-4 rounded-lg">
                        <p class="text-sm text-codevilla-muted">
                            <strong>{{ turma.alunos.length }}</strong> aluno(s) cadastrado(s) nesta turma
                        </p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <Link :href="route('admin.turmas.index')" class="btn btn-secondary">
                        Cancelar
                    </Link>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? 'Salvando...' : 'Salvar Alterações' }}
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
