import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';

/**
 * Composable para gerenciar busca com debounce
 * @param {String} routeName - Nome da rota para busca
 * @param {Number} delay - Delay em ms para debounce (padrão: 300ms)
 */
export function useSearch(routeName, delay = 300) {
    const search = ref('');
    const isSearching = ref(false);

    const performSearch = debounce((value) => {
        isSearching.value = true;

        router.get(
            route(routeName),
            { search: value },
            {
                preserveState: true,
                preserveScroll: true,
                only: ['data'],
                onFinish: () => {
                    isSearching.value = false;
                }
            }
        );
    }, delay);

    watch(search, (newValue) => {
        performSearch(newValue);
    });

    const clearSearch = () => {
        search.value = '';
    };

    return {
        search,
        isSearching,
        clearSearch
    };
}
