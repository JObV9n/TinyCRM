<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
                        <router-link
                            :to="{ name: 'tasks.create' }"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Add New Task
                        </router-link>
                    </div>

                    <!-- Loading State -->
                    <div v-if="loading" class="text-center py-4">
                        <p>Loading tasks...</p>
                    </div>

                    <!-- Error State -->
                    <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ error }}
                    </div>

                    <!-- Table -->
                    <div v-else class="overflow-x-auto mt-4">
                        <table class="w-full text-sm text-left text-gray-500 border border-slate-400 table-auto">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Title</th>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Assigned To</th>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Client</th>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Project</th>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Deadline</th>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Status</th>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="task in tasks" :key="task.id" class="bg-white">
                                    <td class="px-6 py-4 border font-medium text-gray-900">
                                        {{ task.title }}
                                    </td>
                                    <td class="px-6 py-4 border">
                                        {{ task.user?.first_name }} {{ task.user?.last_name }}
                                    </td>
                                    <td class="px-6 py-4 border">{{ task.client?.client_name }}</td>
                                    <td class="px-6 py-4 border">{{ task.project?.title }}</td>
                                    <td class="px-6 py-4 border">{{ task.deadline_at }}</td>
                                    <td class="px-6 py-4 border">
                                        <span class="px-2 py-1 text-xs rounded" :class="getStatusClass(task.status)">
                                            {{ task.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 border">
                                        <router-link
                                            :to="{ name: 'tasks.edit', params: { id: task.id } }"
                                            class="text-blue-600 hover:underline mr-2"
                                        >
                                            Edit
                                        </router-link>
                                        /
                                        <button
                                            @click="deleteTask(task.id)"
                                            class="text-red-600 hover:underline ml-2"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="tasks.length === 0">
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        No tasks found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div v-if="pagination" class="mt-4">
                            <Pagination
                                :current-page="pagination.current_page"
                                :last-page="pagination.last_page"
                                :from="pagination.from"
                                :to="pagination.to"
                                :total="pagination.total"
                                @page-changed="fetchTasks"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { tasksAPI } from '../../services/api';
import Pagination from '../../components/Pagination.vue';

const tasks = ref([]);
const pagination = ref(null);
const loading = ref(false);
const error = ref(null);

const getStatusClass = (status) => {
    const classes = {
        'open': 'bg-blue-100 text-blue-800',
        'in progress': 'bg-yellow-100 text-yellow-800',
        'pending': 'bg-orange-100 text-orange-800',
        'waiting client': 'bg-purple-100 text-purple-800',
        'blocked': 'bg-red-100 text-red-800',
        'cancelled': 'bg-gray-100 text-gray-800',
        'completed': 'bg-green-100 text-green-800',
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const fetchTasks = async (page = 1) => {
    loading.value = true;
    error.value = null;
    try {
        const response = await tasksAPI.getAll({ page });
        tasks.value = response.data.data;
        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page,
            from: response.data.from,
            to: response.data.to,
            total: response.data.total,
        };
    } catch (err) {
        error.value = 'Failed to load tasks. Please try again.';
        console.error('Error fetching tasks:', err);
    } finally {
        loading.value = false;
    }
};

const deleteTask = async (id) => {
    if (!confirm('Are you sure you want to delete this task?')) {
        return;
    }

    try {
        await tasksAPI.delete(id);
        await fetchTasks(pagination.value?.current_page || 1);
    } catch (err) {
        error.value = 'Failed to delete task. Please try again.';
        console.error('Error deleting task:', err);
    }
};

onMounted(() => {
    fetchTasks();
});
</script>
