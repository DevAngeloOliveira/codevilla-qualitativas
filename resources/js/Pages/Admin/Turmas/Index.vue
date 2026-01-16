<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import EmptyState from '@/Components/EmptyState.vue';
import Pagination from '@/Components/Pagination.vue';
import { useCrud } from '@/Composables/useCrud';

const props = defineProps({
    turmas: Object,
});

const { deleteResource } = useCrud();

const deleteTurma = (turma) => {
    deleteResource(
        'admin.turmas.destroy',
        turma.uuid,
        `Tem certeza que deseja excluir a turma ${turma.nome}?`
    );
};
</script>

<template>
    <Head title="Gerenciar Turmas" />

    <AuthenticatedLayout>
        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Turmas</h1>
                <p class="mt-1 text-sm text-gray-600">Gerencie as turmas do colégio</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <!-- Botões de Exportação -->
                <a
                    :href="route('admin.turmas.export.pdf')"
                    class="btn bg-red-600 hover:bg-red-700 text-white flex items-center gap-2"
                    target="_blank"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    PDF
                </a>
                <a
                    :href="route('admin.turmas.export.excel')"
                    class="btn bg-green-600 hover:bg-green-700 text-white flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Excel
                </a>
                <Link :href="route('admin.turmas.create')" class="btn btn-primary">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nova Turma
                </Link>
            </div>
        </div>

        <!-- Empty State -->
        <EmptyState
            v-if="turmas.data.length === 0"
            title="Nenhuma turma cadastrada"
            description="Comece criando sua primeira turma para organizar os alunos"
            icon="folder"
        >
            <template #action>
                <Link :href="route('admin.turmas.create')" class="btn btn-primary mt-4">
                    Criar Primeira Turma
                </Link>
            </template>
        </EmptyState>

        <!-- Grid de Turmas -->
        <div v-else>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Cards de Turma usando componente Card -->
                <Card
                    v-for="turma in turmas.data"
                    :key="turma.id"
                >
                    <template #header>
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-xl text-white mb-1">
                                    {{ turma.nome }}
                </h3>
                                <p class="text-white/80 text-sm">
                                    Ano Letivo {{ turma.ano_letivo }}
                                </p>
                            </div>
                            <span
                                v-if="turma.ativa"
                                class="bg-codevilla-success text-white text-xs font-semibold px-3 py-1 rounded-full"
                            >
                                Ativa
                            </span>
                            <span
                                v-else
                                class="bg-gray-400 text-white text-xs font-semibold px-3 py-1 rounded-full"
                            >
                                Inativa
                            </span>
                        </div>
                    </template>

                    <!-- Corpo do Card -->
                    <div class="space-y-3 mb-5">
                        <!-- Turno -->
                        <div class="flex items-center justify-between p-3 bg-codevilla-bg rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-codevilla-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm text-codevilla-muted font-medium">Turno</span>
                            </div>
                            <span
                                :class="turma.turno === 'Matutino'
                                    ? 'bg-yellow-100 text-yellow-800 border-yellow-300'
                                    : 'bg-blue-100 text-blue-800 border-blue-300'"
                                class="text-xs font-semibold px-3 py-1 rounded-full border"
                            >
                                {{ turma.turno }}
                            </span>
                        </div>

                        <!-- Alunos -->
                        <div class="flex items-center justify-between p-3 bg-codevilla-bg rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-codevilla-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="text-sm text-codevilla-muted font-medium">Alunos</span>
                            </div>
                            <span class="text-lg font-bold text-codevilla-primary">
                                {{ turma.alunos_count || 0 }}
                            </span>
                        </div>

                        <!-- Segmento -->
                        <div class="flex items-center p-3 bg-codevilla-bg rounded-lg">
                            <svg class="w-5 h-5 mr-2 text-codevilla-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span class="text-xs text-codevilla-muted">{{ turma.segmento }}</span>
                        </div>
                    </div>

                    <!-- Footer com Botões -->
                    <template #footer>
                        <div class="flex gap-2">
                            <Link
                                :href="route('admin.turmas.detalhes', turma.uuid)"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors text-center text-sm"
                            >
                                <svg class="w-4 h-4 inline-block mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Ver
                            </Link>
                            <Link
                                :href="route('admin.turmas.edit', turma.uuid)"
                                class="flex-1 bg-codevilla-accent hover:bg-codevilla-primary text-white font-medium py-2.5 px-4 rounded-lg transition-colors text-center text-sm"
                            >
                                <svg class="w-4 h-4 inline-block mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar
                            </Link>
                            <button
                                @click="deleteTurma(turma)"
                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </Card>
            </div>

            <!-- Paginação -->
            <Pagination
                v-if="turmas.links && turmas.links.length > 3"
                :data="turmas"
                route-name="admin.turmas.index"
                class="mt-6"
            />
        </div>
    </AuthenticatedLayout>
</template>
