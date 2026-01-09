<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    atribuicoes: Object,
});

const deleteAtribuicao = (atribuicao) => {
    if (confirm(`Deseja remover a atribuição de ${atribuicao.professor_nome}?`)) {
        router.delete(route('admin.atribuicoes.destroy', atribuicao.id));
    }
};
</script>

<template>
    <Head title="Atribuições de Professores" />

    <AuthenticatedLayout>
        <div class="container">
            <div class="page-header">
                <div class="flex justify-between items-center">
                    <div>
                        <h1>Atribuições de Professores</h1>
                        <p>Gerencie as atribuições de professores às turmas e disciplinas</p>
                    </div>
                    <Link :href="route('admin.atribuicoes.create')" class="btn btn-primary">
                        Nova Atribuição
                    </Link>
                </div>
            </div>

            <div v-if="atribuicoes.data.length === 0" class="empty-state">
                <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <p>Nenhuma atribuição cadastrada.</p>
                <Link :href="route('admin.atribuicoes.create')" class="btn btn-primary mt-4">
                    Criar Primeira Atribuição
                </Link>
            </div>

            <div v-else class="card">
                <h2 class="card-title">Lista de Atribuições</h2>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-codevilla-border">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-codevilla-text">
                                    Professor
                                </th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-codevilla-text">
                                    Turma
                                </th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-codevilla-text">
                                    Turno
                                </th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-codevilla-text">
                                    Disciplina
                                </th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-codevilla-text">
                                    Ano Letivo
                                </th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-codevilla-text">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="atribuicao in atribuicoes.data"
                                :key="atribuicao.id"
                                class="border-b border-codevilla-border hover:bg-codevilla-bg transition"
                            >
                                <td class="py-3 px-4">
                                    <span class="font-medium text-codevilla-text">
                                        {{ atribuicao.professor_nome }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-codevilla-text">
                                        {{ atribuicao.turma_nome }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="badge badge-blue">
                                        {{ atribuicao.turma_turno }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-codevilla-text">
                                        {{ atribuicao.disciplina_nome }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-codevilla-muted text-sm">
                                        {{ atribuicao.ano_letivo }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <button
                                        @click="deleteAtribuicao(atribuicao)"
                                        class="btn btn-sm text-white bg-red-600 hover:bg-red-700"
                                    >
                                        Remover
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div v-if="atribuicoes.links && atribuicoes.links.length > 3" class="mt-6">
                    <div class="flex justify-center gap-2">
                        <Link
                            v-for="(link, index) in atribuicoes.links"
                            :key="index"
                            :href="link.url"
                            v-html="link.label"
                            :class="[
                                'px-4 py-2 rounded-lg text-sm font-medium transition',
                                link.active
                                    ? 'bg-codevilla-primary text-white'
                                    : link.url
                                    ? 'bg-white text-codevilla-text border border-codevilla-border hover:bg-codevilla-bg'
                                    : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                            ]"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
