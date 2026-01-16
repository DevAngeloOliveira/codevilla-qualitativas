import { ref, computed } from 'vue';

/**
 * Composable para gerenciar modal
 */
export function useModal(initialState = false) {
    const isOpen = ref(initialState);
    const modalData = ref(null);

    const open = (data = null) => {
        modalData.value = data;
        isOpen.value = true;
    };

    const close = () => {
        isOpen.value = false;
        modalData.value = null;
    };

    const toggle = () => {
        isOpen.value = !isOpen.value;
        if (!isOpen.value) {
            modalData.value = null;
        }
    };

    return {
        isOpen,
        modalData,
        open,
        close,
        toggle
    };
}
