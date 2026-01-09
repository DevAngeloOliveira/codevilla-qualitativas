<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { UserPlusIcon, ArrowLeftIcon } from '@heroicons/vue/24/outline';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'professor',
    is_active: true,
});

const submit = () => {
    form.post(route('desenvolvedor.users.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Criar Novo Usuário" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <UserPlusIcon class="h-8 w-8 text-purple-600 mr-3" />
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">Criar Novo Usuário</h2>
                                    <p class="text-sm text-gray-600">Adicione um novo usuário ao sistema</p>
                                </div>
                            </div>
                            <Link
                                :href="route('desenvolvedor.users.index')"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
                            >
                                <ArrowLeftIcon class="h-5 w-5 mr-2" />
                                Voltar
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nome -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nome Completo <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    v-model="form.name"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    :class="{'border-red-500': form.errors.name}"
                                />
                                <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">{{ form.errors.name }}</p>
                            </div>

                            <!-- Email -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    v-model="form.email"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    :class="{'border-red-500': form.errors.email}"
                                />
                                <p v-if="form.errors.email" class="mt-1 text-sm text-red-500">{{ form.errors.email }}</p>
                            </div>

                            <!-- Senha -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Senha <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="password"
                                    v-model="form.password"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    :class="{'border-red-500': form.errors.password}"
                                />
                                <p v-if="form.errors.password" class="mt-1 text-sm text-red-500">{{ form.errors.password }}</p>
                            </div>

                            <!-- Confirmar Senha -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmar Senha <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="password"
                                    v-model="form.password_confirmation"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                />
                            </div>

                            <!-- Cargo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Cargo <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.role"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    :class="{'border-red-500': form.errors.role}"
                                >
                                    <option value="professor">Professor</option>
                                    <option value="coordenacao">Coordenação</option>
                                    <option value="desenvolvedor">Desenvolvedor</option>
                                </select>
                                <p v-if="form.errors.role" class="mt-1 text-sm text-red-500">{{ form.errors.role }}</p>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Status
                                </label>
                                <div class="flex items-center h-10">
                                    <input
                                        type="checkbox"
                                        v-model="form.is_active"
                                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                    />
                                    <label class="ml-2 text-sm text-gray-700">
                                        Usuário ativo
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                            <Link
                                :href="route('desenvolvedor.users.index')"
                                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
                            >
                                Cancelar
                            </Link>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50"
                            >
                                {{ form.processing ? 'Criando...' : 'Criar Usuário' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
