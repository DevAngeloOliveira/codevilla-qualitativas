<template>
    <div class="relative">
        <div class="flex items-center gap-2">
            <input
                v-model="searchQuery"
                type="text"
                :placeholder="placeholder"
                class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-codevilla-primary focus:border-transparent transition-all"
                @input="handleSearch"
            />

            <!-- Search Icon -->
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <svg v-if="!isSearching" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <svg v-else class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <!-- Clear Button -->
            <button
                v-if="searchQuery"
                @click="clearSearch"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';

const props = defineProps({
    routeName: {
        type: String,
        required: true
    },
    placeholder: {
        type: String,
        default: 'Pesquisar...'
    },
    delay: {
        type: Number,
        default: 300
    },
    initialValue: {
        type: String,
        default: ''
    }
});

const searchQuery = ref(props.initialValue);
const isSearching = ref(false);

const performSearch = debounce((value) => {
    isSearching.value = true;

    router.get(
        route(props.routeName),
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
}, props.delay);

const handleSearch = () => {
    performSearch(searchQuery.value);
};

const clearSearch = () => {
    searchQuery.value = '';
    performSearch('');
};
</script>
