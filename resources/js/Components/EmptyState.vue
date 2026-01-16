<template>
    <div class="empty-state text-center py-12">
        <div class="flex flex-col items-center">
            <!-- Icon -->
            <div class="mb-4">
                <slot name="icon">
                    <svg
                        class="w-20 h-20 text-gray-300"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            :d="iconPath"
                        />
                    </svg>
                </slot>
            </div>

            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-700 mb-2">
                {{ title }}
            </h3>

            <!-- Description -->
            <p class="text-sm text-gray-500 max-w-md mb-6">
                {{ description }}
            </p>

            <!-- Action Button -->
            <slot name="action"></slot>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        default: 'Nenhum registro encontrado'
    },
    description: {
        type: String,
        default: 'Não há dados para exibir no momento.'
    },
    icon: {
        type: String,
        default: 'box', // box, users, file, database, etc.
    }
});

const iconPaths = {
    box: 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4',
    users: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
    file: 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
    database: 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4',
    search: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
    folder: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z',
};

const iconPath = computed(() => iconPaths[props.icon] || iconPaths.box);
</script>
