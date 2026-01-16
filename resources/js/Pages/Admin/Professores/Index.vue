<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import DataTable from '@/Components/DataTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import EmptyState from '@/Components/EmptyState.vue';
import Pagination from '@/Components/Pagination.vue';
import { useCrud } from '@/Composables/useCrud';
import { UserIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    professores: Object,
    filters: Object,
});

const { deleteResource } = useCrud();

const deleteProfessor = (professor) => {
    deleteResource(
        'admin.professores.destroy',
        professor.id,
        `Tem certeza que deseja remover o professor ${professor.name}?`
    );
};

const tableColumns = [
    { key: 'name', label: 'Nome' },
    { key: 'email', label: 'Email' },
    { key: 'is_active', label: 'Status' },
];
</script>

<template>
    <Head title="Professores" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-codevilla-text">Professores</h1>
                            <p class="mt-1 text-sm text-codevilla-muted">Gerencie os professores do sistema</p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <Link
                                :href="route('admin.professores.create')"
                                class="inline-flex items-center px-4 py-2 bg-codevilla-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-codevilla-accent focus:outline-none focus:ring-2 focus:ring-codevilla-accent focus:ring-offset-2 transition"
                            >
                                <UserIcon class="w-5 h-5 mr-2" />
                                Novo Professor
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Busca -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <SearchInput
                        route-name="admin.professores.index"
                        placeholder="Buscar por nome ou email..."
                        :initial-value="filters.search"
                    />
                </div>

                <!-- Tabela -->
                <div v-if="professores.data.length > 0" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <DataTable :columns="tableColumns" :data="professores.data">
                        <template #cell-is_active="{ row }">
                            <span
                                v-if="row.is_active"
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                            >
                                Ativo
                            </span>
                            <span
                                v-else
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800"
                            >
                                Inativo
                            </span>
                        </template>
                        <template #actions="{ row }">
                            <div class="flex items-center justify-end space-x-2">
                                <Link
                                    :href="route('admin.professores.edit', row.id)"
                                    class="text-codevilla-accent hover:text-codevilla-primary transition"
                                >
                                    <PencilIcon class="w-5 h-5" />
                                </Link>
                                <button
                                    @click="deleteProfessor(row)"
                                    class="text-red-600 hover:text-red-800 transition"
                                >
                                    <TrashIcon class="w-5 h-5" />
                                </button>
                            </div>
                        </template>
                    </DataTable>

                    <div class="px-6 py-4 border-t border-gray-200">
                        <Pagination :data="professores" route-name="admin.professores.index" />
                    </div>
                </div>

                <!-- Estado Vazio -->
                <EmptyState
                    v-else
                    icon="users"
                    title="Nenhum professor encontrado"
                    description="Comece adicionando o primeiro professor."
                >
                    <template #action>
                        <Link
                            :href="route('admin.professores.create')"
                            class="inline-flex items-center px-4 py-2 bg-codevilla-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-codevilla-accent focus:outline-none focus:ring-2 focus:ring-codevilla-accent focus:ring-offset-2 transition"
                        >
                            <UserIcon class="w-5 h-5 mr-2" />
                            Adicionar Primeiro Professor
                        </Link>
                    </template>
                </EmptyState>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
