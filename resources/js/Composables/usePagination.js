import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

/**
 * Composable para gerenciar paginação de dados
 * @param {Object} initialData - Dados paginados do backend
 * @param {String} routeName - Nome da rota para navegação
 */
export function usePagination(initialData, routeName) {
    const data = ref(initialData);

    const currentPage = computed(() => data.value?.current_page || 1);
    const lastPage = computed(() => data.value?.last_page || 1);
    const perPage = computed(() => data.value?.per_page || 15);
    const total = computed(() => data.value?.total || 0);
    const from = computed(() => data.value?.from || 0);
    const to = computed(() => data.value?.to || 0);

    const hasPages = computed(() => lastPage.value > 1);
    const hasNextPage = computed(() => currentPage.value < lastPage.value);
    const hasPreviousPage = computed(() => currentPage.value > 1);

    const goToPage = (page, preserveState = true, preserveScroll = true) => {
        router.get(
            route(routeName, { page }),
            {},
            {
                preserveState,
                preserveScroll,
                only: ['data'],
                onSuccess: (response) => {
                    data.value = response.props.data;
                }
            }
        );
    };

    const nextPage = () => {
        if (hasNextPage.value) {
            goToPage(currentPage.value + 1);
        }
    };

    const previousPage = () => {
        if (hasPreviousPage.value) {
            goToPage(currentPage.value - 1);
        }
    };

    const paginationText = computed(() => {
        if (total.value === 0) return 'Nenhum registro encontrado';
        return `Exibindo ${from.value} a ${to.value} de ${total.value} registros`;
    });

    return {
        data,
        currentPage,
        lastPage,
        perPage,
        total,
        from,
        to,
        hasPages,
        hasNextPage,
        hasPreviousPage,
        goToPage,
        nextPage,
        previousPage,
        paginationText
    };
}
