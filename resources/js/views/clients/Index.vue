<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Clients</h2>
                        <router-link
                            :to="{ name: 'clients.create' }"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Add New Client
                        </router-link>
                    </div>

                    <!-- Loading State -->
                    <div v-if="loading" class="text-center py-4">
                        <p>Loading clients...</p>
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
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Name</th>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Email</th>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Phone</th>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Address</th>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Zipcode</th>
                                    <th scope="col" class="px-6 py-3 border border-slate-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="client in clients" :key="client.id" class="bg-white">
                                    <td class="px-6 py-4 border font-medium text-gray-900">
                                        {{ client.client_name }}
                                    </td>
                                    <td class="px-6 py-4 border">{{ client.client_email }}</td>
                                    <td class="px-6 py-4 border">{{ client.client_phone }}</td>
                                    <td class="px-6 py-4 border">{{ client.client_address }}</td>
                                    <td class="px-6 py-4 border">{{ client.client_zipcode }}</td>
                                    <td class="px-6 py-4 border">
                                        <router-link
                                            :to="{ name: 'clients.edit', params: { id: client.id } }"
                                            class="text-blue-600 hover:underline mr-2"
                                        >
                                            Edit
                                        </router-link>
                                        /
                                        <button
                                            @click="deleteClient(client.id)"
                                            class="text-red-600 hover:underline ml-2"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="clients.length === 0">
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No clients found.
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
                                @page-changed="fetchClients"
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
import { clientsAPI } from '../../services/api';
import Pagination from '../../components/Pagination.vue';

const clients = ref([]);
const pagination = ref(null);
const loading = ref(false);
const error = ref(null);

const fetchClients = async (page = 1) => {
    loading.value = true;
    error.value = null;
    try {
        const response = await clientsAPI.getAll({ page });
        clients.value = response.data.data;
        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page,
            from: response.data.from,
            to: response.data.to,
            total: response.data.total,
        };
    } catch (err) {
        error.value = 'Failed to load clients. Please try again.';
        console.error('Error fetching clients:', err);
    } finally {
        loading.value = false;
    }
};

const deleteClient = async (id) => {
    if (!confirm('Are you sure you want to delete this client?')) {
        return;
    }

    try {
        await clientsAPI.delete(id);
        await fetchClients(pagination.value?.current_page || 1);
    } catch (err) {
        error.value = 'Failed to delete client. Please try again.';
        console.error('Error deleting client:', err);
    }
};

onMounted(() => {
    fetchClients();
});
</script>
