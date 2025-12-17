<template>
    <router-view v-slot="{ Component, route }">
        <template v-if="route.meta.guest">
            <component :is="Component" />
        </template>
        <template v-else>
            <AppLayout>
                <component :is="Component" />
            </AppLayout>
        </template>
    </router-view>
</template>

<script setup>
import AppLayout from './layouts/AppLayout.vue';
</script>
