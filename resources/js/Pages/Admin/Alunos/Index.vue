<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import {
    MagnifyingGlassIcon,
    FunnelIcon,
    PlusIcon,
    PencilIcon,
    TrashIcon,
    ArrowsUpDownIcon,
    ChevronUpIcon,
    ChevronDownIcon,
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

// Estados locais para filtros
const search = ref(props.filters.search || '');
const selectedTurma = ref(props.filters.turma_id || '');
const perPage = ref(props.filters.per_page || 12);
const sortBy = ref(props.filters.sort_by || 'nome');
const sortOrder = ref(props.filters.sort_order || 'asc');
const showFilters = ref(false);

// Debounce para pesquisa
let searchTimeout = null;
watch(search, (value) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 500);
});

const applyFilters = () => {
    router.get(route('admin.alunos.index'), {
        search: search.value,
        turma_id: selectedTurma.value,
        per_page: perPage.value,
        sort_by: sortBy.value,
        sort_order: sortOrder.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    search.value = '';
    selectedTurma.value = '';
    perPage.value = 12;
    sortBy.value = 'nome';
    sortOrder.value = 'asc';
    applyFilters();
};

const toggleSort = (field) => {
    if (sortBy.value === field) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortBy.value = field;
        sortOrder.value = 'asc';
    }
    applyFilters();
};

const deleteAluno = (id) => {
    if (confirm('Tem certeza que deseja excluir este aluno?')) {
        router.delete(route('admin.alunos.destroy', id), {
            preserveScroll: true,
        });
    }
};

const hasActiveFilters = () => {
    return search.value || selectedTurma.value || perPage.value != 12;
};
</script>

<template>
    <Head title="Alunos" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Gestão de Alunos</h1>
                            <p class="mt-1 text-gray-600">{{ stats.total }} alunos cadastrados no total</p>
                        </div>
                        <div class="px-4 py-2 text-blue-700 border border-blue-200 rounded-lg bg-blue-50">
                            <p class="text-sm">Para adicionar um aluno, acesse a turma desejada</p>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
                    <div class="p-4 text-white shadow-lg bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-blue-100">Total Geral</p>
                                <p class="mt-1 text-2xl font-bold">{{ stats.total }}</p>
                            </div>
                            <UserGroupIcon class="w-10 h-10 text-blue-200" />
                        </div>
                    </div>
                    <div class="p-4 text-white shadow-lg bg-gradient-to-br from-green-500 to-green-600 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-green-100">Turmas Ativas</p>
                                <p class="mt-1 text-2xl font-bold">{{ turmas.length }}</p>
                            </div>
                            <UserGroupIcon class="w-10 h-10 text-green-200" />
                        </div>
                    </div>
                    <div class="p-4 text-white shadow-lg bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-purple-100">Média por Turma</p>
                                <p class="mt-1 text-2xl font-bold">{{ turmas.length > 0 ? Math.round(stats.total / turmas.length) : 0 }}</p>
                            </div>
                            <UserGroupIcon class="w-10 h-10 text-purple-200" />
                        </div>
                    </div>
                    <div class="p-4 text-white shadow-lg bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-orange-100">Filtros Ativos</p>
                                <p class="mt-1 text-2xl font-bold">{{ hasActiveFilters() ? 'Sim' : 'Não' }}</p>
                            </div>
                            <FunnelIcon class="w-10 h-10 text-orange-200" />
                        </div>
                    </div>
                </div>

                <!-- Barra de Filtros e Pesquisa -->
                <div class="mb-6 bg-white shadow-sm rounded-xl">
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                            <!-- Pesquisa -->
                            <div class="md:col-span-5">
                                <label class="block mb-2 text-sm font-medium text-gray-700">Pesquisar</label>
                                <div class="relative">
                                    <MagnifyingGlassIcon class="absolute w-5 h-5 text-gray-400 transform -translate-y-1/2 left-3 top-1/2" />
                                    <input
                                        v-model="search"
                                        type="text"
                                        placeholder="Nome ou número de chamada..."
                                        class="w-full py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    />
                                </div>
                            </div>

                            <!-- Filtro Turma -->
                            <div class="md:col-span-4">
                                <label class="block mb-2 text-sm font-medium text-gray-700">Turma</label>
                                <select
                                    v-model="selectedTurma"
                                    @change="applyFilters"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    <option value="">Todas as turmas</option>
                                    <option v-for="t in turmas" :key="t.id" :value="t.id">
                                        {{ t.nome }} ({{ Object.values(stats.por_turma)[turmas.indexOf(t)] || 0 }} alunos)
                                    </option>
                                </select>
                            </div>

                            <!-- Por Página -->
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-700">Por página</label>
                                <select
                                    v-model="perPage"
                                    @change="applyFilters"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    <option :value="12">12</option>
                                    <option :value="24">24</option>
                                    <option :value="48">48</option>
                                    <option :value="96">96</option>
                                </select>
                            </div>

                            <!-- Botão Limpar Filtros -->
                            <div class="flex items-end md:col-span-1">
                                <button
                                    v-if="hasActiveFilters()"
                                    @click="clearFilters"
                                    class="flex items-center justify-center w-full px-3 py-2 text-gray-700 transition bg-gray-200 rounded-lg hover:bg-gray-300"
                                    title="Limpar filtros"
                                >
                                    <XMarkIcon class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabela de Alunos -->
                <div v-if="alunos.data.length > 0" class="overflow-hidden bg-white shadow-sm rounded-xl">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left">
                                        <button
                                            @click="toggleSort('numero_chamada')"
                                            class="flex items-center text-xs font-medium tracking-wider text-gray-500 uppercase hover:text-gray-700"
                                        >
                                            Nº
                                            <ArrowsUpDownIcon v-if="sortBy !== 'numero_chamada'" class="w-4 h-4 ml-1" />
                                            <ChevronUpIcon v-else-if="sortOrder === 'asc'" class="w-4 h-4 ml-1" />
                                            <ChevronDownIcon v-else class="w-4 h-4 ml-1" />
                                        </button>
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Foto
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        <button
                                            @click="toggleSort('nome')"
                                            class="flex items-center text-xs font-medium tracking-wider text-gray-500 uppercase hover:text-gray-700"
                                        >
                                            Nome
                                            <ArrowsUpDownIcon v-if="sortBy !== 'nome'" class="w-4 h-4 ml-1" />
                                            <ChevronUpIcon v-else-if="sortOrder === 'asc'" class="w-4 h-4 ml-1" />
                                            <ChevronDownIcon v-else class="w-4 h-4 ml-1" />
                                        </button>
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        <button
                                            @click="toggleSort('turma')"
                                            class="flex items-center text-xs font-medium tracking-wider text-gray-500 uppercase hover:text-gray-700"
                                        >
                                            Turma
                                            <ArrowsUpDownIcon v-if="sortBy !== 'turma'" class="w-4 h-4 ml-1" />
                                            <ChevronUpIcon v-else-if="sortOrder === 'asc'" class="w-4 h-4 ml-1" />
                                            <ChevronDownIcon v-else class="w-4 h-4 ml-1" />
                                        </button>
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="aluno in alunos.data" :key="aluno.id" class="transition hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full">
                                            {{ aluno.numero_chamada }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img
                                            :src="aluno.foto_url || '/assets/images/placeholder-icon.png'"
                                            :alt="aluno.nome"
                                            class="object-cover w-10 h-10 border-2 border-gray-200 rounded-full"
                                        />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ aluno.nome }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            {{ aluno.turma.nome }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <Link
                                            :href="route('admin.alunos.edit', aluno.uuid)"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition mr-2"
                                        >
                                            <PencilIcon class="w-4 h-4 mr-1" />
                                            Editar
                                        </Link>
                                        <button
                                            @click="deleteAluno(aluno.uuid)"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                        >
                                            <TrashIcon class="w-4 h-4 mr-1" />
                                            Excluir
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-700">
                                Mostrando <span class="font-medium">{{ alunos.from }}</span> a
                                <span class="font-medium">{{ alunos.to }}</span> de
                                <span class="font-medium">{{ alunos.total }}</span> alunos
                            </p>
                            <div class="flex space-x-2">
                                <Link
                                    v-for="(link, index) in alunos.links"
                                    :key="index"
                                    :href="link.url"
                                    :class="[
                                        'px-4 py-2 rounded-lg text-sm font-medium transition-colors',
                                        link.active
                                            ? 'bg-blue-600 text-white'
                                            : link.url
                                            ? 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300'
                                            : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                    ]"
                                    :disabled="!link.url"
                                    v-html="link.label"
                                    preserve-scroll
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estado Vazio -->
                <div v-else class="p-12 text-center bg-white shadow-sm rounded-xl">
                    <UserGroupIcon class="w-16 h-16 mx-auto mb-4 text-gray-400" />
                    <h3 class="mb-2 text-lg font-medium text-gray-900">Nenhum aluno encontrado</h3>
                    <p class="mb-6 text-gray-500">
                        {{ hasActiveFilters() ? 'Tente ajustar os filtros de pesquisa' : 'Comece cadastrando seu primeiro aluno' }}
                    </p>
                    <button
                        v-if="hasActiveFilters()"
                        @click="clearFilters"
                        class="inline-flex items-center px-4 py-2 text-gray-700 transition bg-gray-200 rounded-lg hover:bg-gray-300"
                    >
                        <XMarkIcon class="w-5 h-5 mr-2" />
                        Limpar Filtros
                    </button>
                    <div v-else class="py-4 text-center">
                        <p class="mb-2 text-gray-600">Para adicionar alunos, acesse a turma desejada</p>
                        <Link
                            :href="route('admin.turmas.index')"
                            class="inline-flex items-center px-4 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700"
                        >
                            Ver Turmas
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
