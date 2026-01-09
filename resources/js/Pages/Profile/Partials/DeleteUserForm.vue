<script setup>
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <p class="text-sm text-gray-600">
            Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente removidos.
            Antes de excluir sua conta, por favor baixe quaisquer dados ou informações que você deseja reter.
        </p>

        <button
            @click="confirmUserDeletion"
            class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium"
        >
            Excluir Conta
        </button>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Tem certeza que deseja excluir sua conta?
                </h2>

                <p class="mt-3 text-sm text-gray-600">
                    Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente removidos.
                    Por favor, digite sua senha para confirmar que você gostaria de excluir permanentemente sua conta.
                </p>

                <div class="mt-6">
                    <label for="password" class="sr-only">Senha</label>
                    <input
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        placeholder="Senha"
                        @keyup.enter="deleteUser"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                        :class="{ 'border-red-500': form.errors.password }"
                    />
                    <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium"
                    >
                        Cancelar
                    </button>

                    <button
                        @click="deleteUser"
                        :disabled="form.processing"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition font-medium"
                    >
                        Excluir Conta
                    </button>
                </div>
            </div>
        </Modal>
    </section>
</template>
