<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Update Profile Information -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Update your account's profile information and email address.
                        </p>
                    </header>

                    <!-- Success Message -->
                    <div v-if="profileSuccess" class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        Profile updated successfully!
                    </div>

                    <!-- Error Messages -->
                    <div v-if="Object.keys(profileErrors).length > 0" class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul>
                            <li v-for="(error, field) in profileErrors" :key="field">
                                {{ error[0] }}
                            </li>
                        </ul>
                    </div>

                    <form @submit.prevent="updateProfile" class="mt-6 space-y-6">
                        <div>
                            <label for="first_name" class="block font-medium text-sm text-gray-700">First Name</label>
                            <input
                                type="text"
                                id="first_name"
                                v-model="profileForm.first_name"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            />
                        </div>

                        <div>
                            <label for="last_name" class="block font-medium text-sm text-gray-700">Last Name</label>
                            <input
                                type="text"
                                id="last_name"
                                v-model="profileForm.last_name"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            />
                        </div>

                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input
                                type="email"
                                id="email"
                                v-model="profileForm.email"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            />
                        </div>

                        <div class="flex items-center gap-4">
                            <button
                                type="submit"
                                :disabled="updatingProfile"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                            >
                                {{ updatingProfile ? 'Saving...' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Update Password</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Ensure your account is using a long, random password to stay secure.
                        </p>
                    </header>

                    <!-- Success Message -->
                    <div v-if="passwordSuccess" class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        Password updated successfully!
                    </div>

                    <!-- Error Messages -->
                    <div v-if="Object.keys(passwordErrors).length > 0" class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul>
                            <li v-for="(error, field) in passwordErrors" :key="field">
                                {{ error[0] }}
                            </li>
                        </ul>
                    </div>

                    <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
                        <div>
                            <label for="current_password" class="block font-medium text-sm text-gray-700">Current Password</label>
                            <input
                                type="password"
                                id="current_password"
                                v-model="passwordForm.current_password"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            />
                        </div>

                        <div>
                            <label for="password" class="block font-medium text-sm text-gray-700">New Password</label>
                            <input
                                type="password"
                                id="password"
                                v-model="passwordForm.password"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                v-model="passwordForm.password_confirmation"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            />
                        </div>

                        <div class="flex items-center gap-4">
                            <button
                                type="submit"
                                :disabled="updatingPassword"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                            >
                                {{ updatingPassword ? 'Saving...' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Delete Account</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Once your account is deleted, all of its resources and data will be permanently deleted.
                        </p>
                    </header>

                    <div class="mt-6">
                        <button
                            @click="confirmDeleteAccount"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../../stores/auth';

const authStore = useAuthStore();

const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

// Profile form
const profileForm = ref({
    first_name: '',
    last_name: '',
    email: '',
});
const profileErrors = ref({});
const profileSuccess = ref(false);
const updatingProfile = ref(false);

// Password form
const passwordForm = ref({
    current_password: '',
    password: '',
    password_confirmation: '',
});
const passwordErrors = ref({});
const passwordSuccess = ref(false);
const updatingPassword = ref(false);

onMounted(() => {
    if (authStore.user) {
        profileForm.value = {
            first_name: authStore.user.first_name || '',
            last_name: authStore.user.last_name || '',
            email: authStore.user.email || '',
        };
    }
});

const updateProfile = async () => {
    updatingProfile.value = true;
    profileErrors.value = {};
    profileSuccess.value = false;

    try {
        const response = await fetch('/profile', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
            body: JSON.stringify(profileForm.value)
        });

        if (!response.ok) {
            const data = await response.json();
            if (response.status === 422) {
                profileErrors.value = data.errors || {};
            } else {
                alert('Failed to update profile');
            }
            return;
        }

        profileSuccess.value = true;
        await authStore.fetchUser();
        
        setTimeout(() => {
            profileSuccess.value = false;
        }, 3000);
    } catch (error) {
        alert('Failed to update profile');
    } finally {
        updatingProfile.value = false;
    }
};

const updatePassword = async () => {
    updatingPassword.value = true;
    passwordErrors.value = {};
    passwordSuccess.value = false;

    try {
        const response = await fetch('/password', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
            body: JSON.stringify(passwordForm.value)
        });

        if (!response.ok) {
            const data = await response.json();
            if (response.status === 422) {
                passwordErrors.value = data.errors || {};
            } else {
                alert('Failed to update password');
            }
            return;
        }

        passwordSuccess.value = true;
        passwordForm.value = {
            current_password: '',
            password: '',
            password_confirmation: '',
        };
        
        setTimeout(() => {
            passwordSuccess.value = false;
        }, 3000);
    } catch (error) {
        alert('Failed to update password');
    } finally {
        updatingPassword.value = false;
    }
};

const confirmDeleteAccount = async () => {
    if (!confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
        return;
    }

    const password = prompt('Please enter your password to confirm:');
    if (!password) {
        return;
    }

    try {
        const response = await fetch('/profile', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
            body: JSON.stringify({ password })
        });

        if (!response.ok) {
            alert('Failed to delete account. Please check your password and try again.');
            return;
        }

        window.location.href = '/';
    } catch (error) {
        alert('Failed to delete account. Please check your password and try again.');
    }
};
</script>
