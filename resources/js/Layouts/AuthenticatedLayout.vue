<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
    HomeIcon,
    AcademicCapIcon,
    UserGroupIcon,
    BookOpenIcon,
    ClipboardDocumentListIcon,
    UsersIcon,
    Bars3Icon,
    XMarkIcon,
    UserCircleIcon,
} from '@heroicons/vue/24/outline';

const page = usePage();
const sidebarOpen = ref(false);

// Detectar tipo de usuário e mostrar menu apropriado
const user = computed(() => page.props.auth.user);
const isDesenvolvedor = computed(() => user.value.role === 'desenvolvedor');
const isCoordenacao = computed(() => user.value.role === 'coordenacao');
const isProfessor = computed(() => user.value.role === 'professor');

// Menu items baseado no tipo de usuário
const menuItems = computed(() => {
    if (isDesenvolvedor.value) {
        return [
            { name: 'Dashboard Dev', route: 'desenvolvedor.dashboard', icon: HomeIcon },
            { name: 'Usuários', route: 'desenvolvedor.users.index', icon: UserCircleIcon },
            { name: 'Admin', route: 'admin.dashboard', icon: AcademicCapIcon },
            { name: 'Professor', route: 'professor.dashboard', icon: ClipboardDocumentListIcon },
        ];
    }

    if (isCoordenacao.value) {
        return [
            { name: 'Dashboard', route: 'admin.dashboard', icon: HomeIcon },
            { name: 'Turmas', route: 'admin.turmas.index', icon: AcademicCapIcon },
            { name: 'Alunos', route: 'admin.alunos.index', icon: UserGroupIcon },
            { name: 'Disciplinas', route: 'admin.disciplinas.index', icon: BookOpenIcon },
            { name: 'Professores', route: 'admin.professores.index', icon: UsersIcon },
            { name: 'Atribuições', route: 'admin.atribuicoes.index', icon: ClipboardDocumentListIcon },
        ];
    }

    // Menu do Professor
    return [
        { name: 'Dashboard', route: 'professor.dashboard', icon: HomeIcon },
        { name: 'Avaliações', route: 'professor.avaliacoes.index', icon: ClipboardDocumentListIcon },
    ];
});

const isActive = (routeName) => {
    return route().current(routeName) || route().current(`${routeName}.*`);
};

const getRoleLabel = (role) => {
    const labels = {
        'desenvolvedor': 'Desenvolvedor',
        'coordenacao': 'Coordenação',
        'professor': 'Professor'
    };
    return labels[role] || role;
};
</script>

