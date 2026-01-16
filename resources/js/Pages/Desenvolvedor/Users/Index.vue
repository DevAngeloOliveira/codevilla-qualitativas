<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import DataTable from '@/Components/DataTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import EmptyState from '@/Components/EmptyState.vue';
import Pagination from '@/Components/Pagination.vue';
import { useCrud } from '@/Composables/useCrud';
import { UserGroupIcon, PlusIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    users: Object,
    filters: Object,
});

const { deleteResource } = useCrud();

const role = ref(props.filters.role || '');

const filterByRole = () => {
    router.get(route('desenvolvedor.users.index'), {
        search: props.filters.search || '',
        role: role.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

const deleteUser = (user) => {
    deleteResource(
        'desenvolvedor.users.destroy',
        user.id,
        `Tem certeza que deseja excluir o usuário ${user.name}?`
    );
};

const getRoleBadgeClass = (userRole) => {
    const classes = {
        'desenvolvedor': 'bg-purple-100 text-purple-800',
        'coordenacao': 'bg-blue-100 text-blue-800',
        'professor': 'bg-green-100 text-green-800',
    };
    return classes[userRole] || 'bg-gray-100 text-gray-800';
};

const getRoleLabel = (userRole) => {
    const labels = {
        'desenvolvedor': 'Desenvolvedor',
        'coordenacao': 'Coordenação',
        'professor': 'Professor',
    };
    return labels[userRole] || userRole;
};

const tableColumns = [
    { key: 'name', label: 'Usuário' },
    { key: 'email', label: 'Email' },
    { key: 'role', label: 'Cargo' },
    { key: 'is_active', label: 'Status' },
];
</script>

<template>
    <Head title="Gerenciar Usuários" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center">
                            <UserGroupIcon class="h-8 w-8 text-purple-600 mr-3" />
                            <div>
                                <h1 class="text-3xl font-bold text-codevilla-text">Gerenciar Usuários</h1>
                                <p class="mt-1 text-sm text-codevilla-muted">Controle completo de usuários do sistema</p>
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <Link
                                :href="route('desenvolvedor.users.create')"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                            >
                                <PlusIcon class="h-5 w-5 mr-2" />
                                Novo Usuário
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <SearchInput
                                route-name="desenvolvedor.users.index"
                                placeholder="Nome ou email..."
                                :initial-value="filters.search"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Filtrar por Cargo</label>
                            <select
                                v-model="role"
                                @change="filterByRole"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                            >
                                <option value="">Todos</option>
                                <option value="desenvolvedor">Desenvolvedor</option>
                                <option value="coordenacao">Coordenação</option>
                                <option value="professor">Professor</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tabela -->
                <div v-if="users.data.length > 0" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <DataTable :columns="tableColumns" :data="users.data">
                        <template #cell-role="{ row }">
                            <span :class="getRoleBadgeClass(row.role)" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                {{ getRoleLabel(row.role) }}
                            </span>
                        </template>
                        <template #cell-is_active="{ row }">
                            <span
                                :class="row.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            >
                                {{ row.is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </template>
                        <template #actions="{ row }">
                            <div class="flex items-center justify-end space-x-2">
                                <Link
                                    :href="route('desenvolvedor.users.edit', row.id)"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-xs font-medium"
                                >
                                    <PencilIcon class="h-4 w-4 mr-1" />
                                    Editar
                                </Link>
                                <button
                                    @click="deleteUser(row)"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-xs font-medium"
                                >
                                    <TrashIcon class="h-4 w-4 mr-1" />
                                    Excluir
                                </button>
                            </div>
                        </template>
                    </DataTable>

                    <div class="px-6 py-4 border-t border-gray-200">
                        <Pagination :data="users" route-name="desenvolvedor.users.index" />
                    </div>
                </div>

                <!-- Estado Vazio -->
                <EmptyState
                    v-else
                    icon="users"
                    title="Nenhum usuário encontrado"
                    description="Comece adicionando o primeiro usuário ao sistema."
                >
                    <template #action>
                        <Link
                            :href="route('desenvolvedor.users.create')"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                            <PlusIcon class="h-5 w-5 mr-2" />
                            Adicionar Primeiro Usuário
                        </Link>
                    </template>
                </EmptyState>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
