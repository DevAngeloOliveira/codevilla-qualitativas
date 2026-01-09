<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { MagnifyingGlassIcon, PlusIcon, PencilIcon, TrashIcon, UserGroupIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    users: Object,
    filters: Object,
});

const search = ref(props.filters.search || '');
const role = ref(props.filters.role || '');

const filterUsers = () => {
    router.get(route('desenvolvedor.users.index'), {
        search: search.value,
        role: role.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

const deleteUser = (user) => {
    if (confirm(`Tem certeza que deseja excluir o usuário ${user.name}?`)) {
        router.delete(route('desenvolvedor.users.destroy', user.id));
    }
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
</script>

<template>
    <Head title="Gerenciar Usuários" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <UserGroupIcon class="h-8 w-8 text-purple-600 mr-3" />
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">Gerenciar Usuários</h2>
                                    <p class="text-sm text-gray-600">Controle completo de usuários do sistema</p>
                                </div>
                            </div>
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

                <!-- Filters -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pesquisar</label>
                                <div class="relative">
                                    <MagnifyingGlassIcon class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
                                    <input
                                        type="text"
                                        v-model="search"
                                        @input="filterUsers"
                                        placeholder="Nome ou email..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Cargo</label>
                                <select
                                    v-model="role"
                                    @change="filterUsers"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                >
                                    <option value="">Todos</option>
                                    <option value="desenvolvedor">Desenvolvedor</option>
                                    <option value="coordenacao">Coordenação</option>
                                    <option value="professor">Professor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Usuário
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cargo
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ user.email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="getRoleBadgeClass(user.role)" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                                            {{ getRoleLabel(user.role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="user.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                                            {{ user.is_active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link
                                            :href="route('desenvolvedor.users.edit', user.id)"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors mr-2"
                                        >
                                            <PencilIcon class="h-4 w-4 mr-1" />
                                            Editar
                                        </Link>
                                        <button
                                            @click="deleteUser(user)"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                        >
                                            <TrashIcon class="h-4 w-4 mr-1" />
                                            Excluir
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="users.data.length === 0">
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        Nenhum usuário encontrado
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="users.links.length > 3" class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                        <div class="flex justify-center space-x-2">
                            <Link
                                v-for="(link, index) in users.links"
                                :key="index"
                                :href="link.url"
                                :class="[
                                    'px-4 py-2 rounded-lg text-sm font-medium transition-colors',
                                    link.active
                                        ? 'bg-purple-600 text-white'
                                        : link.url
                                        ? 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300'
                                        : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                ]"
                                :disabled="!link.url"
                                v-html="link.label"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
