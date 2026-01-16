<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import {
    UserGroupIcon,
    AcademicCapIcon,
    UsersIcon,
    ClipboardDocumentListIcon,
    BookOpenIcon,
    CalendarIcon,
    ArrowTrendingUpIcon
} from '@heroicons/vue/24/outline';

defineProps({
    stats: Object,
});
</script>

<template>
    <Head title="Dashboard - Coordenação" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-codevilla-text">Dashboard</h1>
                    <p class="mt-1 text-sm text-codevilla-muted">Visão geral do sistema de avaliação qualitativa</p>
                </div>

                <!-- Cards de Estatísticas -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total de Alunos -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                                <UserGroupIcon class="w-6 h-6 text-blue-600" />
                            </div>
                            <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400" />
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total de Alunos</p>
                        <p class="text-3xl font-bold text-codevilla-text">{{ stats.total_alunos }}</p>
                    </div>

                    <!-- Turmas Ativas -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                                <AcademicCapIcon class="w-6 h-6 text-green-600" />
                            </div>
                            <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400" />
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Turmas Ativas</p>
                        <p class="text-3xl font-bold text-codevilla-text">{{ stats.total_turmas }}</p>
                    </div>

                    <!-- Professores -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-lg">
                                <UsersIcon class="w-6 h-6 text-yellow-600" />
                            </div>
                            <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400" />
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Professores</p>
                        <p class="text-3xl font-bold text-codevilla-text">{{ stats.total_professores }}</p>
                    </div>

                    <!-- Avaliações -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg">
                                <ClipboardDocumentListIcon class="w-6 h-6 text-purple-600" />
                            </div>
                            <CalendarIcon class="w-5 h-5 text-gray-400" />
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Avaliações (Ano)</p>
                        <p class="text-3xl font-bold text-codevilla-text">{{ stats.total_avaliacoes }}</p>
                    </div>
                </div>

                <!-- Navegação Rápida -->
                <Card title="Navegação Rápida">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <Link
                            :href="route('admin.turmas.index')"
                            class="group flex items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl hover:shadow-lg transition-all duration-200 border border-blue-200/50"
                        >
                            <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                <AcademicCapIcon class="w-6 h-6 text-blue-600" />
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Gerenciar Turmas</span>
                        </Link>

                        <Link
                            :href="route('admin.alunos.index')"
                            class="group flex items-center p-4 bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl hover:shadow-lg transition-all duration-200 border border-green-200/50"
                        >
                            <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                <UserGroupIcon class="w-6 h-6 text-green-600" />
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Gerenciar Alunos</span>
                        </Link>

                        <Link
                            :href="route('admin.professores.index')"
                            class="group flex items-center p-4 bg-gradient-to-br from-yellow-50 to-yellow-100/50 rounded-xl hover:shadow-lg transition-all duration-200 border border-yellow-200/50"
                        >
                            <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                <UsersIcon class="w-6 h-6 text-yellow-600" />
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Gerenciar Professores</span>
                        </Link>

                        <Link
                            :href="route('admin.disciplinas.index')"
                            class="group flex items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-xl hover:shadow-lg transition-all duration-200 border border-purple-200/50"
                        >
                            <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                <BookOpenIcon class="w-6 h-6 text-purple-600" />
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Gerenciar Disciplinas</span>
                        </Link>
                    </div>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
