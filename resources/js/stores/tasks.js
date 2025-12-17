import { defineStore } from 'pinia';
import api from '../services/api';

export const useTaskStore = defineStore('tasks', {
    state: () => ({
        tasks: [],
        currentTask: null,
        pagination: {
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        },
        loading: false,
    }),

    actions: {
        async fetchTasks(page = 1) {
            this.loading = true;
            try {
                const response = await api.tasks.index({ page });
                this.tasks = response.data.data;
                this.pagination = {
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    per_page: response.data.per_page,
                    total: response.data.total,
                };
            } catch (error) {
                console.error('Failed to fetch tasks:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async createTask(taskData) {
            this.loading = true;
            try {
                const response = await api.tasks.store(taskData);
                return response.data;
            } catch (error) {
                console.error('Failed to create task:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async updateTask(id, taskData) {
            this.loading = true;
            try {
                const response = await api.tasks.update(id, taskData);
                return response.data;
            } catch (error) {
                console.error('Failed to update task:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async deleteTask(id) {
            this.loading = true;
            try {
                await api.tasks.destroy(id);
                this.tasks = this.tasks.filter(task => task.id !== id);
            } catch (error) {
                console.error('Failed to delete task:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchTask(id) {
            this.loading = true;
            try {
                const response = await api.tasks.show(id);
                this.currentTask = response.data;
                return response.data;
            } catch (error) {
                console.error('Failed to fetch task:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },
    },
});
