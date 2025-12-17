<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">Edit Client</h2>

                    <!-- Loading State -->
                    <div v-if="loading" class="text-center py-4">
                        <p>Loading client...</p>
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
                            <!-- Full Name -->
                            <div class="mb-5">
                                <label for="client_name" class="block mb-2 font-bold text-gray-600">Full Name</label>
                                <input
                                    type="text"
                                    id="client_name"
                                    v-model="form.client_name"
                                    placeholder="Enter full name"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.client_name}"
                                />
                                <p v-if="errors.client_name" class="text-red-500 text-sm mt-1">
                                    {{ errors.client_name[0] }}
                                </p>
                            </div>

                            <!-- Email -->
                            <div class="mb-5">
                                <label for="client_email" class="block mb-2 font-bold text-gray-600">Email</label>
                                <input
                                    type="email"
                                    id="client_email"
                                    v-model="form.client_email"
                                    placeholder="Enter email address"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.client_email}"
                                />
                                <p v-if="errors.client_email" class="text-red-500 text-sm mt-1">
                                    {{ errors.client_email[0] }}
                                </p>
                            </div>

                            <!-- Phone -->
                            <div class="mb-5">
                                <label for="client_phone" class="block mb-2 font-bold text-gray-600">Phone</label>
                                <input
                                    type="text"
                                    id="client_phone"
                                    v-model="form.client_phone"
                                    placeholder="Enter phone number"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.client_phone}"
                                />
                                <p v-if="errors.client_phone" class="text-red-500 text-sm mt-1">
                                    {{ errors.client_phone[0] }}
                                </p>
                            </div>

                            <!-- Address -->
                            <div class="mb-5">
                                <label for="client_address" class="block mb-2 font-bold text-gray-600">Address</label>
                                <input
                                    type="text"
                                    id="client_address"
                                    v-model="form.client_address"
                                    placeholder="Enter address"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.client_address}"
                                />
                                <p v-if="errors.client_address" class="text-red-500 text-sm mt-1">
                                    {{ errors.client_address[0] }}
                                </p>
                            </div>

                            <!-- City -->
                            <div class="mb-5">
                                <label for="client_city" class="block mb-2 font-bold text-gray-600">City</label>
                                <input
                                    type="text"
                                    id="client_city"
                                    v-model="form.client_city"
                                    placeholder="Enter city"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.client_city}"
                                />
                                <p v-if="errors.client_city" class="text-red-500 text-sm mt-1">
                                    {{ errors.client_city[0] }}
                                </p>
                            </div>

                            <!-- Zipcode -->
                            <div class="mb-5">
                                <label for="client_zipcode" class="block mb-2 font-bold text-gray-600">Zipcode</label>
                                <input
                                    type="text"
                                    id="client_zipcode"
                                    v-model="form.client_zipcode"
                                    placeholder="Enter zipcode"
                                    class="border border-gray-300 shadow p-3 w-full rounded"
                                    :class="{'border-red-500': errors.client_zipcode}"
                                />
                                <p v-if="errors.client_zipcode" class="text-red-500 text-sm mt-1">
                                    {{ errors.client_zipcode[0] }}
                                </p>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-2">
                                <button
                                    type="submit"
                                    :disabled="submitting"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold p-4 rounded-lg disabled:opacity-50"
                                >
                                    {{ submitting ? 'Updating...' : 'Update Client' }}
                                </button>
                                <router-link
                                    :to="{ name: 'clients.index' }"
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
import { useRouter, useRoute } from 'vue-router';
import { clientsAPI } from '../../services/api';

const router = useRouter();
const route = useRoute();
const loading = ref(true);
const submitting = ref(false);
const errors = ref({});

const form = ref({
    client_name: '',
    client_email: '',
    client_phone: '',
    client_address: '',
    client_city: '',
    client_zipcode: '',
});

const fetchClient = async () => {
    try {
        const response = await clientsAPI.getOne(route.params.id);
        const client = response.data;
        form.value = {
            client_name: client.client_name,
            client_email: client.client_email,
            client_phone: client.client_phone,
            client_address: client.client_address,
            client_city: client.client_city,
            client_zipcode: client.client_zipcode,
        };
    } catch (error) {
        console.error('Error fetching client:', error);
        alert('Failed to load client');
        router.push({ name: 'clients.index' });
    } finally {
        loading.value = false;
    }
};

const submitForm = async () => {
    submitting.value = true;
    errors.value = {};

    try {
        await clientsAPI.update(route.params.id, form.value);
        router.push({ name: 'clients.index' });
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors || {};
        } else {
            console.error('Error updating client:', error);
            alert('Failed to update client. Please try again.');
        }
    } finally {
        submitting.value = false;
    }
};

onMounted(() => {
    fetchClient();
});
</script>
