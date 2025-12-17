<template>
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create User</h2>
        <form @submit.prevent="createUser">
            <div>
                <label for="first_name">First Name</label>
                <input v-model="form.first_name" type="text" id="first_name" required />
            </div>
            <div>
                <label for="last_name">Last Name</label>
                <input v-model="form.last_name" type="text" id="last_name" required />
            </div>
            <div>
                <label for="email">Email</label>
                <input v-model="form.email" type="email" id="email" required />
            </div>
            <button type="submit">Create</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                first_name: '',
                last_name: '',
                email: '',
            },
        };
    },
    methods: {
        createUser() {
            axios.post('/api/users', this.form).then(() => {
                window.location.href = '/users?message=User created successfully';
            });
        },
    },
};
</script>