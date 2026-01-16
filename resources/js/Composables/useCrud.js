import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

/**
 * Composable para gerenciar operações CRUD com confirmação
 */
export function useCrud() {
    const isDeleting = ref(false);
    const isSubmitting = ref(false);

    /**
     * Deleta um recurso com confirmação
     * @param {String} routeName - Nome da rota de delete
     * @param {Object|String} params - Parâmetros da rota
     * @param {String} confirmMessage - Mensagem de confirmação
     */
    const deleteResource = (routeName, params, confirmMessage = 'Tem certeza que deseja excluir este item?') => {
        if (!confirm(confirmMessage)) return;

        isDeleting.value = true;

        router.delete(route(routeName, params), {
            preserveScroll: true,
            onFinish: () => {
                isDeleting.value = false;
            }
        });
    };

    /**
     * Submete um formulário
     * @param {String} method - Método HTTP (post, put, patch)
     * @param {String} routeName - Nome da rota
     * @param {Object} params - Parâmetros da rota
     * @param {Object} data - Dados do formulário
     * @param {Object} options - Opções adicionais
     */
    const submitForm = (method, routeName, params, data, options = {}) => {
        isSubmitting.value = true;

        router[method](route(routeName, params), data, {
            preserveScroll: true,
            ...options,
            onFinish: () => {
                isSubmitting.value = false;
                if (options.onFinish) options.onFinish();
            }
        });
    };

    return {
        isDeleting,
        isSubmitting,
        deleteResource,
        submitForm
    };
}
