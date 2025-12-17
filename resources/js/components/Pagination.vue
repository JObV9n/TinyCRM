<template>
    <div class="flex flex-col sm:flex-row justify-between items-center mt-4 gap-2">
        <div class="text-sm text-gray-700">
            <span v-if="from && to && total">
                Showing <span class="font-medium">{{ from }}</span> to <span class="font-medium">{{ to }}</span> of <span class="font-medium">{{ total }}</span> results
            </span>
        </div>
        
        <div class="flex gap-2">
            <button 
                @click="changePage(currentPage - 1)" 
                :disabled="currentPage === 1"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Previous
            </button>
            
            <span class="self-center px-4">
                Page <span class="font-medium">{{ currentPage }}</span> of <span class="font-medium">{{ lastPage }}</span>
            </span>
            
            <button 
                @click="changePage(currentPage + 1)" 
                :disabled="currentPage === lastPage"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true
        },
        lastPage: {
            type: Number,
            required: true
        },
        from: {
            type: Number,
            default: null
        },
        to: {
            type: Number,
            default: null
        },
        total: {
            type: Number,
            default: null
        }
    },
    methods: {
        changePage(page) {
            if (page > 0 && page <= this.lastPage) {
                this.$emit('page-changed', page);
            }
        }
    }
}
</script>