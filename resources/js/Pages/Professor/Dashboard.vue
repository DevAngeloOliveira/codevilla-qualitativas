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
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard - Professor</h1>
                    <p class="mt-2 text-gray-600">Bem-vindo ao sistema de avaliações qualitativas</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
                    <!-- Card Turmas -->
                    <div class="p-6 text-white shadow-lg bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-100">Minhas Turmas</p>
                                <p class="mt-2 text-3xl font-bold">{{ turmas.length }}</p>
                            </div>
                            <AcademicCapIcon class="w-12 h-12 text-blue-200" />
                        </div>
                    </div>

                    <!-- Card Disciplinas -->
                    <div class="p-6 text-white shadow-lg bg-gradient-to-br from-green-500 to-green-600 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-100">Minhas Disciplinas</p>
                                <p class="mt-2 text-3xl font-bold">{{ disciplinas.length }}</p>
                            </div>
                            <BookOpenIcon class="w-12 h-12 text-green-200" />
                        </div>
                    </div>
                </div>

                <!-- Minhas Turmas -->
                <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <AcademicCapIcon class="w-6 h-6 mr-2 text-blue-600" />
                            <h2 class="text-xl font-bold text-gray-900">Minhas Turmas</h2>
                        </div>
                    </div>

                    <div v-if="turmas && turmas.length > 0" class="p-6">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <div v-for="turma in turmas" :key="turma.id"
                                 class="p-4 transition-all border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-lg font-bold text-gray-900">{{ turma.nome }}</h4>
                                    <span class="px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                                        {{ turma.turno }}
                                    </span>
                                </div>
                                <div class="flex items-center mb-4 text-sm text-gray-600">
                                    <UserGroupIcon class="w-4 h-4 mr-1" />
                                    <span>{{ turma.alunos_count }} alunos</span>
                                </div>
                                <Link
                                    :href="route('professor.avaliacoes.index', { turma_id: turma.id })"
                                    class="block w-full px-4 py-2 text-sm font-medium text-center text-white transition bg-blue-600 rounded-lg hover:bg-blue-700"
                                >
                                    Ver Avaliações
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div v-else class="p-12 text-center">
                        <AcademicCapIcon class="w-16 h-16 mx-auto mb-4 text-gray-400" />
                        <p class="text-gray-500">Nenhuma turma atribuída</p>
                    </div>
                </div>

                <!-- Minhas Disciplinas -->
                <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <BookOpenIcon class="w-6 h-6 mr-2 text-green-600" />
                            <h2 class="text-xl font-bold text-gray-900">Minhas Disciplinas</h2>
                        </div>
                    </div>

                    <div v-if="disciplinas && disciplinas.length > 0" class="p-6">
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                            <div v-for="disciplina in disciplinas" :key="disciplina.id"
                                 class="flex flex-col items-center justify-center p-6 transition-all border-2 border-green-200 rounded-lg bg-gradient-to-br from-green-50 to-green-100 hover:shadow-lg">
                                <div class="mb-3 text-4xl">📚</div>
                                <span class="text-sm font-semibold text-center text-gray-800">{{ disciplina.nome }}</span>
                            </div>
                        </div>
                    </div>
                    <div v-else class="p-12 text-center">
                        <BookOpenIcon class="w-16 h-16 mx-auto mb-4 text-gray-400" />
                        <p class="text-gray-500">Nenhuma disciplina atribuída</p>
                    </div>
                </div>

                <!-- Ações Rápidas -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Ações Rápidas</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <Link
                                :href="route('professor.avaliacoes.index')"
                                class="flex items-center p-5 transition border-2 border-purple-200 rounded-lg bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 hover:border-purple-400"
                            >
                                <ClipboardDocumentListIcon class="w-10 h-10 mr-4 text-purple-600" />
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Ver Todas Avaliações</p>
                                    <p class="mt-1 text-xs text-gray-600">Acessar histórico completo</p>
                                </div>
                            </Link>

                            <Link
                                :href="route('professor.avaliacoes.create')"
                                class="flex items-center p-5 transition border-2 border-indigo-200 rounded-lg bg-gradient-to-r from-indigo-50 to-indigo-100 hover:from-indigo-100 hover:to-indigo-200 hover:border-indigo-400"
                            >
                                <ClipboardDocumentListIcon class="w-10 h-10 mr-4 text-indigo-600" />
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Nova Avaliação</p>
                                    <p class="mt-1 text-xs text-gray-600">Iniciar nova avaliação</p>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
