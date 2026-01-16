<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTable from '@/Components/DataTable.vue';
import EmptyState from '@/Components/EmptyState.vue';
import Pagination from '@/Components/Pagination.vue';
import { useCrud } from '@/Composables/useCrud';
import { AcademicCapIcon, TrashIcon } from '@heroicons/vue/24/outline';

defineProps({
    atribuicoes: Object,
});

const { deleteResource } = useCrud();

const deleteAtribuicao = (atribuicao) => {
    deleteResource(
        'admin.atribuicoes.destroy',
        atribuicao.id,
        `Deseja remover a atribuição de ${atribuicao.professor_nome}?`
    );
};

const tableColumns = [
    { key: 'professor_nome', label: 'Professor' },
    { key: 'turma_nome', label: 'Turma' },
    { key: 'turma_turno', label: 'Turno' },
    { key: 'disciplina_nome', label: 'Disciplina' },
    { key: 'ano_letivo', label: 'Ano Letivo' },
];
</script>

<template>
    <Head title="Atribuições de Professores" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-codevilla-text">Atribuições de Professores</h1>
                            <p class="mt-1 text-sm text-codevilla-muted">Gerencie as atribuições de professores às turmas e disciplinas</p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <Link
                                :href="route('admin.atribuicoes.create')"
                                class="inline-flex items-center px-4 py-2 bg-codevilla-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-codevilla-accent focus:outline-none focus:ring-2 focus:ring-codevilla-accent focus:ring-offset-2 transition"
                            >
                                <AcademicCapIcon class="w-5 h-5 mr-2" />
                                Nova Atribuição
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Tabela -->
                <div v-if="atribuicoes.data.length > 0" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <DataTable :columns="tableColumns" :data="atribuicoes.data">
                        <template #cell-turma_turno="{ row }">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ row.turma_turno }}
                            </span>
                        </template>
                        <template #cell-ano_letivo="{ row }">
                            <span class="text-sm text-codevilla-muted">
                                {{ row.ano_letivo }}
                            </span>
                        </template>
                        <template #actions="{ row }">
                            <div class="flex items-center justify-end space-x-2">
                                <button
                                    @click="deleteAtribuicao(row)"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-xs font-medium"
                                >
                                    <TrashIcon class="w-4 h-4 mr-1" />
                                    Remover
                                </button>
                            </div>
                        </template>
                    </DataTable>

                    <div class="px-6 py-4 border-t border-gray-200">
                        <Pagination :data="atribuicoes" route-name="admin.atribuicoes.index" />
                    </div>
                </div>

                <!-- Estado Vazio -->
                <EmptyState
                    v-else
                    icon="users"
                    title="Nenhuma atribuição cadastrada"
                    description="Comece criando a primeira atribuição de professor."
                >
                    <template #action>
                        <Link
                            :href="route('admin.atribuicoes.create')"
                            class="inline-flex items-center px-4 py-2 bg-codevilla-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-codevilla-accent focus:outline-none focus:ring-2 focus:ring-codevilla-accent focus:ring-offset-2 transition"
                        >
                            <AcademicCapIcon class="w-5 h-5 mr-2" />
                            Criar Primeira Atribuição
                        </Link>
                    </template>
                </EmptyState>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
