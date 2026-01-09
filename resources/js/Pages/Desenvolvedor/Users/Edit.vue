<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PencilSquareIcon, ArrowLeftIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    role: props.user.role,
    is_active: props.user.is_active,
});

const submit = () => {
    form.put(route('desenvolvedor.users.update', props.user.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Editar Usuário" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <PencilSquareIcon class="h-8 w-8 text-blue-600 mr-3" />
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">Editar Usuário</h2>
                                    <p class="text-sm text-gray-600">Atualize as informações do usuário</p>
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
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    :class="{'border-red-500': form.errors.email}"
                                />
                                <p v-if="form.errors.email" class="mt-1 text-sm text-red-500">{{ form.errors.email }}</p>
                            </div>

                            <!-- Senha -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nova Senha
                                </label>
                                <input
                                    type="password"
                                    v-model="form.password"
                                    placeholder="Deixe em branco para manter a atual"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    :class="{'border-red-500': form.errors.password}"
                                />
                                <p v-if="form.errors.password" class="mt-1 text-sm text-red-500">{{ form.errors.password }}</p>
                                <p class="mt-1 text-xs text-gray-500">Deixe em branco se não quiser alterar</p>
                            </div>

                            <!-- Confirmar Senha -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmar Nova Senha
                                </label>
                                <input
                                    type="password"
                                    v-model="form.password_confirmation"
                                    placeholder="Confirme a nova senha"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    />
                                    <label class="ml-2 text-sm text-gray-700">
                                        Usuário ativo
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-700">
                                <strong>Informações do Usuário:</strong><br>
                                Criado em: {{ new Date(user.created_at).toLocaleDateString('pt-BR') }}<br>
                                Última atualização: {{ new Date(user.updated_at).toLocaleDateString('pt-BR') }}
                            </p>
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
                                class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50"
                            >
                                {{ form.processing ? 'Salvando...' : 'Salvar Alterações' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
