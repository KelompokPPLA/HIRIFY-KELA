/**
 * Hirify API Helper — Shared utilities for JWT-backed Blade views.
 *
 * Include in any Blade page that needs API calls:
 *   <script src="/js/hirify-api.js"></script>
 *
 * Provides:
 *   window.hirifyApi(path, opts)   — fetch wrapper with auto-refresh
 *   window.hirifyEsc(value)        — HTML-escape helper
 *   window.hirifyToken             — current JWT token
 */
(function () {
    'use strict';

    // ----- Token management -----
    let token = '';

    function initToken(sessionToken) {
        token = sessionToken
            || localStorage.getItem('hirify_token')
            || sessionStorage.getItem('hirify_token')
            || '';
        if (token) localStorage.setItem('hirify_token', token);
    }

    function activeStorage() {
        return localStorage.getItem('hirify_token') ? localStorage : sessionStorage;
    }

    function clearAuth() {
        ['hirify_token', 'hirify_user', 'hirify_remember'].forEach(function (k) {
            localStorage.removeItem(k);
            sessionStorage.removeItem(k);
        });
    }

    async function refreshToken() {
        try {
            var res = await fetch('/api/auth/refresh', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });
            var data = await res.json();
            if (!res.ok || !(data && data.data && data.data.token)) return false;
            token = data.data.token;
            activeStorage().setItem('hirify_token', token);
            return true;
        } catch (e) {
            return false;
        }
    }

    // ----- API wrapper -----
    async function api(path, opts, retry) {
        if (retry === undefined) retry = true;
        opts = opts || {};

        var headers = {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token,
        };

        // Only set Content-Type for non-FormData bodies
        if (!(opts.body instanceof FormData)) {
            headers['Content-Type'] = 'application/json';
        }

        Object.assign(headers, opts.headers || {});

        var res = await fetch(path, Object.assign({}, opts, { headers: headers }));
        var data = {};
        try { data = await res.json(); } catch (e) { /* empty */ }

        if (res.status === 401 && retry) {
            if (await refreshToken()) return api(path, opts, false);
            clearAuth();
            window.location.href = '/login';
            throw new Error('Sesi berakhir. Silakan login kembali.');
        }

        if (!res.ok || data.success === false) {
            throw new Error(data.message || 'Terjadi kesalahan.');
        }

        return data;
    }

    // ----- Escape helper -----
    function esc(value) {
        return String(value == null ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    // ----- Public API -----
    window.hirifyInitToken = initToken;
    window.hirifyApi = api;
    window.hirifyEsc = esc;
    window.hirifyToken = function () { return token; };
    window.hirifyActiveStorage = activeStorage;
    window.hirifyClearAuth = clearAuth;

    Object.defineProperty(window, 'hirifyTokenValue', {
        get: function () { return token; },
    });
})();
