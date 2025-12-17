import { defineStore } from 'pinia';
import api from '../services/api';

export const useClientStore = defineStore('clients', {
    state: () => ({
        clients: [],
        currentClient: null,
        pagination: {
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        },
        loading: false,
    }),

    actions: {
        async fetchClients(page = 1) {
            this.loading = true;
            try {
                const response = await api.clients.index({ page });
                this.clients = response.data.data;
                this.pagination = {
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    per_page: response.data.per_page,
                    total: response.data.total,
                };
            } catch (error) {
                console.error('Failed to fetch clients:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async createClient(clientData) {
            this.loading = true;
            try {
                const response = await api.clients.store(clientData);
                return response.data;
            } catch (error) {
                console.error('Failed to create client:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async updateClient(id, clientData) {
            this.loading = true;
            try {
                const response = await api.clients.update(id, clientData);
                return response.data;
            } catch (error) {
                console.error('Failed to update client:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async deleteClient(id) {
            this.loading = true;
            try {
                await api.clients.destroy(id);
                this.clients = this.clients.filter(client => client.id !== id);
            } catch (error) {
                console.error('Failed to delete client:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchClient(id) {
            this.loading = true;
            try {
                const response = await api.clients.show(id);
                this.currentClient = response.data;
                return response.data;
            } catch (error) {
                console.error('Failed to fetch client:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },
    },
});
