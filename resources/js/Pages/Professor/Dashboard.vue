<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    AcademicCapIcon,
    BookOpenIcon,
    ClipboardDocumentListIcon,
    UserGroupIcon
} from '@heroicons/vue/24/outline';

defineProps({
    turmas: Array,
    disciplinas: Array,
});
</script>

<template>
    <Head title="Dashboard - Professor" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard - Professor</h1>
                    <p class="mt-2 text-gray-600">Bem-vindo ao sistema de avaliações qualitativas</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Card Turmas -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Minhas Turmas</p>
                                <p class="text-3xl font-bold mt-2">{{ turmas.length }}</p>
                            </div>
                            <AcademicCapIcon class="h-12 w-12 text-blue-200" />
                        </div>
                    </div>

                    <!-- Card Disciplinas -->
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Minhas Disciplinas</p>
                                <p class="text-3xl font-bold mt-2">{{ disciplinas.length }}</p>
                            </div>
                            <BookOpenIcon class="h-12 w-12 text-green-200" />
                        </div>
                    </div>
                </div>

                <!-- Minhas Turmas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <AcademicCapIcon class="h-6 w-6 text-blue-600 mr-2" />
                            <h2 class="text-xl font-bold text-gray-900">Minhas Turmas</h2>
                        </div>
                    </div>

                    <div v-if="turmas && turmas.length > 0" class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div v-for="turma in turmas" :key="turma.id"
                                 class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 hover:shadow-md transition-all">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-lg font-bold text-gray-900">{{ turma.nome }}</h4>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                        {{ turma.turno }}
                                    </span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600 mb-4">
                                    <UserGroupIcon class="h-4 w-4 mr-1" />
                                    <span>{{ turma.alunos_count }} alunos</span>
                                </div>
                                <Link
                                    :href="route('professor.avaliacoes.index', { turma_id: turma.id })"
                                    class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium"
                                >
                                    Ver Avaliações
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div v-else class="p-12 text-center">
                        <AcademicCapIcon class="h-16 w-16 text-gray-400 mx-auto mb-4" />
                        <p class="text-gray-500">Nenhuma turma atribuída</p>
                    </div>
                </div>

                <!-- Minhas Disciplinas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <BookOpenIcon class="h-6 w-6 text-green-600 mr-2" />
                            <h2 class="text-xl font-bold text-gray-900">Minhas Disciplinas</h2>
                        </div>
                    </div>

                    <div v-if="disciplinas && disciplinas.length > 0" class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <div v-for="disciplina in disciplinas" :key="disciplina.id"
                                 class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-lg hover:shadow-lg transition-all">
                                <div class="text-4xl mb-3">📚</div>
                                <span class="text-sm font-semibold text-gray-800 text-center">{{ disciplina.nome }}</span>
                            </div>
                        </div>
                    </div>
                    <div v-else class="p-12 text-center">
                        <BookOpenIcon class="h-16 w-16 text-gray-400 mx-auto mb-4" />
                        <p class="text-gray-500">Nenhuma disciplina atribuída</p>
                    </div>
                </div>

                <!-- Ações Rápidas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Ações Rápidas</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <Link
                                :href="route('professor.avaliacoes.index')"
                                class="flex items-center p-5 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg hover:from-purple-100 hover:to-purple-200 transition border-2 border-purple-200 hover:border-purple-400"
                            >
                                <ClipboardDocumentListIcon class="h-10 w-10 text-purple-600 mr-4" />
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Ver Todas Avaliações</p>
                                    <p class="text-xs text-gray-600 mt-1">Acessar histórico completo</p>
                                </div>
                            </Link>

                            <Link
                                :href="route('professor.avaliacoes.create')"
                                class="flex items-center p-5 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-lg hover:from-indigo-100 hover:to-indigo-200 transition border-2 border-indigo-200 hover:border-indigo-400"
                            >
                                <ClipboardDocumentListIcon class="h-10 w-10 text-indigo-600 mr-4" />
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Nova Avaliação</p>
                                    <p class="text-xs text-gray-600 mt-1">Iniciar nova avaliação</p>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
