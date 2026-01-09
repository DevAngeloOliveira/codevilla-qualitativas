<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    professor: Object,
});

const form = useForm({
    name: props.professor.name,
    email: props.professor.email,
    password: '',
    password_confirmation: '',
    is_active: props.professor.is_active,
});

const submit = () => {
    form.put(route('admin.professores.update', props.professor.id));
};
</script>

<template>
    <Head title="Editar Professor" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-6">
                            <h1 class="text-2xl font-bold text-gray-900">Editar Professor</h1>
                            <p class="text-gray-600">Atualize os dados do professor</p>
                        </div>

                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                                <TextInput
                                    v-model="form.name"
                                    type="text"
                                    class="w-full"
                                    required
                                />
                                <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <TextInput
                                    v-model="form.email"
                                    type="email"
                                    class="w-full"
                                    required
                                />
                                <div v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nova Senha (deixe em branco para manter a atual)</label>
                                <TextInput
                                    v-model="form.password"
                                    type="password"
                                    class="w-full"
                                />
                                <div v-if="form.errors.password" class="text-red-600 text-sm mt-1">{{ form.errors.password }}</div>
                            </div>

                            <div v-if="form.password">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nova Senha</label>
                                <TextInput
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="w-full"
                                />
                            </div>

                            <div class="flex items-center">
                                <input
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                                <label class="ml-2 text-sm text-gray-700">Professor ativo</label>
                            </div>

                            <div class="flex justify-end gap-3">
                                <Link :href="route('admin.professores.index')" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                    Cancelar
                                </Link>
                                <PrimaryButton :disabled="form.processing">
                                    Atualizar
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
