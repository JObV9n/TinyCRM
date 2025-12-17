<!-- filepath: c:\Users\Lenovo\Desktop\miso\projects\php_projects\minicrm\resources\js\components\TableComponent.vue -->
<template>
    <div>
        <table class="w-full text-sm text-left text-gray-500 border border-slate-400 table-auto mt-4">
            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                <tr>
                    <th v-for="(column, index) in columns" :key="index" scope="col"
                        class="px-6 py-3 border border-slate-400">
                        {{ column.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, rowIndex) in rows" :key="rowIndex" class="bg-white">
                    <td v-for="(column, colIndex) in columns" :key="colIndex" class="px-6 py-4 border">
                        <span v-if="!column.action">
                            {{ row[column.field] }}
                        </span>
                        <span v-else>
                            <button v-for="(action, actionIndex) in column.action" :key="actionIndex"
                                @click="action.handler(row)" :class="action.class">
                                {{ action.label }}
                            </button>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        columns: {
            type: Array,
            required: true,
        },
        rows: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style scoped>
/* Add any specific styles for the TableComponent here */
</style>