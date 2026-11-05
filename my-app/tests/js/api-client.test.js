import assert from 'node:assert/strict';
import { test } from 'node:test';
import { ApiError, createApiClient } from '../../public/js/api-client.js';

function setup(responder) {
    const values = new Map();
    const calls = [];
    let unauthorized = 0;
    const storage = { getItem: key => values.get(key) ?? null, setItem: (key, value) => values.set(key, value), removeItem: key => values.delete(key) };
    const client = createApiClient({
        storage,
        fetchImpl: async (...args) => { calls.push(args); return responder(...args); },
        onUnauthorized: () => { unauthorized++; },
    });
    return { client, storage, calls, unauthorized: () => unauthorized };
}

const json = (body, status = 200) => new Response(JSON.stringify(body), { status, headers: { 'Content-Type': 'application/json' } });

test('login stores only the returned token, and protected JSON requests send it', async () => {
    const context = setup((path) => path.endsWith('/login')
        ? json({ success: true, data: { token: 'test-token', user: { id: 1, name: 'Test' } } })
        : json({ success: true, data: { id: 'memo' } }));
    assert.equal(context.client.hasToken(), false);
    assert.deepEqual(await context.client.login('test@example.test', 'password'), { id: 1, name: 'Test' });
    assert.equal(context.client.hasToken(), true);
    await context.client.request('memos', { method: 'POST', body: { title: 'Meeting' } });
    assert.equal(context.calls[0][1].headers.Authorization, undefined);
    assert.equal(context.calls[1][1].headers.Authorization, 'Bearer test-token');
    assert.equal(context.calls[1][1].headers['Content-Type'], 'application/json');
    assert.deepEqual(JSON.parse(context.calls[1][1].body), { title: 'Meeting' });
});

test('multipart requests leave Content-Type to the browser', async () => {
    const context = setup(() => json({ success: true, data: { status: 'processing' } }, 202));
    const body = new FormData();
    body.append('audio', new Blob(['sample'], { type: 'audio/wav' }), 'meeting.wav');
    await context.client.request('memos/id/upload-audio', { method: 'POST', body });
    assert.equal(context.calls[0][1].headers['Content-Type'], undefined);
    assert.equal(context.calls[0][1].body, body);
});

test('expired protected requests clear credentials and notify the session', async () => {
    const context = setup(() => json({ success: false, message: 'Expired' }, 401));
    context.storage.setItem('nome_api_token', 'expired');
    await assert.rejects(context.client.request('auth/me'), error => error instanceof ApiError && error.status === 401);
    assert.equal(context.client.hasToken(), false);
    assert.equal(context.unauthorized(), 1);
});

test('a failed login reports its error without triggering a redirect loop', async () => {
    const context = setup(() => json({ success: false, message: 'Wrong password' }, 401));
    await assert.rejects(context.client.login('test@nome.test', 'wrong'), /Wrong password/);
    assert.equal(context.unauthorized(), 0);
});

test('validation errors preserve field messages', async () => {
    const context = setup(() => json({ success: false, message: 'Invalid', errors: { title: ['Required'] } }, 422));
    await assert.rejects(context.client.request('memos', { method: 'POST', body: {} }), error => error.errors.title[0] === 'Required');
});

test('HTML server errors and network failures produce useful messages', async () => {
    const html = setup(() => new Response('<html>Error</html>', { status: 502 }));
    await assert.rejects(html.client.request('memos'), /502/);
    const network = setup(() => { throw new TypeError('Failed to fetch'); });
    await assert.rejects(network.client.request('memos'), /Tidak dapat menghubungi server/);
});

test('successful but malformed JSON is rejected', async () => {
    const context = setup(() => json({ unexpected: true }));
    await assert.rejects(context.client.request('memos'), /Respons server tidak valid/);
    await assert.rejects(context.client.login('user@test.test', 'password'), /Respons login tidak valid/);
});

test('download returns binary data rather than parsing it as JSON', async () => {
    const context = setup(() => new Response('%PDF-test', { headers: { 'Content-Type': 'application/pdf' } }));
    const file = await context.client.download('memos/id/export/pdf');
    assert.equal(await file.text(), '%PDF-test');
});

test('aborted requests retain AbortError and do not become connection errors', async () => {
    const context = setup(() => { throw new DOMException('Aborted', 'AbortError'); });
    await assert.rejects(context.client.request('memos'), error => error.name === 'AbortError');
});
