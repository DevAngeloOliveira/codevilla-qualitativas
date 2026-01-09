<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    disciplinas: Object,
    filters: Object,
});

const search = ref(props.filters.search || '');

const buscar = () => {
    router.get(route('admin.disciplinas.index'), { search: search.value }, {
        preserveState: true,
        replace: true,
    });
};

const deletar = (id) => {
    if (confirm('Tem certeza que deseja remover esta disciplina?')) {
        router.delete(route('admin.disciplinas.destroy', id));
    }
};
</script>

<template>
    <Head title="Disciplinas" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Disciplinas</h1>
                                <p class="text-gray-600">Gerencie as disciplinas do sistema</p>
                            </div>
                            <Link :href="route('admin.disciplinas.create')" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Nova Disciplina
                            </Link>
                        </div>

                        <!-- Busca -->
                        <div class="mb-6">
                            <div class="flex gap-2">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Buscar por nome..."
                                    @keyup.enter="buscar"
                                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                />
                                <button @click="buscar" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                    Buscar
                                </button>
                            </div>
                        </div>

                        <!-- Tabela -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="disciplina in disciplinas.data" :key="disciplina.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ disciplina.nome }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <Link :href="route('admin.disciplinas.edit', disciplina.id)" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                Editar
                                            </Link>
                                            <button @click="deletar(disciplina.id)" class="text-red-600 hover:text-red-900">
                                                Remover
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <div v-if="disciplinas.links.length > 3" class="mt-6 flex justify-between items-center">
                            <div class="text-sm text-gray-700">
                                Mostrando {{ disciplinas.from }} a {{ disciplinas.to }} de {{ disciplinas.total }} registros
                            </div>
                            <div class="flex gap-2">
                                <Link
                                    v-for="(link, index) in disciplinas.links"
                                    :key="index"
                                    :href="link.url"
                                    v-html="link.label"
                                    :class="[
                                        'px-3 py-2 rounded',
                                        link.active ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50',
                                        !link.url ? 'opacity-50 cursor-not-allowed' : ''
                                    ]"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
