// CSRF token helper
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

// Make CSRF token globally available
window.getCsrfToken = getCsrfToken;
