export class ApiError extends Error {
    constructor(message, status = 0, errors = null) {
        super(message);
        this.status = status;
        this.errors = errors;
    }
}

/** Create a same-origin Bearer client. Tokens live only in this browser tab. */
export function createApiClient({ storage, fetchImpl = globalThis.fetch, onUnauthorized = () => {} }) {
    const tokenKey = 'nome_api_token';
    const clear = () => storage.removeItem(tokenKey);
    async function send(path, { method = 'GET', body, signal, anonymous = false } = {}) {
        const headers = { Accept: 'application/json' };
        const token = anonymous ? null : storage.getItem(tokenKey);
        if (token) headers.Authorization = 'Bearer ' + token;
        const multipart = body instanceof FormData;
        if (body !== undefined && !multipart) headers['Content-Type'] = 'application/json';
        let response;
        try {
            response = await fetchImpl('/api/' + path.replace(/^\/+/, ''), {
                method, headers, body: body === undefined ? undefined : (multipart ? body : JSON.stringify(body)),
                signal, credentials: 'same-origin',
            });
        } catch (error) {
            if (error.name === 'AbortError') throw error;
            throw new ApiError('Tidak dapat menghubungi server. Periksa koneksi lalu coba lagi.');
        }
        if (response.status === 401 && !anonymous) {
            clear();
            onUnauthorized();
        }
        if (!response.ok) {
            const data = await response.json().catch(() => null);
            throw new ApiError(data?.message ?? 'Permintaan gagal (' + response.status + ').', response.status, data?.errors ?? null);
        }
        return response;
    }
    return {
        hasToken: () => Boolean(storage.getItem(tokenKey)),
        clear,
        async request(path, options) {
            const response = await send(path, options);
            const result = await response.json().catch(() => null);
            if (!result || result.success !== true) throw new ApiError(result?.message ?? 'Respons server tidak valid.', response.status, result?.errors);
            return result.data;
        },
        async login(email, password) {
            const response = await send('auth/login', { method: 'POST', body: { email, password }, anonymous: true });
            const result = await response.json();
            if (!result.success || !result.data?.token) throw new ApiError('Respons login tidak valid.');
            storage.setItem(tokenKey, result.data.token);
            return result.data.user;
        },
        async download(path) {
            const response = await send(path);
            return response.blob();
        },
    };
}
