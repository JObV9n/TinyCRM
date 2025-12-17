<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

            <!-- Error Messages -->
            <div v-if="errors.general" class="mb-4 text-sm text-red-600">
                {{ errors.general }}
            </div>

            <form @submit.prevent="submit">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block font-medium text-sm text-gray-700">First Name</label>
                    <input
                        id="first_name"
                        type="text"
                        v-model="form.first_name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                        autofocus
                        autocomplete="given-name"
                    />
                    <div v-if="errors.first_name" class="mt-2 text-sm text-red-600">
                        {{ errors.first_name[0] }}
                    </div>
                </div>

                <!-- Last Name -->
                <div class="mt-4">
                    <label for="last_name" class="block font-medium text-sm text-gray-700">Last Name</label>
                    <input
                        id="last_name"
                        type="text"
                        v-model="form.last_name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                        autocomplete="family-name"
                    />
                    <div v-if="errors.last_name" class="mt-2 text-sm text-red-600">
                        {{ errors.last_name[0] }}
                    </div>
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input
                        id="email"
                        type="email"
                        v-model="form.email"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                        autocomplete="username"
                    />
                    <div v-if="errors.email" class="mt-2 text-sm text-red-600">
                        {{ errors.email[0] }}
                    </div>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                    <input
                        id="password"
                        type="password"
                        v-model="form.password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                        autocomplete="new-password"
                    />
                    <div v-if="errors.password" class="mt-2 text-sm text-red-600">
                        {{ errors.password[0] }}
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                        autocomplete="new-password"
                    />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <router-link
                        :to="{ name: 'login' }"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        Already registered?
                    </router-link>

                    <button
                        type="submit"
                        class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        :disabled="processing"
                    >
                        {{ processing ? 'Registering...' : 'Register' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const form = ref({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const errors = ref({});
const processing = ref(false);

const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const submit = async () => {
    processing.value = true;
    errors.value = {};

    try {
        // Get CSRF token first
        await fetch('/sanctum/csrf-cookie', { credentials: 'same-origin' });
        
        // Attempt registration
        const response = await fetch('/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
            body: JSON.stringify(form.value)
        });

        if (!response.ok) {
            const data = await response.json();
            if (response.status === 422) {
                errors.value = data.errors || {};
            } else {
                errors.value.general = data.message || 'Registration failed. Please try again.';
            }
            return;
        }

        // Fetch user data
        await authStore.fetchUser();

        // Redirect to dashboard
        router.push({ name: 'dashboard' });
    } catch (error) {
        errors.value.general = 'An error occurred. Please try again.';
    } finally {
        processing.value = false;
    }
};
</script>
