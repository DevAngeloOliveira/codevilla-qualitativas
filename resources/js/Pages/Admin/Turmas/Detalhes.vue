<template>
    <AuthenticatedLayout>
        <Head :title="`Detalhes - ${turma.nome}`" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header com ações -->
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <Link
                            :href="route('admin.turmas.index')"
                            class="text-gray-600 hover:text-gray-900 transition"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </Link>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ turma.nome }}</h1>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ turma.ano_letivo }} • {{ turma.turno }} • {{ turma.segmento }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a
                            :href="route('admin.turmas.export.pdf') + '?turmas[]=' + turma.uuid"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center gap-2"
                            target="_blank"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            Exportar PDF
                        </a>
                        <Link
                            :href="route('admin.turmas.edit', turma.uuid)"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar Turma
                        </Link>
                    </div>
                </div>

                <!-- Cards de estatísticas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total de Alunos</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ turma.alunos.length }}</p>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Ano Letivo</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ turma.ano_letivo }}</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Status</p>
                                <p class="text-3xl font-bold mt-1" :class="turma.ativa ? 'text-green-600' : 'text-red-600'">
                                    {{ turma.ativa ? 'Ativa' : 'Inativa' }}
                                </p>
                            </div>
                            <div :class="turma.ativa ? 'bg-green-100' : 'bg-red-100'" class="p-3 rounded-lg">
                                <svg class="w-8 h-8" :class="turma.ativa ? 'text-green-600' : 'text-red-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de alunos -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900">Lista de Alunos</h2>
                        <Link
                            :href="route('admin.turmas.alunos.create', turma.uuid)"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Adicionar Aluno
                        </Link>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Nº
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Foto
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Nome
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="aluno in turma.alunos" :key="aluno.id" class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold text-gray-900">{{ aluno.numero_chamada }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img :src="aluno.foto_url || '/assets/images/placeholder-icon.png'" :alt="aluno.nome" class="w-10 h-10 rounded-full object-cover" />
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ aluno.nome }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <Link
                                                :href="route('admin.alunos.detalhes', aluno.uuid)"
                                                class="text-indigo-600 hover:text-indigo-900"
                                            >
                                                Ver Detalhes
                                            </Link>
                                            <button
                                                @click="confirmRemove(aluno)"
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Remover
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="turma.alunos.length === 0">
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        Nenhum aluno cadastrado nesta turma
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Remoção -->
        <Modal :show="showRemoveModal" @close="showRemoveModal = false">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Confirmar Remoção</h2>
                <p class="text-gray-600 mb-6">
                    Tem certeza que deseja remover <strong>{{ alunoToRemove?.nome }}</strong> desta turma?
                    Esta ação não pode ser desfeita.
                </p>
                <div class="flex justify-end gap-3">
                    <button
                        @click="showRemoveModal = false"
                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition"
                    >
                        Cancelar
                    </button>
                    <button
                        @click="removeAluno"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                    >
                        Remover
                    </button>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    turma: Object,
});

const showRemoveModal = ref(false);
const alunoToRemove = ref(null);

const confirmRemove = (aluno) => {
    alunoToRemove.value = aluno;
    showRemoveModal.value = true;
};

const removeAluno = () => {
    router.delete(route('admin.alunos.destroy', alunoToRemove.value.uuid), {
        preserveScroll: true,
        onSuccess: () => {
            showRemoveModal.value = false;
            alunoToRemove.value = null;
        },
    });
};
</script>
