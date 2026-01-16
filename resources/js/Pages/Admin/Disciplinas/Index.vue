<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import DataTable from '@/Components/DataTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import EmptyState from '@/Components/EmptyState.vue';
import Pagination from '@/Components/Pagination.vue';
import { useCrud } from '@/Composables/useCrud';
import { BookOpenIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    disciplinas: Object,
    filters: Object,
});

const { deleteResource } = useCrud();

const deleteDisciplina = (disciplina) => {
    deleteResource(
        'admin.disciplinas.destroy',
        disciplina.id,
        `Tem certeza que deseja remover a disciplina ${disciplina.nome}?`
    );
};

const tableColumns = [
    { key: 'nome', label: 'Nome' },
];
</script>

<template>
    <Head title="Disciplinas" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-codevilla-text">Disciplinas</h1>
                            <p class="mt-1 text-sm text-codevilla-muted">Gerencie as disciplinas do sistema</p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <Link
                                :href="route('admin.disciplinas.create')"
                                class="inline-flex items-center px-4 py-2 bg-codevilla-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-codevilla-accent focus:outline-none focus:ring-2 focus:ring-codevilla-accent focus:ring-offset-2 transition"
                            >
                                <BookOpenIcon class="w-5 h-5 mr-2" />
                                Nova Disciplina
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Busca -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <SearchInput
                        route-name="admin.disciplinas.index"
                        placeholder="Buscar por nome..."
                        :initial-value="filters.search"
                    />
                </div>

                <!-- Tabela -->
                <div v-if="disciplinas.data.length > 0" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <DataTable :columns="tableColumns" :data="disciplinas.data">
                        <template #actions="{ row }">
                            <div class="flex items-center justify-end space-x-2">
                                <Link
                                    :href="route('admin.disciplinas.edit', row.id)"
                                    class="text-codevilla-accent hover:text-codevilla-primary transition"
                                >
                                    <PencilIcon class="w-5 h-5" />
                                </Link>
                                <button
                                    @click="deleteDisciplina(row)"
                                    class="text-red-600 hover:text-red-800 transition"
                                >
                                    <TrashIcon class="w-5 h-5" />
                                </button>
                            </div>
                        </template>
                    </DataTable>

                    <div class="px-6 py-4 border-t border-gray-200">
                        <Pagination :data="disciplinas" route-name="admin.disciplinas.index" />
                    </div>
                </div>

                <!-- Estado Vazio -->
                <EmptyState
                    v-else
                    icon="box"
                    title="Nenhuma disciplina encontrada"
                    description="Comece adicionando a primeira disciplina."
                >
                    <template #action>
                        <Link
                            :href="route('admin.disciplinas.create')"
                            class="inline-flex items-center px-4 py-2 bg-codevilla-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-codevilla-accent focus:outline-none focus:ring-2 focus:ring-codevilla-accent focus:ring-offset-2 transition"
                        >
                            <BookOpenIcon class="w-5 h-5 mr-2" />
                            Adicionar Primeira Disciplina
                        </Link>
                    </template>
                </EmptyState>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
