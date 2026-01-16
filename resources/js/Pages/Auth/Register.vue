<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Registrar - Codevilla" />

    <div class="min-h-screen bg-codevilla-bg flex flex-col">
        <!-- Topbar -->
        <div class="topbar">
            <div>
                <h1 class="topbar-title">Sistema de Avaliação Qualitativa</h1>
                <p class="topbar-subtitle">Colégio Codevilla</p>
            </div>
            <div class="topbar-right">
                <img src="/assets/images/logo-codevilla.png" class="logo-small" alt="Logo Codevilla" />
                <Link href="/" class="btn btn-secondary btn-home">
                    Início
                </Link>
            </div>
        </div>

        <!-- Register Card -->
        <div class="flex-1 flex items-center justify-center py-12">
            <div class="login-card animate-in fade-in duration-300">
                <img src="/assets/images/logo-codevilla.png" class="logo-large" alt="Colégio Codevilla" />

                <h2 class="text-2xl font-bold text-codevilla-primary mb-2">Criar Conta</h2>
                <p class="text-codevilla-muted text-sm mb-6">Preencha os dados para se registrar</p>

                <form @submit.prevent="submit">
                    <div>
                        <label for="name">Nome Completo</label>
                        <input
                            id="name"
                            type="text"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Seu nome completo"
                        />
                        <p v-if="form.errors.name" class="erro-msg">{{ form.errors.name }}</p>
                    </div>

                    <div class="mt-4">
                        <label for="email">E-mail</label>
                        <input
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            placeholder="seu@email.com"
                        />
                        <p v-if="form.errors.email" class="erro-msg">{{ form.errors.email }}</p>
                    </div>

                    <div class="mt-4">
                        <label for="password">Senha</label>
                        <input
                            id="password"
                            type="password"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <p v-if="form.errors.password" class="erro-msg">{{ form.errors.password }}</p>
                    </div>

                    <div class="mt-4">
                        <label for="password_confirmation">Confirmar Senha</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <p v-if="form.errors.password_confirmation" class="erro-msg">{{ form.errors.password_confirmation }}</p>
                    </div>

                    <div class="flex flex-col gap-3 mt-6">
                        <button
                            type="submit"
                            class="btn btn-primary w-full"
                            :disabled="form.processing"
                        >
                            <svg v-if="form.processing" class="animate-spin h-4 w-4 mr-2 inline-block" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ form.processing ? 'Registrando...' : 'Registrar' }}
                        </button>

                        <Link
                            :href="route('login')"
                            class="text-center text-sm text-codevilla-accent hover:text-codevilla-primary transition"
                        >
                            Já tem uma conta? Faça login
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
