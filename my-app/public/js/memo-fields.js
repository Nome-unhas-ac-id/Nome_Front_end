export const AUDIO_MAX_BYTES = 100 * 1024 * 1024;

const audioExtensions = new Set(['mp3', 'wav', 'm4a', 'ogg']);
const letterFields = [
    'letter_number', 'subject', 'letter_date', 'recipient', 'opening_paragraph',
    'signer_name', 'signer_position', 'signer_rank',
];
const text = value => typeof value === 'string' ? value.trim() : '';
const isDate = value => /^\d{4}-\d{2}-\d{2}$/.test(value)
    && !Number.isNaN(Date.parse(value))
    && new Date(value).toISOString().slice(0, 10) === value;

/**
 * @param {Date} [date] Current instant, defaulting to the browser clock.
 * @returns {string} Meeting date in WITA, formatted as YYYY-MM-DD.
 */
export function meetingDateToday(date = new Date()) {
    const parts = new Intl.DateTimeFormat('en', {
        timeZone: 'Asia/Makassar', year: 'numeric', month: '2-digit', day: '2-digit',
    }).formatToParts(date);

    return ['year', 'month', 'day'].map(type => parts.find(part => part.type === type).value).join('-');
}

/**
 * Check the documented upload limits; the server must still validate file contents.
 * @param {{name: string, size: number}|null} file Selected audio file.
 * @returns {string|null} User-facing validation message, or null when accepted.
 */
export function validateAudioFile(file) {
    if (!file || !Number.isFinite(file.size) || file.size <= 0) {
        return 'Pilih berkas audio yang tidak kosong.';
    }
    if (!audioExtensions.has(text(file.name).split('.').at(-1)?.toLowerCase())) {
        return 'Format audio harus MP3, WAV, M4A, atau OGG.';
    }
    if (file.size > AUDIO_MAX_BYTES) {
        return 'Ukuran audio maksimal 100 MB.';
    }

    return null;
}

/**
 * Validate meeting fields without imposing undocumented backend length limits.
 * @param {object} form Meeting form state.
 * @returns {Record<string, string>} Field-specific validation messages.
 */
export function validateMemoFields(form) {
    const errors = {};
    if (!text(form.meetingTitle)) errors.title = 'Judul rapat wajib diisi.';
    if (!isDate(text(form.meetingDate))) errors.meeting_date = 'Tanggal rapat tidak valid.';
    for (const [key, field] of [['meeting_time', 'meetingTimeStart'], ['meeting_end_time', 'meetingTimeEnd']]) {
        if (text(form[field]) && !/^([01]\d|2[0-3]):[0-5]\d$/.test(text(form[field]))) {
            errors[key] = 'Gunakan waktu dengan format HH:MM.';
        }
    }
    if (form.includeLetter && text(form.letter?.letter_date) && !isDate(text(form.letter.letter_date))) {
        errors.letter_date = 'Tanggal surat tidak valid.';
    }

    return errors;
}

/**
 * Map UI fields to the unified CREATE contract, including agenda and end time.
 * For updates, attendees replaces the full list; omit it to preserve server attendees.
 * @param {object} form Meeting form state.
 * @returns {object} JSON payload for POST /api/memos (not a generic PUT payload).
 */
export function createMemoPayload(form) {
    const payload = { title: text(form.meetingTitle), meeting_date: text(form.meetingDate) };
    for (const [key, field] of Object.entries({
        meeting_time: 'meetingTimeStart', location: 'meetingLocation',
        leader_name: 'meetingLeader', notetaker_name: 'meetingNotetaker',
        agenda: 'agenda', meeting_end_time: 'meetingTimeEnd',
    })) {
        if (text(form[field])) payload[key] = text(form[field]);
    }
    payload.attendees = (Array.isArray(form.attendees) ? form.attendees : [])
        .filter(person => text(person?.name))
        .map(person => ({
            name: text(person.name), agency_or_position: text(person.agency_or_position), source: 'manual',
        }));
    if (form.includeLetter) {
        payload.letter = Object.fromEntries(letterFields
            .filter(field => text(form.letter?.[field]))
            .map(field => [field, text(form.letter[field])]));
    }

    return payload;
}

/**
 * Capture text metadata only. Audio, tokens, timers and Alpine internals are never stored.
 * @param {object} form Meeting form state.
 * @returns {{version: number, form: object}} Tab-scoped draft for explicit sessionStorage saving.
 */
export function createMemoDraft(form) {
    return {
        version: 1,
        form: {
            ...Object.fromEntries([
                'meetingTitle', 'meetingDate', 'meetingTimeStart', 'meetingTimeEnd',
                'meetingLocation', 'meetingLeader', 'meetingNotetaker', 'agenda',
            ].map(field => [field, text(form[field])])),
            attendees: createMemoPayload(form).attendees,
            includeLetter: form.includeLetter === true,
            letter: Object.fromEntries(letterFields.map(field => [field, text(form.letter?.[field])])),
        },
    };
}

/**
 * Restore only recognized draft fields; malformed storage is reported to the caller.
 * @param {string|null} serialized Previously saved JSON.
 * @returns {object|null} Normalized form state, or null when no draft exists.
 * @throws {Error} When saved data is corrupt or has an unsupported version.
 */
export function restoreMemoDraft(serialized) {
    if (!serialized) return null;
    const draft = JSON.parse(serialized);
    if (draft?.version !== 1 || !draft.form || typeof draft.form !== 'object' || Array.isArray(draft.form)) {
        throw new Error('Draf tidak dapat dibaca. Silakan buat draf baru.');
    }

    return createMemoDraft(draft.form).form;
}
