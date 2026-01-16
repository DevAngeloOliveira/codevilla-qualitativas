<template>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <!-- Header -->
            <thead class="bg-gradient-to-r from-codevilla-primary to-codevilla-accent">
                <tr>
                    <th
                        v-for="(column, index) in columns"
                        :key="index"
                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider"
                        :class="column.headerClass"
                    >
                        {{ column.label }}
                    </th>
                    <th
                        v-if="$slots.actions"
                        class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider"
                    >
                        Ações
                    </th>
                </tr>
            </thead>

            <!-- Body -->
            <tbody class="bg-white divide-y divide-gray-200">
                <tr
                    v-if="!data || data.length === 0"
                    class="hover:bg-gray-50"
                >
                    <td
                        :colspan="columns.length + ($slots.actions ? 1 : 0)"
                        class="px-6 py-8 text-center text-gray-500"
                    >
                        <slot name="empty">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-sm">{{ emptyMessage }}</p>
                            </div>
                        </slot>
                    </td>
                </tr>

                <tr
                    v-for="(row, rowIndex) in data"
                    :key="rowIndex"
                    class="hover:bg-gray-50 transition-colors"
                >
                    <td
                        v-for="(column, colIndex) in columns"
                        :key="colIndex"
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                        :class="column.cellClass"
                    >
                        <slot :name="`cell-${column.key}`" :row="row" :value="row[column.key]">
                            {{ row[column.key] }}
                        </slot>
                    </td>
                    <td
                        v-if="$slots.actions"
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <slot name="actions" :row="row"></slot>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
defineProps({
    columns: {
        type: Array,
        required: true,
        // Formato: [{ key: 'nome', label: 'Nome', headerClass: '', cellClass: '' }]
    },
    data: {
        type: Array,
        default: () => []
    },
    emptyMessage: {
        type: String,
        default: 'Nenhum registro encontrado'
    }
});
</script>
