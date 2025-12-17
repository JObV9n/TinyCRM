<template>
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
        <form @submit.prevent="updateUser">
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
            <button type="submit">Update</button>
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
    mounted() {
        axios.get(`/api/users/${this.$route.params.id}`).then((response) => {
            this.form = response.data;
        });
    },
    methods: {
        updateUser() {
            axios.put(`/api/users/${this.$route.params.id}`, this.form).then(() => {
                window.location.href = '/users?message=User updated successfully';
            });
        },
    },
};
</script>