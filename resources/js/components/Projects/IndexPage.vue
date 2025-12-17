<template>
    <div>
        <div class="p-6 text-gray-900">
            <a href="/projects/create" class="underline">Add new project</a>
        </div>
        <div v-if="message" class="alert alert-success mt-4">
            {{ message }}
        </div>
        <table-component :columns="columns" :rows="projects"></table-component>
        <Pagination :links="paginationLinks" @page-changed="fetchProjects" />
    </div>
</template>

<script>
import TableComponent from '../Table.vue';
import Pagination from '../Pagination.vue';

export default {
    components: { TableComponent, Pagination },
    data() {
        return {
            projects: [],
            paginationLinks: [],
            message: new URLSearchParams(window.location.search).get('message'),
            columns: [
                { label: 'Title', field: 'title' },
                { label: 'Assigned To', field: 'user.full_name' },
                { label: 'Client', field: 'client.client_name' },
                { label: 'Deadline', field: 'deadline_at' },
                { label: 'Status', field: 'status' },
                {
                    label: 'Action',
                    action: [
                        {
                            label: 'Edit',
                            handler: (row) => (window.location.href = `/projects/${row.id}/edit`),
                            class: 'underline text-blue-600',
                        },
                        {
                            label: 'Delete',
                            handler: (row) => this.deleteProject(row.id),
                            class: 'underline text-red-600',
                        },
                    ],
                },
            ],
        };
    },
    mounted() {
        this.fetchProjects();
    },
    methods: {
        fetchProjects(url = '/api/projects') {
            axios.get(url).then((response) => {
                this.projects = response.data.data;
                this.paginationLinks = response.data.links;
            });
        },
        deleteProject(projectId) {
            if (confirm('Are you sure you want to delete this project?')) {
                axios.delete(`/api/projects/${projectId}`).then(() => {
                    this.fetchProjects();
                });
            }
        },
    },
};
</script>