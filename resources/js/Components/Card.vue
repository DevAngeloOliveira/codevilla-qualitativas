<template>
    <div
        class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-codevilla-border"
        :class="cardClass"
    >
        <!-- Header (opcional) -->
        <div
            v-if="$slots.header || title"
            class="bg-gradient-to-r from-codevilla-primary to-codevilla-accent p-4"
            :class="headerClass"
        >
            <slot name="header">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-xl text-white">{{ title }}</h3>
                    <slot name="headerActions"></slot>
                </div>
            </slot>
        </div>

        <!-- Corpo -->
        <div class="p-5" :class="bodyClass">
            <slot></slot>
        </div>

        <!-- Footer (opcional) -->
        <div
            v-if="$slots.footer"
            class="px-5 py-4 bg-gray-50 border-t border-codevilla-border"
            :class="footerClass"
        >
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        default: null
    },
    cardClass: {
        type: String,
        default: ''
    },
    headerClass: {
        type: String,
        default: ''
    },
    bodyClass: {
        type: String,
        default: ''
    },
    footerClass: {
        type: String,
        default: ''
    }
});
</script>
