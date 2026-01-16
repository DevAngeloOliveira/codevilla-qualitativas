<template>
    <div v-if="data && data.last_page > 1" class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6 rounded-b-lg">
        <!-- Info Text -->
        <div class="flex items-center text-sm text-gray-700">
            <span>
                Exibindo
                <span class="font-semibold">{{ data.from }}</span>
                a
                <span class="font-semibold">{{ data.to }}</span>
                de
                <span class="font-semibold">{{ data.total }}</span>
                resultados
            </span>
        </div>

        <!-- Pagination Buttons -->
        <div class="flex items-center gap-2">
            <!-- Previous Button -->
            <button
                @click="goToPage(data.current_page - 1)"
                :disabled="!data.prev_page_url"
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors"
                :class="[
                    data.prev_page_url
                        ? 'text-codevilla-primary hover:bg-codevilla-primary hover:text-white border border-codevilla-primary'
                        : 'text-gray-400 bg-gray-100 cursor-not-allowed border border-gray-200'
                ]"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Anterior
            </button>

            <!-- Page Numbers -->
            <div class="hidden sm:flex gap-1">
                <button
                    v-for="page in visiblePages"
                    :key="page"
                    @click="page !== '...' && goToPage(page)"
                    :disabled="page === data.current_page || page === '...'"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors"
                    :class="[
                        page === data.current_page
                            ? 'bg-codevilla-primary text-white'
                            : page === '...'
                            ? 'text-gray-400 cursor-default'
                            : 'text-codevilla-primary hover:bg-codevilla-primary hover:text-white border border-codevilla-primary'
                    ]"
                >
                    {{ page }}
                </button>
            </div>

            <!-- Current Page (Mobile) -->
            <div class="sm:hidden text-sm font-medium text-gray-700">
                Página {{ data.current_page }} de {{ data.last_page }}
            </div>

            <!-- Next Button -->
            <button
                @click="goToPage(data.current_page + 1)"
                :disabled="!data.next_page_url"
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors"
                :class="[
                    data.next_page_url
                        ? 'text-codevilla-primary hover:bg-codevilla-primary hover:text-white border border-codevilla-primary'
                        : 'text-gray-400 bg-gray-100 cursor-not-allowed border border-gray-200'
                ]"
            >
                Próxima
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Object,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    preserveState: {
        type: Boolean,
        default: true
    },
    preserveScroll: {
        type: Boolean,
        default: true
    }
});

const visiblePages = computed(() => {
    const current = props.data.current_page;
    const last = props.data.last_page;
    const delta = 2; // Páginas ao redor da atual
    const pages = [];

    // Sempre mostrar primeira página
    pages.push(1);

    // Adicionar reticências se necessário
    if (current - delta > 2) {
        pages.push('...');
    }

    // Páginas ao redor da atual
    for (let i = Math.max(2, current - delta); i <= Math.min(last - 1, current + delta); i++) {
        pages.push(i);
    }

    // Adicionar reticências se necessário
    if (current + delta < last - 1) {
        pages.push('...');
    }

    // Sempre mostrar última página (se houver mais de uma)
    if (last > 1) {
        pages.push(last);
    }

    return pages;
});

const goToPage = (page) => {
    router.get(
        route(props.routeName, { page }),
        {},
        {
            preserveState: props.preserveState,
            preserveScroll: props.preserveScroll
        }
    );
};
</script>
