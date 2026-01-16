<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
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
        <div class="py-6">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-2">
                        <ShieldCheckIcon class="w-8 h-8 text-purple-600" />
                        <h1 class="text-3xl font-bold text-codevilla-text">Painel do Desenvolvedor</h1>
                    </div>
                    <p class="mt-1 text-sm text-codevilla-muted">Gerenciamento completo da plataforma</p>
                </div>

                <!-- Cards de Estatísticas -->
                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Total de Usuários -->
                    <div class="p-6 transition-shadow bg-white border border-gray-100 shadow-md rounded-xl hover:shadow-lg">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg">
                                <UserGroupIcon class="w-6 h-6 text-purple-600" />
                            </div>
                            <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400" />
                        </div>
                        <p class="mb-1 text-sm font-medium text-codevilla-muted">Total de Usuários</p>
                        <p class="text-3xl font-bold text-codevilla-text">{{ stats.total_usuarios }}</p>
                    </div>

                    <!-- Coordenadores -->
                    <div class="p-6 transition-shadow bg-white border border-gray-100 shadow-md rounded-xl hover:shadow-lg">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                                <CogIcon class="w-6 h-6 text-blue-600" />
                            </div>
                            <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400" />
                        </div>
                        <p class="mb-1 text-sm font-medium text-codevilla-muted">Coordenadores</p>
                        <p class="text-3xl font-bold text-codevilla-text">{{ stats.total_coordenadores }}</p>
                    </div>

                    <!-- Professores -->
                    <div class="p-6 transition-shadow bg-white border border-gray-100 shadow-md rounded-xl hover:shadow-lg">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                                <AcademicCapIcon class="w-6 h-6 text-green-600" />
                            </div>
                            <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400" />
                        </div>
                        <p class="mb-1 text-sm font-medium text-codevilla-muted">Professores</p>
                        <p class="text-3xl font-bold text-codevilla-text">{{ stats.total_professores }}</p>
                    </div>

                    <!-- Desenvolvedores -->
                    <div class="p-6 transition-shadow bg-white border border-gray-100 shadow-md rounded-xl hover:shadow-lg">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-indigo-100 rounded-lg">
                                <ShieldCheckIcon class="w-6 h-6 text-indigo-600" />
                            </div>
                            <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400" />
                        </div>
                        <p class="mb-1 text-sm font-medium text-codevilla-muted">Desenvolvedores</p>
                        <p class="text-3xl font-bold text-codevilla-text">{{ stats.total_desenvolvedores }}</p>
                    </div>
                </div>

                <!-- Navegação Rápida -->
                <Card title="Gerenciamento">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <Link
                            :href="route('desenvolvedor.users.index')"
                            class="flex items-center p-4 transition-all duration-200 border group bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-xl hover:shadow-lg border-purple-200/50"
                        >
                            <div class="flex items-center justify-center w-10 h-10 mr-3 transition-transform bg-white rounded-lg group-hover:scale-110">
                                <UsersIcon class="w-6 h-6 text-purple-600" />
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-codevilla-text">Gerenciar Usuários</p>
                                <p class="text-xs text-codevilla-muted">Desenvolvedores, Coordenadores e Professores</p>
                            </div>
                        </Link>

                        <Link
                            :href="route('desenvolvedor.users.create')"
                            class="flex items-center p-4 transition-all duration-200 border group bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl hover:shadow-lg border-green-200/50"
                        >
                            <div class="flex items-center justify-center w-10 h-10 mr-3 transition-transform bg-white rounded-lg group-hover:scale-110">
                                <UserGroupIcon class="w-6 h-6 text-green-600" />
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-codevilla-text">Criar Novo Usuário</p>
                                <p class="text-xs text-codevilla-muted">Adicionar desenvolvedor, coordenador ou professor</p>
                            </div>
                        </Link>
                    </div>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
