<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    aluno: Object,
});

const form = useForm({
    nome: props.aluno.nome,
    foto: null,
});

const fotoPreview = ref(props.aluno.foto_url || null);

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
    form.post(route('alunos.update', props.aluno.uuid), {
        _method: 'put',
    });
};
</script>

<template>
    <Head :title="`Editar ${aluno.nome}`" />

    <AuthenticatedLayout>
        <div class="container">
            <div class="page-header">
                <div>
                    <Link :href="route('admin.alunos.index')" class="text-codevilla-accent hover:underline mb-2 inline-block">
                        ← Voltar para lista
                    </Link>
                    <h1>Editar Aluno</h1>
                    <p>{{ aluno.turma.nome }} • Nº {{ aluno.numero_chamada }}</p>
                </div>
            </div>

            <div class="card" style="max-width: 600px; margin: 0 auto;">
                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <label for="nome">Nome Completo *</label>
                        <input
                            id="nome"
                            type="text"
                            v-model="form.nome"
                            required
                            autofocus
                            placeholder="Nome completo do aluno"
                        />
                        <p class="text-xs text-codevilla-muted mt-1">
                            Se alterar o nome, o número de chamada será reorganizado automaticamente
                        </p>
                        <p v-if="form.errors.nome" class="erro-msg">{{ form.errors.nome }}</p>
                    </div>

                    <div class="mb-6">
                        <label for="foto">Foto do Aluno</label>
                        <input
                            id="foto"
                            type="file"
                            @change="handleFotoChange"
                            accept="image/jpeg,image/png,image/webp"
                            class="mb-2"
                        />
                        <p class="text-xs text-codevilla-muted mb-3">Formatos aceitos: JPG, PNG, WEBP (máx. 5MB)</p>

                        <div v-if="fotoPreview" class="flex justify-center">
                            <img :src="fotoPreview" alt="Preview" class="w-40 h-40 object-cover rounded-lg border-2 border-codevilla-border" />
                        </div>
                        <p v-if="form.errors.foto" class="erro-msg">{{ form.errors.foto }}</p>
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="submit"
                            class="btn btn-primary flex-1"
                            :disabled="form.processing"
                        >
                            <svg v-if="form.processing" class="animate-spin h-4 w-4 mr-2 inline-block" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ form.processing ? 'Salvando...' : 'Salvar Alterações' }}
                        </button>
                        <Link :href="route('admin.alunos.index')" class="btn btn-secondary">
                            Cancelar
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
