<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center mb-6">Log in</h2>

            <!-- Session Status -->
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <!-- Error Messages -->
            <div v-if="errors.general" class="mb-4 text-sm text-red-600">
                {{ errors.general }}
            </div>

            <form @submit.prevent="submit">
                <!-- Email Address -->
                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input
                        id="email"
                        type="email"
                        v-model="form.email"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <div v-if="errors.email" class="mt-2 text-sm text-red-600">
                        {{ errors.email }}
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
                        autocomplete="current-password"
                    />
                    <div v-if="errors.password" class="mt-2 text-sm text-red-600">
                        {{ errors.password }}
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            v-model="form.remember"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        />
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <router-link
                        :to="{ name: 'password.request' }"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        Forgot your password?
                    </router-link>

                    <button
                        type="submit"
                        class="ml-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        :disabled="processing"
                    >
                        {{ processing ? 'Logging in...' : 'Log in' }}
                    </button>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <span class="text-sm text-gray-600">Don't have an account?</span>
                    <router-link
                        :to="{ name: 'register' }"
                        class="ml-2 underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        Register
                    </router-link>
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
    email: '',
    password: '',
    remember: false
});

const errors = ref({});
const status = ref('');
const processing = ref(false);

const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const submit = async () => {
    processing.value = true;
    errors.value = {};

    try {
        // Get CSRF token first
        await fetch('/sanctum/csrf-cookie', { credentials: 'same-origin' });
        
        // Attempt login
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                email: form.value.email,
                password: form.value.password,
                remember: form.value.remember
            })
        });

        if (!response.ok) {
            const data = await response.json();
            if (response.status === 422) {
                errors.value = data.errors || {};
            } else {
                errors.value.general = data.message || 'These credentials do not match our records.';
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
