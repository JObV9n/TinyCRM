import { defineStore } from 'pinia';
import api from '../services/api';

export const useUserStore = defineStore('users', {
    state: () => ({
        users: [],
        currentUser: null,
        pagination: {
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        },
        loading: false,
    }),

    actions: {
        async fetchUsers(page = 1) {
            this.loading = true;
            try {
                const response = await api.users.index({ page });
                this.users = response.data.data;
                this.pagination = {
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    per_page: response.data.per_page,
                    total: response.data.total,
                };
            } catch (error) {
                console.error('Failed to fetch users:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async createUser(userData) {
            this.loading = true;
            try {
                const response = await api.users.store(userData);
                return response.data;
            } catch (error) {
                console.error('Failed to create user:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async updateUser(id, userData) {
            this.loading = true;
            try {
                const response = await api.users.update(id, userData);
                return response.data;
            } catch (error) {
                console.error('Failed to update user:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async deleteUser(id) {
            this.loading = true;
            try {
                await api.users.destroy(id);
                this.users = this.users.filter(user => user.id !== id);
            } catch (error) {
                console.error('Failed to delete user:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchUser(id) {
            this.loading = true;
            try {
                const response = await api.users.show(id);
                this.currentUser = response.data;
                return response.data;
            } catch (error) {
                console.error('Failed to fetch user:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },
    },
});
