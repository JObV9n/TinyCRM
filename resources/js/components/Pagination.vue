<template>
    <div class="flex justify-between mt-4">
        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
            Previous
        </button>
        <span class="self-center">Page {{ currentPage }} of {{ totalPages }}</span>
        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
            Next
        </button>
    </div>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true
        },
        totalPages: {
            type: Number,
            required: true
        }
    },
    methods: {
        changePage(page) {
            if (page > 0 && page <= this.totalPages) {
                this.$emit('page-changed', page);
            }
        }
    }
}
</script>

<style scoped>
/* Add any specific styles for the pagination component here */
</style>