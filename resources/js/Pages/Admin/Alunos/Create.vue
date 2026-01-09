<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    turma: Object,
});

const form = useForm({
    nome: '',
    foto: null,
});

const fotoPreview = ref(null);

const handleFotoChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.foto = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            fotoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post(route('admin.turmas.alunos.store', props.turma.uuid));
};
</script>

<template>
    <Head :title="`Novo Aluno - ${turma.nome}`" />

    <AuthenticatedLayout>
        <div class="container">
            <div class="page-header">
                <div>
                    <Link :href="route('admin.turmas.detalhes', turma.uuid)" class="inline-block mb-2 text-codevilla-accent hover:underline">
                        ← Voltar para {{ turma.nome }}
                    </Link>
                    <h1>Cadastrar Novo Aluno</h1>
                    <p>Turma: {{ turma.nome }} • O número de chamada será atribuído automaticamente</p>
                </div>
            </div>

            <div class="card" style="max-width: 600px; margin: 0 auto;">
                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <label for="nome">Nome Completo do Aluno *</label>
                        <input
                            id="nome"
                            type="text"
                            v-model="form.nome"
                            required
                            autofocus
                            placeholder="Nome completo do aluno"
                        />
                        <p class="mt-1 text-xs text-codevilla-muted">
                            O número de chamada será atribuído automaticamente baseado na ordem alfabética
                        </p>
                        <p v-if="form.errors.nome" class="erro-msg">{{ form.errors.nome }}</p>
                    </div>

                    <div class="mb-6">
                        <label for="foto">Foto do Aluno (opcional)</label>
                        <input
                            id="foto"
                            type="file"
                            @change="handleFotoChange"
                            accept="image/jpeg,image/png,image/webp"
                            class="mb-2"
                        />
                        <p class="mb-3 text-xs text-codevilla-muted">Formatos aceitos: JPG, PNG, WEBP (máx. 5MB)</p>

                        <div v-if="fotoPreview" class="flex justify-center">
                            <img :src="fotoPreview" alt="Preview" class="object-cover w-40 h-40 border-2 rounded-lg border-codevilla-border" />
                        </div>
                        <p v-if="form.errors.foto" class="erro-msg">{{ form.errors.foto }}</p>
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="submit"
                            class="flex-1 btn btn-primary"
                            :disabled="form.processing"
                        >
                            <svg v-if="form.processing" class="inline-block w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ form.processing ? 'Salvando...' : 'Salvar Aluno' }}
                        </button>
                        <Link :href="route('admin.turmas.detalhes', turma.uuid)" class="btn btn-secondary">
                            Cancelar
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
