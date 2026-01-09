<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { UserCircleIcon, LockClosedIcon } from '@heroicons/vue/24/outline';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Perfil" />

    <AuthenticatedLayout>
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Perfil</h1>
            <p class="mt-1 text-sm text-gray-600">Gerencie suas informações pessoais e configurações de conta</p>
        </div>

        <div class="space-y-6">
            <!-- Profile Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100/50 px-6 py-4 border-b border-blue-200/50">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg mr-3">
                            <UserCircleIcon class="w-6 h-6 text-blue-600" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Informações do Perfil</h3>
                            <p class="text-sm text-gray-600">Atualize as informações da sua conta e endereço de email</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>
            </div>

            <!-- Update Password -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-50 to-yellow-100/50 px-6 py-4 border-b border-yellow-200/50">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg mr-3">
                            <LockClosedIcon class="w-6 h-6 text-yellow-600" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Atualizar Senha</h3>
                            <p class="text-sm text-gray-600">Certifique-se de usar uma senha longa e aleatória para manter sua conta segura</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <UpdatePasswordForm />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
