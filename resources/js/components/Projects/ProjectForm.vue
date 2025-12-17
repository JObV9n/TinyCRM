<template>
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Project</h2>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submitForm">
                    <!-- Title -->
                    <div class="mb-5">
                        <label for="title" class="block mb-2 font-bold text-gray-600">Project Title</label>
                        <input v-model="form.title" type="text" id="title" placeholder="Put in your Project title."
                            class="border border-gray-300 shadow p-3 w-full rounded mb-" />
                        <p v-if="errors.title" class="text-red-500 text-sm mt-2">{{ errors.title[0] }}</p>
                    </div>

                    <!-- Description -->
                    <div class="mb-5">
                        <label for="description" class="block mb-2 font-bold text-gray-600">Description</label>
                        <input v-model="form.description" type="text" id="description"
                            placeholder="Put in your Description."
                            class="border border-gray-300 shadow p-3 w-full rounded mb-" />
                        <p v-if="errors.description" class="text-red-500 text-sm mt-2">{{ errors.description[0] }}</p>
                    </div>

                    <!-- Deadline_at -->
                    <div class="mb-5">
                        <label for="deadline_at" class="block mb-2 font-bold text-gray-600">Deadline Date</label>
                        <input v-model="form.deadline_at" type="date" id="deadline_at"
                            class="border border-gray-300 shadow p-3 w-full rounded mb-" />
                        <p v-if="errors.deadline_at" class="text-red-500 text-sm mt-2">{{ errors.deadline_at[0] }}</p>
                    </div>

                    <!-- Assigned User -->
                    <div class="mb-5">
                        <label for="user_id" class="block mb-2 font-bold text-gray-600">Assigned User</label>
                        <select v-model="form.user_id" id="user_id"
                            class="border border-gray-300 shadow p-3 w-full rounded mb-">
                            <option v-for="user in users" :key="user.id" :value="user.id">
                                {{ user.first_name + ' ' + user.last_name }}
                            </option>
                        </select>
                    </div>

                    <!-- Assigned Client -->
                    <div class="mb-5">
                        <label for="client_id" class="block mb-2 font-bold text-gray-600">Assigned Client</label>
                        <select v-model="form.client_id" id="client_id"
                            class="border border-gray-300 shadow p-3 w-full rounded mb-">
                            <option v-for="client in clients" :key="client.id" :value="client.id">
                                {{ client.client_name }}
                            </option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mb-5">
                        <label for="status" class="block mb-2 font-bold text-gray-600">Status</label>
                        <select v-model="form.status" id="status"
                            class="border border-gray-300 shadow p-3 w-full rounded mb-">
                            <option v-for="status in statuses" :key="status" :value="status">
                                {{ status }}
                            </option>
                        </select>
                    </div>

                    <!-- Submit button -->
                    <button class="block w-full bg-blue-500 text-white font-bold p-4 rounded-lg">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        users: Array,
        clients: Array,
        statuses: Array,
    },
    data() {
        return {
            form: {
                title: '',
                description: '',
                deadline_at: '',
                user_id: '',
                client_id: '',
                status: '',
            },
            errors: {},
        };
    },
    methods: {
        submitForm() {
            axios
                .post('/api/projects', this.form)
                .then(() => {
                    window.location.href = '/projects?message=Project created successfully';
                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
    },
};
</script>