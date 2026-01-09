<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    turma: Object,
    disciplina: Object,
    trimestre: String,
    alunos: Array,
});
</script>

<template>
    <Head :title="`Avaliar ${turma.nome} - ${disciplina.nome}`" />

    <AuthenticatedLayout>
        <div class="container">
            <div class="page-header">
                <div>
                    <Link :href="route('professor.avaliacoes.index')" class="inline-block mb-2 text-codevilla-accent hover:underline">
                        ← Voltar para seleção
                    </Link>
                    <h1>{{ turma.nome }} - {{ disciplina.nome }}</h1>
                    <p>{{ trimestre }}º Trimestre - Selecione um aluno para avaliar</p>
                </div>
            </div>

            <div v-if="alunos.length === 0" class="empty-state">
                <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p>Nenhum aluno encontrado nesta turma.</p>
                <Link :href="route('professor.avaliacoes.index')" class="mt-4 btn btn-primary">
                    Voltar
                </Link>
            </div>

            <div v-else class="alunos-grid">
                <Link
                    v-for="aluno in alunos"
                    :key="aluno.id"
                    :href="route('professor.avaliacoes.avaliar', {
                        aluno: aluno.uuid,
                        disciplina: disciplina.id,
                        trimestre: trimestre,
                    })"
                    class="text-center card card-hover"
                >
                    <div class="mb-4">
                        <img
                            :src="aluno.foto_url"
                            :alt="aluno.nome"
                            class="object-cover w-32 h-32 mx-auto border-4 rounded-full border-codevilla-border"
                        />
                    </div>

                    <div class="mb-2">
                        <span class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full bg-codevilla-primary">
                            Nº {{ aluno.numero_chamada }}
                        </span>
                    </div>

                    <h3 class="mb-2 text-lg font-semibold text-codevilla-text">
                        {{ aluno.nome }}
                    </h3>

                    <div v-if="aluno.nota_final !== null" class="mt-3">
                        <span class="badge badge-blue">
                            Nota: {{ aluno.nota_final }}
                        </span>
                    </div>
                    <div v-else class="mt-3">
                        <span class="text-sm text-codevilla-muted">
                            Não avaliado
                        </span>
                    </div>

                    <div class="mt-4">
                        <span class="font-medium text-codevilla-accent hover:underline">
                            {{ aluno.nota_final !== null ? 'Editar avaliação →' : 'Avaliar aluno →' }}
                        </span>
                    </div>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
