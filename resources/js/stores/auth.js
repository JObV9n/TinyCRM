import { defineStore } from 'pinia';
import { authAPI } from '../services/api';
import { useRouter } from 'vue-router';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        loading: false,
    }),

    getters: {
        isAuthenticated: (state) => !!state.user,
        isAdmin: (state) => state.user?.roles?.some(role => role.name === 'admin') || false,
    },

    actions: {
        async fetchUser() {
            this.loading = true;
            try {
                const response = await authAPI.getUser();
                this.user = response.data;
            } catch (error) {
                this.user = null;
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async logout() {
            try {
                await authAPI.logout();
                this.user = null;
                // Use window location for logout redirect
                window.location.href = '/login';
            } catch (error) {
                console.error('Logout failed:', error);
                window.location.href = '/login';
            }
        },

        clearUser() {
            this.user = null;
        },
    },
});
