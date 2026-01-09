<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Login - Codevilla" />

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

        <!-- Login Card -->
        <div class="flex-1 flex items-center justify-center py-12">
            <div class="login-card">
                <img src="/assets/images/logo-codevilla.png" class="logo-large" alt="Colégio Codevilla" />

                <h2 class="text-2xl font-bold text-codevilla-primary mb-2">Bem-vindo!</h2>
                <p class="text-codevilla-muted text-sm mb-6">Faça login para acessar o sistema</p>

                <div v-if="status" class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <label for="email">E-mail</label>
                        <input
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                            autofocus
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
                            autocomplete="current-password"
                            placeholder="••••••••"
                        />
                        <p v-if="form.errors.password" class="erro-msg">{{ form.errors.password }}</p>
                    </div>

                    <div class="check-inline">
                        <input type="checkbox" id="remember" v-model="form.remember" />
                        <label for="remember">Lembrar de mim</label>
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
                            {{ form.processing ? 'Entrando...' : 'Entrar' }}
                        </button>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-center text-sm text-codevilla-accent hover:text-codevilla-primary transition"
                        >
                            Esqueceu sua senha?
                        </Link>
                    </div>
                </form>

                <p class="text-muted text-center mt-6">
                    Credenciais de teste:<br>
                    <strong>Coordenação:</strong> coord@codevilla.edu.br<br>
                    <strong>Professor:</strong> professor@codevilla.edu.br<br>
                    <span class="small">Senha: password123</span>
                </p>
            </div>
        </div>
    </div>
</template>
