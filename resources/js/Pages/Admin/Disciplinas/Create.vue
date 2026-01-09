<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    nome: '',
});

const submit = () => {
    form.post(route('admin.disciplinas.store'));
};
</script>

<template>
    <Head title="Nova Disciplina" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-6">
                            <h1 class="text-2xl font-bold text-gray-900">Nova Disciplina</h1>
                            <p class="text-gray-600">Cadastre uma nova disciplina no sistema</p>
                        </div>

                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nome da Disciplina</label>
                                <TextInput
                                    v-model="form.nome"
                                    type="text"
                                    class="w-full"
                                    required
                                    placeholder="Ex: Matemática, Português, História..."
                                />
                                <div v-if="form.errors.nome" class="text-red-600 text-sm mt-1">{{ form.errors.nome }}</div>
                            </div>

                            <div class="flex justify-end gap-3">
                                <Link :href="route('admin.disciplinas.index')" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                    Cancelar
                                </Link>
                                <PrimaryButton :disabled="form.processing">
                                    Salvar
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
