<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">Create User</h2>

                    <!-- Error Messages -->
                    <div v-if="Object.keys(errors).length > 0" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            <li v-for="(error, field) in errors" :key="field">
                                {{ error[0] }}
                            </li>
                        </ul>
                    </div>

                    <form @submit.prevent="submitForm">
                        <!-- First Name -->
                        <div class="mb-5">
                            <label for="first_name" class="block mb-2 font-bold text-gray-600">First Name</label>
                            <input
                                type="text"
                                id="first_name"
                                v-model="form.first_name"
                                placeholder="Enter first name"
                                class="border border-gray-300 shadow p-3 w-full rounded"
                                :class="{'border-red-500': errors.first_name}"
                            />
                        </div>

                        <!-- Last Name -->
                        <div class="mb-5">
                            <label for="last_name" class="block mb-2 font-bold text-gray-600">Last Name</label>
                            <input
                                type="text"
                                id="last_name"
                                v-model="form.last_name"
                                placeholder="Enter last name"
                                class="border border-gray-300 shadow p-3 w-full rounded"
                                :class="{'border-red-500': errors.last_name}"
                            />
                        </div>

                        <!-- Email -->
                        <div class="mb-5">
                            <label for="email" class="block mb-2 font-bold text-gray-600">Email</label>
                            <input
                                type="email"
                                id="email"
                                v-model="form.email"
                                placeholder="Enter email address"
                                class="border border-gray-300 shadow p-3 w-full rounded"
                                :class="{'border-red-500': errors.email}"
                            />
                        </div>

                        <!-- Password -->
                        <div class="mb-5">
                            <label for="password" class="block mb-2 font-bold text-gray-600">Password</label>
                            <input
                                type="password"
                                id="password"
                                v-model="form.password"
                                placeholder="Enter password"
                                class="border border-gray-300 shadow p-3 w-full rounded"
                                :class="{'border-red-500': errors.password}"
                            />
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-5">
                            <label for="password_confirmation" class="block mb-2 font-bold text-gray-600">Confirm Password</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                placeholder="Confirm password"
                                class="border border-gray-300 shadow p-3 w-full rounded"
                                :class="{'border-red-500': errors.password_confirmation}"
                            />
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2">
                            <button
                                type="submit"
                                :disabled="submitting"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold p-4 rounded-lg disabled:opacity-50"
                            >
                                {{ submitting ? 'Creating...' : 'Create User' }}
                            </button>
                            <router-link
                                :to="{ name: 'users.index' }"
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
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { usersAPI } from '../../services/api';

const router = useRouter();
const submitting = ref(false);
const errors = ref({});

const form = ref({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submitForm = async () => {
    submitting.value = true;
    errors.value = {};

    try {
        await usersAPI.create(form.value);
        router.push({ name: 'users.index' });
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors || {};
        } else {
            console.error('Error creating user:', error);
            alert('Failed to create user. Please try again.');
        }
    } finally {
        submitting.value = false;
    }
};
</script>
