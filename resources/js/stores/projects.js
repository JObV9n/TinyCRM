import { defineStore } from 'pinia';
import api from '../services/api';

export const useProjectStore = defineStore('projects', {
    state: () => ({
        projects: [],
        currentProject: null,
        pagination: {
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        },
        loading: false,
    }),

    actions: {
        async fetchProjects(page = 1) {
            this.loading = true;
            try {
                const response = await api.projects.index({ page });
                this.projects = response.data.data;
                this.pagination = {
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    per_page: response.data.per_page,
                    total: response.data.total,
                };
            } catch (error) {
                console.error('Failed to fetch projects:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async createProject(projectData) {
            this.loading = true;
            try {
                const response = await api.projects.store(projectData);
                return response.data;
            } catch (error) {
                console.error('Failed to create project:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async updateProject(id, projectData) {
            this.loading = true;
            try {
                const response = await api.projects.update(id, projectData);
                return response.data;
            } catch (error) {
                console.error('Failed to update project:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async deleteProject(id) {
            this.loading = true;
            try {
                await api.projects.destroy(id);
                this.projects = this.projects.filter(project => project.id !== id);
            } catch (error) {
                console.error('Failed to delete project:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchProject(id) {
            this.loading = true;
            try {
                const response = await api.projects.show(id);
                this.currentProject = response.data;
                return response.data;
            } catch (error) {
                console.error('Failed to fetch project:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },
    },
});
