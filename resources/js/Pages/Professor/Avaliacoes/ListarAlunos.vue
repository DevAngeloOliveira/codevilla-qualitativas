<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import EmptyState from '@/Components/EmptyState.vue';

defineProps({
    turma: { type: Object, default: () => ({}) },
    disciplina: { type: Object, default: () => ({}) },
    trimestre: { type: String, default: '' },
    alunos: { type: Array, default: () => [] },
});
</script>

<template>
    <Head :title="`Avaliar ${turma?.nome || 'Turma'} - ${disciplina?.nome || 'Disciplina'}`" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-6">
                    <Link :href="route('professor.avaliacoes.index')" class="inline-block mb-2 text-codevilla-accent hover:underline">
                        ← Voltar para seleção
                    </Link>
                    <h1 class="text-3xl font-bold text-codevilla-text">{{ turma?.nome || '-' }} - {{ disciplina?.nome || '-' }}</h1>
                    <p class="mt-2 text-codevilla-muted">{{ trimestre }}º Trimestre - Selecione um aluno para avaliar</p>
                </div>

                <Card v-if="alunos.length > 0" title="Alunos">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <Link
                            v-for="aluno in alunos"
                            :key="aluno.id"
                            :href="route('professor.avaliacoes.avaliar', {
                                aluno: aluno.uuid,
                                disciplina: disciplina.id,
                                trimestre: trimestre,
                            })"
                            class="text-center p-6 rounded-lg border-2 border-gray-200 hover:border-codevilla-accent hover:shadow-lg transition-all duration-300"
                        >
                            <div class="mb-4">
                                <img
                                    :src="aluno.foto_url || '/assets/images/placeholder-icon.png'"
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
                                <span class="inline-block px-3 py-1 text-sm font-medium text-blue-700 bg-blue-100 rounded-full">
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
                </Card>

                <EmptyState
                    v-else
                    icon="users"
                    title="Nenhum aluno encontrado"
                    message="Não há alunos cadastrados nesta turma."
                >
                    <template #action>
                        <Link :href="route('professor.avaliacoes.index')" class="inline-flex items-center px-4 py-2 bg-codevilla-accent text-white rounded-lg hover:bg-codevilla-primary transition">
                            Voltar
                        </Link>
                    </template>
                </EmptyState>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
