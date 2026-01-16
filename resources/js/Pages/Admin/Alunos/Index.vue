<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import DataTable from '@/Components/DataTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import EmptyState from '@/Components/EmptyState.vue';
import Pagination from '@/Components/Pagination.vue';
import { useCrud } from '@/Composables/useCrud';
import {
    FunnelIcon,
    PencilIcon,
    TrashIcon,
    UserGroupIcon,
    XMarkIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    alunos: Object,
    turma: Object,
    turmas: Array,
    filters: Object,
    stats: Object,
});

const { deleteResource } = useCrud();

// Estados locais para filtros
const selectedTurma = ref(props.filters.turma_id || '');
const perPage = ref(props.filters.per_page || 12);

const applyFilters = () => {
    router.get(route('admin.alunos.index'), {
        search: props.filters.search || '',
        turma_id: selectedTurma.value,
        per_page: perPage.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    selectedTurma.value = '';
    perPage.value = 12;
    router.get(route('admin.alunos.index'), {}, {
        preserveState: false,
    });
};

const deleteAluno = (aluno) => {
    deleteResource(
        'admin.alunos.destroy',
        aluno.uuid,
        `Tem certeza que deseja excluir o aluno ${aluno.nome}?`
    );
};

const hasActiveFilters = () => {
    return props.filters.search || selectedTurma.value || perPage.value != 12;
};

const tableColumns = [
    { key: 'numero_chamada', label: 'Nº', cellClass: 'text-center' },
    { key: 'foto_url', label: 'Foto' },
    { key: 'nome', label: 'Nome' },
    { key: 'turma', label: 'Turma' },
];
</script>

<template>
    <Head title="Alunos" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-codevilla-text">Gestão de Alunos</h1>
                            <p class="mt-1 text-sm text-codevilla-muted">{{ stats.total }} alunos cadastrados no total</p>
                        </div>
                        <div class="mt-4 sm:mt-0 px-4 py-2 bg-blue-50 border border-blue-200 rounded-lg text-blue-700">
                            <p class="text-sm">Para adicionar um aluno, acesse a turma desejada</p>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total Geral</p>
                                <p class="text-3xl font-bold mt-2">{{ stats.total }}</p>
                            </div>
                            <UserGroupIcon class="w-12 h-12 text-blue-200" />
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Turmas Ativas</p>
                                <p class="text-3xl font-bold mt-2">{{ turmas.length }}</p>
                            </div>
                            <UserGroupIcon class="w-12 h-12 text-green-200" />
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Média por Turma</p>
                                <p class="text-3xl font-bold mt-2">{{ turmas.length > 0 ? Math.round(stats.total / turmas.length) : 0 }}</p>
                            </div>
                            <UserGroupIcon class="w-12 h-12 text-purple-200" />
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm font-medium">Filtros Ativos</p>
                                <p class="text-3xl font-bold mt-2">{{ hasActiveFilters() ? 'Sim' : 'Não' }}</p>
                            </div>
                            <FunnelIcon class="w-12 h-12 text-orange-200" />
                        </div>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <SearchInput
                                route-name="admin.alunos.index"
                                placeholder="Nome ou número de chamada..."
                                :initial-value="filters.search"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Turma</label>
                            <select
                                v-model="selectedTurma"
                                @change="applyFilters"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-codevilla-accent focus:ring focus:ring-codevilla-accent focus:ring-opacity-50"
                            >
                                <option value="">Todas as turmas</option>
                                <option v-for="t in turmas" :key="t.id" :value="t.id">
                                    {{ t.nome }} ({{ Object.values(stats.por_turma)[turmas.indexOf(t)] || 0 }} alunos)
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Por página</label>
                            <select
                                v-model="perPage"
                                @change="applyFilters"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-codevilla-accent focus:ring focus:ring-codevilla-accent focus:ring-opacity-50"
                            >
                                <option :value="12">12</option>
                                <option :value="24">24</option>
                                <option :value="48">48</option>
                                <option :value="96">96</option>
                            </select>
                        </div>
                    </div>
                    <div v-if="hasActiveFilters()" class="mt-4 flex justify-end">
                        <button
                            @click="clearFilters"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-codevilla-accent"
                        >
                            <XMarkIcon class="w-4 h-4 mr-1" />
                            Limpar Filtros
                        </button>
                    </div>
                </div>

                <!-- Tabela de Alunos -->
                <div v-if="alunos.data.length > 0" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <DataTable :columns="tableColumns" :data="alunos.data">
                        <template #cell-foto_url="{ row }">
                            <img
                                :src="row.foto_url || '/assets/images/placeholder-icon.png'"
                                :alt="row.nome"
                                class="w-10 h-10 rounded-full object-cover border-2 border-gray-200"
                            />
                        </template>
                        <template #cell-turma="{ row }">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ row.turma.nome }}
                            </span>
                        </template>
                        <template #actions="{ row }">
                            <div class="flex items-center space-x-2">
                                <Link
                                    :href="route('admin.alunos.edit', row.uuid)"
                                    class="inline-flex items-center px-3 py-1.5 bg-codevilla-accent text-white rounded-lg hover:bg-codevilla-primary transition"
                                >
                                    <PencilIcon class="w-4 h-4 mr-1" />
                                    Editar
                                </Link>
                                <button
                                    @click="deleteAluno(row)"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                >
                                    <TrashIcon class="w-4 h-4 mr-1" />
                                    Excluir
                                </button>
                            </div>
                        </template>
                    </DataTable>

                    <div class="px-6 py-4 border-t border-gray-200">
                        <Pagination :data="alunos" route-name="admin.alunos.index" />
                    </div>
                </div>

                <!-- Estado Vazio -->
                <EmptyState
                    v-else
                    icon="users"
                    :title="hasActiveFilters() ? 'Nenhum aluno encontrado' : 'Nenhum aluno cadastrado'"
                    :description="hasActiveFilters() ? 'Tente ajustar os filtros de pesquisa' : 'Comece cadastrando seu primeiro aluno'"
                >
                    <template #action>
                        <button
                            v-if="hasActiveFilters()"
                            @click="clearFilters"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition"
                        >
                            <XMarkIcon class="w-5 h-5 mr-2" />
                            Limpar Filtros
                        </button>
                        <div v-else class="text-center">
                            <p class="mb-2 text-gray-600">Para adicionar alunos, acesse a turma desejada</p>
                            <Link
                                :href="route('admin.turmas.index')"
                                class="inline-flex items-center px-4 py-2 bg-codevilla-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-codevilla-accent focus:outline-none focus:ring-2 focus:ring-codevilla-accent focus:ring-offset-2 transition"
                            >
                                Ver Turmas
                            </Link>
                        </div>
                    </template>
                </EmptyState>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
