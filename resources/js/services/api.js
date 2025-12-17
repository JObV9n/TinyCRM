// Helper function to get CSRF token
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

// Fetch wrapper with default config
async function apiFetch(url, options = {}) {
    const defaultOptions = {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': getCsrfToken(),
            ...options.headers,
        },
        credentials: 'same-origin',
        ...options,
    };

    const fullUrl = url.startsWith('/api') ? url : `/api${url}`;

    try {
        const response = await fetch(fullUrl, defaultOptions);

        // Handle 401 Unauthorized
        if (response.status === 401) {
            window.location.href = '/login';
            throw new Error('Unauthorized');
        }

        // Handle other errors
        if (!response.ok) {
            const error = await response.json().catch(() => ({ message: response.statusText }));
            throw { response: { status: response.status, data: error } };
        }

        // Handle 204 No Content
        if (response.status === 204) {
            return { data: null };
        }

        const data = await response.json();
        return { data };
    } catch (error) {
        throw error;
    }
}

// Auth API
export const authAPI = {
    getUser: () => apiFetch('/user'),
    logout: () => fetch('/logout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
        },
        credentials: 'same-origin',
    }),
};

// Users API
export const usersAPI = {
    getAll: (params) => {
        const query = new URLSearchParams(params).toString();
        return apiFetch(`/users${query ? '?' + query : ''}`);
    },
    getOne: (id) => apiFetch(`/users/${id}`),
    create: (data) => apiFetch('/users', { method: 'POST', body: JSON.stringify(data) }),
    update: (id, data) => apiFetch(`/users/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
    delete: (id) => apiFetch(`/users/${id}`, { method: 'DELETE' }),
};

// Clients API
export const clientsAPI = {
    getAll: (params) => {
        const query = new URLSearchParams(params).toString();
        return apiFetch(`/clients${query ? '?' + query : ''}`);
    },
    getOne: (id) => apiFetch(`/clients/${id}`),
    create: (data) => apiFetch('/clients', { method: 'POST', body: JSON.stringify(data) }),
    update: (id, data) => apiFetch(`/clients/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
    delete: (id) => apiFetch(`/clients/${id}`, { method: 'DELETE' }),
};

// Projects API
export const projectsAPI = {
    getAll: (params) => {
        const query = new URLSearchParams(params).toString();
        return apiFetch(`/projects${query ? '?' + query : ''}`);
    },
    getOne: (id) => apiFetch(`/projects/${id}`),
    create: (data) => apiFetch('/projects', { method: 'POST', body: JSON.stringify(data) }),
    update: (id, data) => apiFetch(`/projects/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
    delete: (id) => apiFetch(`/projects/${id}`, { method: 'DELETE' }),
};

// Tasks API
export const tasksAPI = {
    getAll: (params) => {
        const query = new URLSearchParams(params).toString();
        return apiFetch(`/tasks${query ? '?' + query : ''}`);
    },
    getOne: (id) => apiFetch(`/tasks/${id}`),
    create: (data) => apiFetch('/tasks', { method: 'POST', body: JSON.stringify(data) }),
    update: (id, data) => apiFetch(`/tasks/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
    delete: (id) => apiFetch(`/tasks/${id}`, { method: 'DELETE' }),
};

// Profile API
export const profileAPI = {
    get: () => apiFetch('/profile'),
    update: (data) => apiFetch('/profile', { method: 'PUT', body: JSON.stringify(data) }),
    delete: () => apiFetch('/profile', { method: 'DELETE' }),
};
