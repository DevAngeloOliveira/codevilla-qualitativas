<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Sistema de Avaliação Qualitativa - Codevilla" />

    <div class="min-h-screen bg-codevilla-bg">
        <!-- Topbar -->
        <div class="topbar">
            <div>
                <h1 class="topbar-title">Sistema de Avaliação Qualitativa</h1>
                <p class="topbar-subtitle">Colégio Codevilla</p>
            </div>
            <div class="topbar-right">
                <img src="/assets/images/logo-codevilla.png" class="logo-small" alt="Logo Codevilla" />
                <div v-if="canLogin" class="flex gap-3">
                    <Link
                        :href="route('login')"
                        class="btn btn-secondary btn-home"
                    >
                        Entrar
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="btn btn-primary btn-home"
                    >
                        Registrar
                    </Link>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="container py-16 animate-in fade-in duration-300">
            <div class="text-center mb-12">
                <img src="/assets/images/logo-codevilla.png" class="logo-large mx-auto" alt="Colégio Codevilla" />
                <h2 class="text-4xl font-bold text-codevilla-primary mb-4">
                    Bem-vindo ao Sistema de Avaliação Qualitativa
                </h2>
                <p class="text-lg text-codevilla-muted max-w-2xl mx-auto">
                    Plataforma completa para avaliação baseada em critérios qualitativos,
                    proporcionando uma análise abrangente do desenvolvimento dos alunos.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid-2 grid lg:grid-cols-3 mb-12 animate-in fade-in duration-500">
                <div class="card text-center">
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-100 p-4 rounded-full">
                            <svg class="h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-codevilla-secondary mb-2">12 Critérios Avaliativos</h3>
                    <p class="text-codevilla-muted text-sm">
                        Sistema completo com critérios distribuídos em 4 grupos: Aspectos Sociais, Desenvolvimento Cognitivo, Participação e Autonomia.
                    </p>
                </div>

                <div class="card text-center">
                    <div class="flex justify-center mb-4">
                        <div class="bg-green-100 p-4 rounded-full">
                            <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-codevilla-secondary mb-2">Cálculo Automatizado</h3>
                    <p class="text-codevilla-muted text-sm">
                        Nota final calculada automaticamente com base nos pesos específicos de cada critério, gerando resultado de 0 a 10.
                    </p>
                </div>

                <div class="card text-center">
                    <div class="flex justify-center mb-4">
                        <div class="bg-purple-100 p-4 rounded-full">
                            <svg class="h-12 w-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-codevilla-secondary mb-2">Relatórios Completos</h3>
                    <p class="text-codevilla-muted text-sm">
                        Exportação de relatórios detalhados por turma, trimestre e aluno, facilitando o acompanhamento pedagógico.
                    </p>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="card card-info text-center animate-in fade-in duration-500">
                <h3 class="text-2xl font-bold text-codevilla-primary mb-4">
                    Pronto para começar?
                </h3>
                <p class="text-codevilla-muted mb-6">
                    Acesse o sistema com suas credenciais e comece a avaliar seus alunos de forma qualitativa e eficiente.
                </p>
                <div v-if="canLogin" class="flex justify-center gap-4">
                    <Link
                        :href="route('login')"
                        class="btn btn-primary"
                    >
                        Acessar Sistema
                    </Link>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-codevilla-primary text-white py-6 mt-16">
            <div class="container text-center">
                <p class="text-sm opacity-90">
                    © {{ new Date().getFullYear() }} Colégio Codevilla - Sistema de Avaliação Qualitativa
                </p>
                <p class="text-xs opacity-75 mt-2">
                    Desenvolvido com Laravel + Vue.js 3
                </p>
            </div>
        </footer>
    </div>
</template>
