<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center mb-6">Forgot Password</h2>

            <div class="mb-4 text-sm text-gray-600">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </div>

            <!-- Status Message -->
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
                    />
                    <div v-if="errors.email" class="mt-2 text-sm text-red-600">
                        {{ errors.email[0] }}
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        :disabled="processing"
                    >
                        {{ processing ? 'Sending...' : 'Email Password Reset Link' }}
                    </button>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <router-link
                        :to="{ name: 'login' }"
                        class="underline text-sm text-gray-600 hover:text-gray-900"
                    >
                        Back to login
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({
    email: ''
});

const errors = ref({});
const status = ref('');
const processing = ref(false);

const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const submit = async () => {
    processing.value = true;
    errors.value = {};
    status.value = '';

    try {
        // Get CSRF token first
        await fetch('/sanctum/csrf-cookie', { credentials: 'same-origin' });
        
        // Request password reset link
        const response = await fetch('/forgot-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
            body: JSON.stringify({ email: form.value.email })
        });

        const data = await response.json();

        if (!response.ok) {
            if (response.status === 422) {
                errors.value = data.errors || {};
            } else {
                errors.value.general = data.message || 'Failed to send reset link. Please try again.';
            }
            return;
        }

        status.value = data.status || 'We have emailed your password reset link!';
        form.value.email = '';
    } catch (error) {
        errors.value.general = 'An error occurred. Please try again.';
    } finally {
        processing.value = false;
    }
};
</script>
