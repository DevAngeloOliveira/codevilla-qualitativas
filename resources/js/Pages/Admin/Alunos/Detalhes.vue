<template>
    <AuthenticatedLayout>
        <Head :title="`Detalhes - ${aluno.nome}`" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header com ações -->
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <Link
                            :href="route('admin.alunos.index')"
                            class="text-gray-600 hover:text-gray-900 transition"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </Link>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ aluno.nome }}</h1>
                            <p v-if="aluno.turma" class="text-sm text-gray-600 mt-1">
                                Nº {{ aluno.numero_chamada }} • {{ aluno.turma.nome }}
                            </p>
                            <p v-else class="text-sm text-gray-600 mt-1">
                                Nº {{ aluno.numero_chamada }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <Link
                            :href="route('admin.alunos.edit', aluno.uuid)"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </Link>
                    </div>
                </div>

                <!-- Grid principal -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Coluna esquerda - Informações do aluno -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Card com foto -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <div class="flex flex-col items-center">
                                <img
                                    :src="aluno.foto_url || '/assets/images/placeholder-icon.png'"
                                    :alt="aluno.nome"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-indigo-100 mb-4"
                                />
                                <h3 class="text-lg font-bold text-gray-900 text-center">{{ aluno.nome }}</h3>
                                <p class="text-sm text-gray-600">Número de Chamada: {{ aluno.numero_chamada }}</p>
                            </div>
                        </div>

                        <!-- Card informações da turma -->
                        <div v-if="aluno.turma" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Informações da Turma</h3>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="bg-indigo-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Turma</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ aluno.turma.nome }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="bg-green-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Ano Letivo</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ aluno.turma.ano_letivo }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="bg-blue-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Turno</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ aluno.turma.turno }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="bg-purple-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600">Segmento</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ aluno.turma.segmento }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <Link
                                    :href="route('admin.turmas.detalhes', aluno.turma.uuid)"
                                    class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-2"
                                >
                                    Ver Turma Completa
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna direita - Estatísticas e avaliações -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Cards de estatísticas -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Total de Avaliações</p>
                                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ stats.total_avaliacoes }}</p>
                                    </div>
                                    <div class="bg-indigo-100 p-3 rounded-lg">
                                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Média Geral</p>
                                        <p class="text-3xl font-bold text-gray-900 mt-1">
                                            {{ stats.media_geral ? stats.media_geral.toFixed(1) : 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="bg-green-100 p-3 rounded-lg">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Disciplinas</p>
                                        <p class="text-3xl font-bold text-gray-900 mt-1">
                                            {{ Object.keys(stats.avaliacoes_por_disciplina).length }}
                                        </p>
                                    </div>
                                    <div class="bg-blue-100 p-3 rounded-lg">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Avaliações por disciplina -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                            <div class="p-6 border-b border-gray-100">
                                <h2 class="text-xl font-bold text-gray-900">Desempenho por Disciplina</h2>
                            </div>

                            <div class="p-6">
                                <div v-if="Object.keys(stats.avaliacoes_por_disciplina).length > 0" class="space-y-4">
                                    <div
                                        v-for="(dados, disciplina) in stats.avaliacoes_por_disciplina"
                                        :key="disciplina"
                                        class="bg-gray-50 rounded-lg p-4"
                                    >
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="font-semibold text-gray-900">{{ disciplina }}</h3>
                                            <span class="text-2xl font-bold text-indigo-600">
                                                {{ dados.media ? dados.media.toFixed(1) : 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            {{ dados.total }} {{ dados.total === 1 ? 'avaliação' : 'avaliações' }}
                                        </div>

                                        <!-- Barra de progresso -->
                                        <div class="mt-3 bg-gray-200 rounded-full h-2 overflow-hidden">
                                            <div
                                                class="h-full transition-all duration-500"
                                                :class="{
                                                    'bg-green-500': dados.media >= 7,
                                                    'bg-yellow-500': dados.media >= 5 && dados.media < 7,
                                                    'bg-red-500': dados.media < 5
                                                }"
                                                :style="{ width: `${(dados.media / 10) * 100}%` }"
                                            ></div>
                                        </div>
                                    </div>
                                </div>

                                <div v-else class="text-center py-12 text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-medium">Nenhuma avaliação registrada</p>
                                    <p class="text-sm mt-1">As avaliações aparecerão aqui quando forem lançadas pelos professores</p>
                                </div>
                            </div>
                        </div>

                        <!-- Histórico de avaliações -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                            <div class="p-6 border-b border-gray-100">
                                <h2 class="text-xl font-bold text-gray-900">Histórico de Avaliações</h2>
                            </div>

                            <div class="overflow-x-auto">
                                <table v-if="aluno.avaliacoes && aluno.avaliacoes.length > 0" class="w-full">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                Disciplina
                                            </th>
                                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                Trimestre
                                            </th>
                                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                Nota Final
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                Data
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr v-for="avaliacao in aluno.avaliacoes" :key="avaliacao.id" class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4">
                                                <span v-if="avaliacao.disciplina" class="text-sm font-medium text-gray-900">
                                                    {{ avaliacao.disciplina.nome }}
                                                </span>
                                                <span v-else class="text-sm text-gray-500">-</span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-sm text-gray-600">{{ avaliacao.trimestre }}º</span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold"
                                                    :class="{
                                                        'bg-green-100 text-green-800': avaliacao.nota_final >= 7,
                                                        'bg-yellow-100 text-yellow-800': avaliacao.nota_final >= 5 && avaliacao.nota_final < 7,
                                                        'bg-red-100 text-red-800': avaliacao.nota_final < 5
                                                    }"
                                                >
                                                    {{ avaliacao.nota_final }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-sm text-gray-600">
                                                    {{ new Date(avaliacao.created_at).toLocaleDateString('pt-BR') }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div v-else class="px-6 py-12 text-center text-gray-500">
                                    Nenhuma avaliação no histórico
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    aluno: Object,
    stats: Object,
});
</script>
