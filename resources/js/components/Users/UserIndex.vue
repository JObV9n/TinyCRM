<!-- filepath: c:\Users\Lenovo\Desktop\miso\projects\php_projects\minicrm\resources\js\components\UserIndex.vue -->
<template>
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">User</h2>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="message" class="alert alert-success mt-4">
                    <p>{{ message }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <a href="/users/create" class="underline">Add new User</a>
                    </div>
                </div>
                <TableComponent :columns="columns" :rows="users" @userDeleted="fetchUsers" />
                <Pagination :links="paginationLinks" @page-changed="fetchUsers" />
            </div>
        </div>
    </div>
</template>

<script>
import TableComponent from '../Table.vue';
import Pagination from '../Pagination.vue';

export default {
    components: { TableComponent, Pagination },
    data() {
        return {
            users: [],
            paginationLinks: [],
            message: '',
            columns: [
                { label: 'First Name', field: 'first_name' },
                { label: 'Last Name', field: 'last_name' },
                { label: 'Email', field: 'email' },
                {
                    label: 'Action',
                    action: [
                        {
                            label: 'Edit',
                            handler: (row) => (window.location.href = `/users/${row.id}/edit`),
                            class: 'underline text-blue-600',
                        },
                        {
                            label: 'Delete',
                            handler: (row) => this.deleteUser(row.id),
                            class: 'underline text-red-600',
                        },
                    ],
                },
            ],
        };
    },
    mounted() {
        this.fetchUsers();
        this.message = new URLSearchParams(window.location.search).get('message');
    },
    methods: {
        fetchUsers(url = '/api/users') {
            axios.get(url).then((response) => {
                this.users = response.data.data;
                this.paginationLinks = response.data.links;
            });
        },
        deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                axios.delete(`/users/${userId}`).then(() => {
                    this.fetchUsers();
                });
            }
        },
    },
};
</script>