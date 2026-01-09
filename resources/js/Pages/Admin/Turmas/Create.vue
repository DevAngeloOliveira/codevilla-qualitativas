<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    nome: '',
    ano_letivo: new Date().getFullYear(),
    turno: 'Matutino',
    segmento: 'Ensino Fundamental II',
});

const submit = () => {
    form.post(route('admin.turmas.store'));
};
</script>

<template>
    <Head title="Nova Turma" />

    <AuthenticatedLayout>
        <div class="container">
            <div class="page-header">
                <div>
                    <Link :href="route('admin.turmas.index')" class="text-codevilla-accent hover:underline mb-2 inline-block">
                        ← Voltar para turmas
                    </Link>
                    <h1>Nova Turma</h1>
                    <p>Cadastre uma nova turma no sistema</p>
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
                        {{ form.processing ? 'Salvando...' : 'Criar Turma' }}
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
