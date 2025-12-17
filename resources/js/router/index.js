import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

// Views
import Dashboard from '../views/Dashboard.vue';
import UserIndex from '../views/users/Index.vue';
import UserCreate from '../views/users/Create.vue';
import UserEdit from '../views/users/Edit.vue';
import ClientIndex from '../views/clients/Index.vue';
import ClientCreate from '../views/clients/Create.vue';
import ClientEdit from '../views/clients/Edit.vue';
import ProjectIndex from '../views/projects/Index.vue';
import ProjectCreate from '../views/projects/Create.vue';
import ProjectEdit from '../views/projects/Edit.vue';
import TaskIndex from '../views/tasks/Index.vue';
import TaskCreate from '../views/tasks/Create.vue';
import TaskEdit from '../views/tasks/Edit.vue';
import Profile from '../views/profile/Edit.vue';
import Login from '../views/auth/Login.vue';
import Register from '../views/auth/Register.vue';
import ForgotPassword from '../views/auth/ForgotPassword.vue';
import ResetPassword from '../views/auth/ResetPassword.vue';

const routes = [
    // Auth Routes
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { guest: true },
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: { guest: true },
    },
    {
        path: '/forgot-password',
        name: 'password.request',
        component: ForgotPassword,
        meta: { guest: true },
    },
    {
        path: '/reset-password/:token',
        name: 'password.reset',
        component: ResetPassword,
        meta: { guest: true },
    },
    {
        path: '/',
        redirect: '/dashboard',
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true },
    },
    // Users
    {
        path: '/users',
        name: 'users.index',
        component: UserIndex,
        meta: { requiresAuth: true, requiresAdmin: true },
    },
    {
        path: '/users/create',
        name: 'users.create',
        component: UserCreate,
        meta: { requiresAuth: true, requiresAdmin: true },
    },
    {
        path: '/users/:id/edit',
        name: 'users.edit',
        component: UserEdit,
        meta: { requiresAuth: true, requiresAdmin: true },
    },
    // Clients
    {
        path: '/clients',
        name: 'clients.index',
        component: ClientIndex,
        meta: { requiresAuth: true },
    },
    {
        path: '/clients/create',
        name: 'clients.create',
        component: ClientCreate,
        meta: { requiresAuth: true },
    },
    {
        path: '/clients/:id/edit',
        name: 'clients.edit',
        component: ClientEdit,
        meta: { requiresAuth: true },
    },
    // Projects
    {
        path: '/projects',
        name: 'projects.index',
        component: ProjectIndex,
        meta: { requiresAuth: true },
    },
    {
        path: '/projects/create',
        name: 'projects.create',
        component: ProjectCreate,
        meta: { requiresAuth: true },
    },
    {
        path: '/projects/:id/edit',
        name: 'projects.edit',
        component: ProjectEdit,
        meta: { requiresAuth: true },
    },
    // Tasks
    {
        path: '/tasks',
        name: 'tasks.index',
        component: TaskIndex,
        meta: { requiresAuth: true },
    },
    {
        path: '/tasks/create',
        name: 'tasks.create',
        component: TaskCreate,
        meta: { requiresAuth: true },
    },
    {
        path: '/tasks/:id/edit',
        name: 'tasks.edit',
        component: TaskEdit,
        meta: { requiresAuth: true },
    },
    // Profile
    {
        path: '/profile',
        name: 'profile.edit',
        component: Profile,
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation guards
router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    // Redirect authenticated users away from guest pages
    if (to.meta.guest && authStore.user) {
        next({ name: 'dashboard' });
        return;
    }

    // Try to fetch user if not already loaded
    if (!authStore.user && to.meta.requiresAuth) {
        try {
            await authStore.fetchUser();
        } catch (error) {
            // If user fetch fails, redirect to login
            next({ name: 'login' });
            return;
        }
    }

    // Check if route requires authentication
    if (to.meta.requiresAuth && !authStore.user) {
        next({ name: 'login' });
        return;
    }

    // Check if route requires admin
    if (to.meta.requiresAdmin && !authStore.isAdmin) {
        next({ name: 'dashboard' });
        return;
    }

    next();
});

export default router;
