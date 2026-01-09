<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    UserGroupIcon,
    UsersIcon,
    AcademicCapIcon,
    CogIcon,
    ShieldCheckIcon,
    ArrowTrendingUpIcon
} from '@heroicons/vue/24/outline';

defineProps({
    stats: Object,
});
</script>

<template>
    <Head title="Dashboard - Desenvolvedor" />

    <AuthenticatedLayout>
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <ShieldCheckIcon class="w-8 h-8 text-purple-600" />
                <h1 class="text-3xl font-bold text-gray-900">Painel do Desenvolvedor</h1>
            </div>
            <p class="mt-1 text-sm text-gray-600">Gerenciamento completo da plataforma</p>
        </div>

        <!-- Cards de Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total de Usuários -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg">
                        <UserGroupIcon class="w-6 h-6 text-purple-600" />
                    </div>
                    <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400" />
                </div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total de Usuários</p>
                <p class="text-3xl font-bold text-gray-900">{{ stats.total_usuarios }}</p>
            </div>

            <!-- Coordenadores -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                        <CogIcon class="w-6 h-6 text-blue-600" />
                    </div>
                    <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400" />
                </div>
                <p class="text-sm font-medium text-gray-600 mb-1">Coordenadores</p>
                <p class="text-3xl font-bold text-gray-900">{{ stats.total_coordenadores }}</p>
            </div>

            <!-- Professores -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                        <AcademicCapIcon class="w-6 h-6 text-green-600" />
                    </div>
                    <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400" />
                </div>
                <p class="text-sm font-medium text-gray-600 mb-1">Professores</p>
                <p class="text-3xl font-bold text-gray-900">{{ stats.total_professores }}</p>
            </div>

            <!-- Desenvolvedores -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-indigo-100 rounded-lg">
                        <ShieldCheckIcon class="w-6 h-6 text-indigo-600" />
                    </div>
                    <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400" />
                </div>
                <p class="text-sm font-medium text-gray-600 mb-1">Desenvolvedores</p>
                <p class="text-3xl font-bold text-gray-900">{{ stats.total_desenvolvedores }}</p>
            </div>
        </div>

        <!-- Navegação Rápida -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Gerenciamento</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <Link
                    :href="route('desenvolvedor.users.index')"
                    class="group flex items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-xl hover:shadow-lg transition-all duration-200 border border-purple-200/50"
                >
                    <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg mr-3 group-hover:scale-110 transition-transform">
                        <UsersIcon class="w-6 h-6 text-purple-600" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Gerenciar Usuários</p>
                        <p class="text-xs text-gray-500">Desenvolvedores, Coordenadores e Professores</p>
                    </div>
                </Link>

                <Link
                    :href="route('desenvolvedor.users.create')"
                    class="group flex items-center p-4 bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl hover:shadow-lg transition-all duration-200 border border-green-200/50"
                >
                    <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg mr-3 group-hover:scale-110 transition-transform">
                        <UserGroupIcon class="w-6 h-6 text-green-600" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Criar Novo Usuário</p>
                        <p class="text-xs text-gray-500">Adicionar desenvolvedor, coordenador ou professor</p>
                    </div>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
