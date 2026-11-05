import { createApiClient } from './api-client.js';

const statusLabels = { draft: 'Draf', pending: 'Antrean', processing: 'Diproses', completed: 'Selesai', failed: 'Gagal' };
const fieldErrors = errors => Object.fromEntries(Object.entries(errors ?? {}).map(([key, values]) => [key, Array.isArray(values) ? values[0] : values]));
const messageFor = error => error.errors ? Object.values(error.errors).flat().join(' ') : error.message;

/** Register the authenticated application components before Alpine starts. */
export function registerNome(Alpine) {
    Alpine.data('nomeSession', () => ({
        isLoggedIn: false, authLoading: true, showLoginModal: false, user: null, api: null,
        init() {
            window.nomeApiReady = this.initialize();
        },
        async initialize() {
            this.api = createApiClient({
                storage: sessionStorage,
                onUnauthorized: () => {
                    this.isLoggedIn = false;
                    this.user = null;
                    if (location.pathname !== '/login') location.assign('/login');
                },
            });
            localStorage.removeItem('nome_is_logged_in');
            if (this.api.hasToken()) {
                try {
                    this.user = await this.api.request('auth/me');
                    this.isLoggedIn = true;
                } catch (error) {
                    this.api.clear();
                }
            }
            this.authLoading = false;
            return this.api;
        },
        setLoggedIn(value) { if (value) location.assign('/login'); else return this.logout(); },
        async logout() {
            try { await this.api.request('auth/logout', { method: 'POST' }); }
            finally {
                this.api.clear();
                sessionStorage.removeItem('nome_memo_draft_v1');
                this.isLoggedIn = false;
                this.user = null;
                location.assign('/login');
            }
        },
    }));
    Alpine.data('nomeLogin', () => ({
        email: '', password: '', busy: false, error: '', errors: {},
        async submit() {
            if (this.busy) return;
            this.busy = true; this.error = ''; this.errors = {};
            try {
                const api = await window.nomeApiReady;
                await api.login(this.email, this.password);
                this.password = '';
                location.assign('/memo');
            } catch (error) {
                this.error = messageFor(error);
                this.errors = fieldErrors(error.errors);
            } finally { this.busy = false; }
        },
    }));
    Alpine.data('nomeHistory', () => ({
        searchQuery: '', selectedStatus: 'all', dateFrom: '', dateTo: '', viewMode: 'grid',
        memos: [], meta: { current_page: 1, last_page: 1, total: 0 },
        loading: false, error: '', controller: null,
        async init() {
            await window.nomeApiReady;
            if (!this.api?.hasToken()) return;
            await this.load(1);
        },
        get filteredMemos() { return this.memos; },
        memoUrl(memo) { return '/preview?memo=' + encodeURIComponent(memo.id); },
        async load(page = 1) {
            const api = await window.nomeApiReady;
            if (!api.hasToken()) return;
            this.controller?.abort();
            const controller = new AbortController();
            this.controller = controller;
            this.loading = true; this.error = '';
            const query = new URLSearchParams({ page: String(page), per_page: '15' });
            if (this.searchQuery.trim()) query.set('search', this.searchQuery.trim());
            if (this.selectedStatus !== 'all') query.set('status', this.selectedStatus);
            if (this.dateFrom) query.set('date_from', this.dateFrom);
            if (this.dateTo) query.set('date_to', this.dateTo);
            try {
                const result = await api.request('memos?' + query, { signal: controller.signal });
                this.memos = result.items.map(memo => ({
                    ...memo, letterNo: memo.letter_number ?? 'Tanpa nomor surat',
                    date: memo.meeting_date + (memo.meeting_time ? ' • ' + memo.meeting_time + ' WITA' : ''),
                    leader: memo.leader_name ?? '', attendeesCount: memo.attendees_count,
                    statusLabel: statusLabels[memo.status] ?? memo.status,
                }));
                this.meta = result.meta;
            } catch (error) {
                if (error.name !== 'AbortError') this.error = messageFor(error);
            } finally { if (this.controller === controller) this.loading = false; }
        },
        destroy() { this.controller?.abort(); },
    }));
    Alpine.data('nomePreview', () => ({
        memoId: new URLSearchParams(location.search).get('memo'), data: null, loading: true, busy: false,
        activeTab: 'document', error: '', notice: '', dirty: false, timer: null, controller: null, disposed: false,
        metadata: {}, letter: {}, attendees: [], includeLetter: false,
        get processing() { return ['pending', 'processing'].includes(this.data?.memo.status); },
        get statusLabel() { return statusLabels[this.data?.memo.status] ?? ''; },
        async init() {
            const api = await window.nomeApiReady;
            if (!api.hasToken()) { this.loading = false; return; }
            if (!this.memoId) { this.error = 'Pilih memo dari halaman riwayat.'; this.loading = false; return; }
            await this.load();
        },
        async load() {
            this.controller?.abort();
            this.controller = new AbortController();
            try {
                const api = await window.nomeApiReady;
                this.data = await api.request('memos/' + this.memoId + '/preview', { signal: this.controller.signal });
                this.metadata = Object.fromEntries(['title', 'meeting_date', 'meeting_time', 'meeting_end_time', 'location', 'leader_name', 'notetaker_name', 'agenda'].map(key => [key, this.data.memo[key] ?? '']));
                this.letter = { ...(this.data.letter ?? {}) };
                this.includeLetter = this.data.letter !== null;
                this.attendees = this.data.attendees.map(person => ({ name: person.name, agency_or_position: person.agency_or_position ?? '', source: person.source ?? 'manual' }));
                this.dirty = false;
                this.error = '';
                if (this.processing) this.schedulePoll();
            } catch (error) { if (error.name !== 'AbortError') this.error = messageFor(error); }
            finally { this.loading = false; }
        },
        schedulePoll() {
            clearTimeout(this.timer);
            if (!this.disposed) this.timer = setTimeout(() => this.poll(), 5000);
        },
        async poll() {
            clearTimeout(this.timer);
            this.controller?.abort();
            this.controller = new AbortController();
            try {
                const api = await window.nomeApiReady;
                const status = await api.request('memos/' + this.memoId + '/status', { signal: this.controller.signal });
                if (['completed', 'failed'].includes(status.status)) await this.load();
                else this.schedulePoll();
            } catch (error) {
                if (error.name !== 'AbortError') { this.error = messageFor(error); this.schedulePoll(); }
            }
        },
        async save() {
            if (this.busy || this.processing) return;
            this.busy = true; this.error = ''; this.notice = '';
            try {
                const api = await window.nomeApiReady;
                await api.request('memos/' + this.memoId, { method: 'PUT', body: {
                    ...this.metadata,
                    letter: this.includeLetter ? this.letter : null,
                    attendees: this.attendees,
                    summary_text: this.$refs.summary.innerHTML, version: this.data.memo.version,
                } });
                await this.load();
                this.notice = 'Perubahan tersimpan.';
            } catch (error) { this.error = messageFor(error); }
            finally { this.busy = false; }
        },
        pasteSummary(event) {
            const selection = window.getSelection();
            if (!selection?.rangeCount) return;
            const range = selection.getRangeAt(0);
            range.deleteContents();
            const text = document.createTextNode(event.clipboardData.getData('text/plain'));
            range.insertNode(text);
            range.setStartAfter(text);
            range.collapse(true);
            selection.removeAllRanges();
            selection.addRange(range);
            this.dirty = true;
        },
        async upload(event) {
            const file = event.target.files[0];
            if (!file) return;
            const { validateAudioFile } = await import('./memo-fields.js');
            const invalid = validateAudioFile(file);
            if (invalid) { this.error = invalid; event.target.value = ''; return; }
            if ((this.dirty || this.data?.memo.status === 'completed') && !confirm('Audio baru akan menghasilkan ringkasan pengganti setelah selesai. Perubahan yang belum disimpan akan hilang. Lanjutkan?')) {
                event.target.value = ''; return;
            }
            this.busy = true; this.error = '';
            try {
                const api = await window.nomeApiReady;
                const body = new FormData(); body.append('audio', file);
                await api.request('memos/' + this.memoId + '/upload-audio', { method: 'POST', body });
                await this.load();
            } catch (error) { this.error = messageFor(error); }
            finally { this.busy = false; event.target.value = ''; }
        },
        async download(type) {
            if (this.busy || !this.data?.can_export || this.dirty) return;
            this.busy = true; this.error = '';
            try {
                const api = await window.nomeApiReady;
                const blob = await api.download('memos/' + this.memoId + '/export/' + type);
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob); link.download = 'notulen.' + type;
                document.body.append(link); link.click(); link.remove();
                setTimeout(() => URL.revokeObjectURL(link.href), 1000);
            } catch (error) { this.error = messageFor(error); }
            finally { this.busy = false; }
        },
        async remove() {
            if (!confirm('Hapus memo beserta audio secara permanen? Tindakan ini tidak dapat dibatalkan.')) return;
            this.busy = true;
            try {
                const api = await window.nomeApiReady;
                await api.request('memos/' + this.memoId, { method: 'DELETE' });
                location.assign('/memo');
            } catch (error) { this.error = messageFor(error); this.busy = false; }
        },
        destroy() { this.disposed = true; clearTimeout(this.timer); this.controller?.abort(); },
    }));
}