<template>
    <div class="min-h-screen bg-codevilla-bg">
        <!-- Sidebar Desktop -->
        <aside class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
            <div class="flex flex-col flex-grow bg-gradient-to-b from-codevilla-primary to-codevilla-accent overflow-y-auto">
                <!-- Logo -->
                <div class="flex flex-col items-center flex-shrink-0 px-6 py-6 bg-white/10">
                    <img src="/assets/images/logo-codevilla.png" class="h-16 w-auto mb-3" alt="Logo Codevilla" />
                    <div class="text-center">

                        <p class="text-xs text-white/80">Sistema Qualitativo</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <Link
                        v-for="item in menuItems"
                        :key="item.name"
                        :href="route(item.route)"
                        :class="[
                            isActive(item.route)
                                ? 'bg-white/20 text-white font-semibold'
                                : 'text-white/90 hover:bg-white/10 hover:text-white',
                            'group flex items-center px-4 py-3 text-sm rounded-lg transition-all duration-200'
                        ]"
                    >
                        <component
                            :is="item.icon"
                            :class="[
                                isActive(item.route) ? 'text-white' : 'text-white/70 group-hover:text-white',
                                'mr-3 h-5 w-5 flex-shrink-0 transition-colors'
                            ]"
                        />
                        {{ item.name }}
                    </Link>
                </nav>

                <!-- User Section -->
                <div class="flex-shrink-0 border-t border-white/20">
                    <div class="px-4 py-4">
                        <div class="flex items-center">
                            <UserCircleIcon class="h-10 w-10 text-white/80" />
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-white">{{ user.name }}</p>
                                <p class="text-xs text-white/70">{{ getRoleLabel(user.role) }}</p>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <Link
                                :href="route('profile.edit')"
                                class="block px-3 py-2 text-xs text-white/90 hover:bg-white/10 rounded-md transition"
                            >
                                Perfil
                            </Link>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="w-full text-left block px-3 py-2 text-xs text-white/90 hover:bg-white/10 rounded-md transition"
                            >
                                Sair
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar -->
        <div v-show="sidebarOpen" class="relative z-50 lg:hidden">
            <div class="fixed inset-0 bg-gray-900/80" @click="sidebarOpen = false"></div>
            <div class="fixed inset-0 flex">
                <div class="relative mr-16 flex w-full max-w-xs flex-1">
                    <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button @click="sidebarOpen = false" class="-m-2.5 p-2.5">
                            <XMarkIcon class="h-6 w-6 text-white" />
                        </button>
                    </div>
                    <div class="flex flex-col flex-grow bg-gradient-to-b from-codevilla-primary to-codevilla-accent overflow-y-auto">
                        <!-- Logo Mobile -->
                        <div class="flex flex-col items-center flex-shrink-0 px-6 py-6 bg-white/10">
                            <img src="/assets/images/logo-codevilla.png" class="h-14 w-auto mb-3" alt="Logo" />
                            <div class="text-center">
                                <h1 class="text-base font-bold text-white">Codevilla</h1>
                                <p class="text-xs text-white/80">Sistema Qualitativo</p>
                            </div>
                        </div>

                        <!-- Navigation Mobile -->
                        <nav class="flex-1 px-4 py-6 space-y-2">
                            <Link
                                v-for="item in menuItems"
                                :key="item.name"
                                :href="route(item.route)"
                                @click="sidebarOpen = false"
                                :class="[
                                    isActive(item.route)
                                        ? 'bg-white/20 text-white font-semibold'
                                        : 'text-white/90 hover:bg-white/10 hover:text-white',
                                    'group flex items-center px-4 py-3 text-sm rounded-lg transition-all'
                                ]"
                            >
                                <component
                                    :is="item.icon"
                                    :class="[
                                        isActive(item.route) ? 'text-white' : 'text-white/70',
                                        'mr-3 h-5 w-5'
                                    ]"
                                />
                                {{ item.name }}
                            </Link>
                        </nav>

                        <!-- User Mobile -->
                        <div class="border-t border-white/20 px-4 py-4">
                            <div class="flex items-center mb-3">
                                <UserCircleIcon class="h-10 w-10 text-white/80" />
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-white">{{ user.name }}</p>
                                    <p class="text-xs text-white/70">{{ getRoleLabel(user.role) }}</p>
                                </div>
                            </div>
                            <Link
                                :href="route('profile.edit')"
                                class="block px-3 py-2 text-xs text-white/90 hover:bg-white/10 rounded-md mb-1"
                            >
                                Perfil
                            </Link>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="w-full text-left block px-3 py-2 text-xs text-white/90 hover:bg-white/10 rounded-md"
                            >
                                Sair
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Top Bar Mobile -->
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm lg:hidden">
                <button @click="sidebarOpen = true" class="-m-2.5 p-2.5 text-gray-700">
                    <Bars3Icon class="h-6 w-6" />
                </button>
                <div class="flex-1 text-sm font-semibold leading-6 text-gray-900">
                    Sistema de Avaliação Qualitativa
                </div>
                <img src="/assets/images/logo-codevilla.png" class="h-8 w-auto" alt="Logo" />
            </div>

            <!-- Page Content -->
            <main class="py-6 lg:py-8 animate-in fade-in duration-300">
                <div class="px-4 sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

