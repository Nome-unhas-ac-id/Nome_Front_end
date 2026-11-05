import assert from 'node:assert/strict';
import { test } from 'node:test';
import {
    AUDIO_MAX_BYTES, createMemoDraft, createMemoPayload, meetingDateToday,
    restoreMemoDraft, validateAudioFile, validateMemoFields,
} from '../../public/js/memo-fields.js';

const meeting = () => ({
    meetingTitle: ' Rapat Tim ', meetingDate: '2026-11-10',
    meetingTimeStart: '09:30', meetingTimeEnd: '11:00',
    meetingLocation: ' Ruang A ', meetingLeader: ' Andi ', meetingNotetaker: ' Siti ',
    agenda: ' Catatan agenda lokal ', includeLetter: true,
    letter: {
        letter_number: ' 005/123 ', subject: ' Undangan ', letter_date: '2026-11-05',
        recipient: ' Tim ', opening_paragraph: ' Dengan hormat, ', signer_name: ' Andi ',
        signer_position: ' Kepala ', signer_rank: ' Pembina ', unknown: 'excluded',
    },
    attendees: [{ name: ' Budi ', agency_or_position: ' Kominfo ', source: 'manual' }],
});

test('create payload matches the backend contract and excludes unsupported metadata', () => {
    const form = { ...meeting(), token: 'secret', summary_text: '<p>not allowed on create</p>' };
    assert.deepEqual(createMemoPayload(form), {
        title: 'Rapat Tim', meeting_date: '2026-11-10', meeting_time: '09:30',
        location: 'Ruang A', leader_name: 'Andi', notetaker_name: 'Siti',
        agenda: 'Catatan agenda lokal', meeting_end_time: '11:00',
        attendees: [{ name: 'Budi', agency_or_position: 'Kominfo', source: 'manual' }],
        letter: {
            letter_number: '005/123', subject: 'Undangan', letter_date: '2026-11-05',
            recipient: 'Tim', opening_paragraph: 'Dengan hormat,', signer_name: 'Andi',
            signer_position: 'Kepala', signer_rank: 'Pembina',
        },
    });
    assert.equal(form.meetingTitle, ' Rapat Tim ');
});

test('create omits an unchecked letter, even when old letter fields remain', () => {
    const payload = createMemoPayload({ meetingTitle: 'Tim', meetingDate: '2026-11-10', includeLetter: false, letter: meeting().letter });
    assert.deepEqual(payload, { title: 'Tim', meeting_date: '2026-11-10', attendees: [] });
    assert.equal('letter' in payload, false);
});

test('blank attendee rows and empty letter values are omitted', () => {
    const payload = createMemoPayload({ ...meeting(), attendees: [null, { name: ' ' }, { name: 'Ali' }], letter: {} });
    assert.deepEqual(payload.attendees, [{ name: 'Ali', agency_or_position: '', source: 'manual' }]);
    assert.deepEqual(payload.letter, {});
});

test('only text metadata survives a draft round trip; agenda and end time are preserved locally', () => {
    const draft = createMemoDraft({ ...meeting(), token: 'secret', uploadedFile: { name: 'audio.mp3' }, isLoggedIn: true });
    const restored = restoreMemoDraft(JSON.stringify(draft));
    assert.equal(restored.agenda, 'Catatan agenda lokal');
    assert.equal(restored.meetingTimeEnd, '11:00');
    assert.equal(restored.letter.signer_rank, 'Pembina');
    assert.equal('token' in restored, false);
    assert.equal('uploadedFile' in restored, false);
    assert.equal('isLoggedIn' in restored, false);
    assert.equal('unknown' in restored.letter, false);
    assert.deepEqual(createMemoPayload(restored), createMemoPayload(meeting()));
});

test('missing draft returns null; corrupt or unsupported storage reports failure', () => {
    assert.equal(restoreMemoDraft(null), null);
    assert.throws(() => restoreMemoDraft('{broken'), SyntaxError);
    for (const value of [null, {}, { version: 2, form: {} }, { version: 1, form: [] }]) {
        assert.throws(() => restoreMemoDraft(JSON.stringify(value)));
    }
});

test('restored drafts cannot inject extra Alpine properties', () => {
    const restored = restoreMemoDraft(JSON.stringify({ version: 1, form: { ...meeting(), step: 999, saveDraft: 'malicious' } }));
    assert.equal('step' in restored, false);
    assert.equal('saveDraft' in restored, false);
});

test('required fields, real calendar dates, and optional times are validated', () => {
    assert.deepEqual(validateMemoFields(meeting()), {});
    assert.deepEqual(validateMemoFields({ meetingTitle: 'T', meetingDate: '2026-11-10' }), {});
    const errors = validateMemoFields({ ...meeting(), meetingTitle: ' ', meetingDate: '2026-02-30', meetingTimeStart: '24:00', meetingTimeEnd: '9:30', letter: { letter_date: 'invalid' } });
    assert.deepEqual(Object.keys(errors).sort(), ['letter_date', 'meeting_date', 'meeting_end_time', 'meeting_time', 'title']);
    assert.equal(validateMemoFields({ ...meeting(), includeLetter: false, letter: { letter_date: 'invalid' } }).letter_date, undefined);
});

test('dates respect WITA across UTC midnight boundaries', () => {
    assert.equal(meetingDateToday(new Date('2026-11-05T16:30:00Z')), '2026-11-06');
    assert.match(meetingDateToday(), /^\d{4}-\d{2}-\d{2}$/);
});

test('all four documented extensions accept nonempty audio up to the limit', () => {
    for (const name of ['meeting.MP3', 'meeting.wav', 'meeting.m4a', 'meeting.ogg']) {
        assert.equal(validateAudioFile({ name, size: AUDIO_MAX_BYTES }), null);
    }
});

test('empty, malformed, unsupported and oversized uploads are rejected', () => {
    for (const file of [null, { name: 'a.mp3', size: 0 }, { name: 'a.mp3', size: NaN }, { name: 'a.mp3', size: -1 }]) {
        assert.match(validateAudioFile(file), /tidak kosong/);
    }
    for (const name of ['a.aac', 'a.webm', 'a.mp3.exe', '', undefined]) {
        assert.match(validateAudioFile({ name, size: 1 }), /Format audio/);
    }
    assert.match(validateAudioFile({ name: 'a.mp3', size: AUDIO_MAX_BYTES + 1 }), /100 MB/);
});
