<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">Create Task</h2>

                    <!-- Loading State -->
                    <div v-if="loading" class="text-center py-4">
                        <p>Loading...</p>
                    </div>

                    <!-- Form -->
                    <div v-else>
                        <!-- Error Messages -->
                        <div v-if="Object.keys(errors).length > 0" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                <li v-for="(error, field) in errors" :key="field">
                                    {{ error[0] }}
                                </li>
                            </ul>
                        </div>

                        <form @submit.prevent="submitForm">
                            <!-- Title -->
                            <div class="mb-5">
                                <label for="title" class="block mb-2 font-bold text-gray-600">Task Title</label>
                                <input
                                    type="text"
                                    id="title"
                                    v-model="form.title"
                                    placeholder="Enter task title"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.title}"
                                />
                            </div>

                            <!-- Description -->
                            <div class="mb-5">
                                <label for="description" class="block mb-2 font-bold text-gray-600">Description</label>
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    placeholder="Enter description"
                                    rows="4"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.description}"
                                ></textarea>
                            </div>

                            <!-- Deadline -->
                            <div class="mb-5">
                                <label for="deadline_at" class="block mb-2 font-bold text-gray-600">Deadline Date</label>
                                <input
                                    type="date"
                                    id="deadline_at"
                                    v-model="form.deadline_at"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.deadline_at}"
                                />
                            </div>

                            <!-- Assigned User -->
                            <div class="mb-5">
                                <label for="user_id" class="block mb-2 font-bold text-gray-600">Assigned User</label>
                                <select
                                    id="user_id"
                                    v-model="form.user_id"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.user_id}"
                                >
                                    <option value="">Select a user</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.first_name }} {{ user.last_name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Assigned Client -->
                            <div class="mb-5">
                                <label for="client_id" class="block mb-2 font-bold text-gray-600">Assigned Client</label>
                                <select
                                    id="client_id"
                                    v-model="form.client_id"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.client_id}"
                                >
                                    <option value="">Select a client</option>
                                    <option v-for="client in clients" :key="client.id" :value="client.id">
                                        {{ client.client_name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Assigned Project -->
                            <div class="mb-5">
                                <label for="project_id" class="block mb-2 font-bold text-gray-600">Assigned Project</label>
                                <select
                                    id="project_id"
                                    v-model="form.project_id"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.project_id}"
                                >
                                    <option value="">Select a project</option>
                                    <option v-for="project in projects" :key="project.id" :value="project.id">
                                        {{ project.title }}
                                    </option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="mb-5">
                                <label for="status" class="block mb-2 font-bold text-gray-600">Status</label>
                                <select
                                    id="status"
                                    v-model="form.status"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.status}"
                                >
                                    <option value="open">open</option>
                                    <option value="in progress">in progress</option>
                                    <option value="pending">pending</option>
                                    <option value="waiting client">waiting client</option>
                                    <option value="blocked">blocked</option>
                                    <option value="cancelled">cancelled</option>
                                    <option value="completed">completed</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-2">
                                <button
                                    type="submit"
                                    :disabled="submitting"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold p-4 rounded-lg disabled:opacity-50"
                                >
                                    {{ submitting ? 'Creating...' : 'Create Task' }}
                                </button>
                                <router-link
                                    :to="{ name: 'tasks.index' }"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold p-4 rounded-lg inline-block"
                                >
                                    Cancel
                                </router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { tasksAPI, usersAPI, clientsAPI, projectsAPI } from '../../services/api';

const router = useRouter();
const loading = ref(true);
const submitting = ref(false);
const errors = ref({});

const users = ref([]);
const clients = ref([]);
const projects = ref([]);

const form = ref({
    title: '',
    description: '',
    user_id: '',
    client_id: '',
    project_id: '',
    deadline_at: '',
    status: 'open',
});

const fetchDropdownData = async () => {
    try {
        const [usersRes, clientsRes, projectsRes] = await Promise.all([
            usersAPI.getAll({ per_page: 1000 }),
            clientsAPI.getAll({ per_page: 1000 }),
            projectsAPI.getAll({ per_page: 1000 }),
        ]);
        users.value = usersRes.data.data || usersRes.data;
        clients.value = clientsRes.data.data || clientsRes.data;
        projects.value = projectsRes.data.data || projectsRes.data;
    } catch (error) {
        console.error('Error fetching dropdown data:', error);
        alert('Failed to load form data');
    } finally {
        loading.value = false;
    }
};

const submitForm = async () => {
    submitting.value = true;
    errors.value = {};

    try {
        await tasksAPI.create(form.value);
        router.push({ name: 'tasks.index' });
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors || {};
        } else {
            console.error('Error creating task:', error);
            alert('Failed to create task. Please try again.');
        }
    } finally {
        submitting.value = false;
    }
};

onMounted(() => {
    fetchDropdownData();
});
</script>
