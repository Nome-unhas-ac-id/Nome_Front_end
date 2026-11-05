@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 pb-20" x-data="{
    draft: null,
    error: '',
    async init() {
        try {
            const { restoreMemoDraft } = await import(new URL('{{ asset('js/memo-fields.js') }}', window.location.href).href);
            this.draft = restoreMemoDraft(sessionStorage.getItem('nome_memo_draft_v1'));
            if (!this.draft) this.error = 'Belum ada draf di tab ini. Buat dan simpan catatan terlebih dahulu.';
        } catch {
            this.error = 'Draf tidak dapat dibaca. Kembali ke formulir untuk membuat draf baru.';
        }
    }
}">
    <div class="flex flex-wrap items-start justify-between gap-4 pt-6">
        <div class="space-y-3">
            <h1 class="text-4xl sm:text-5xl font-black tracking-tighter">Pratinjau Draf.</h1>
            <p class="text-sm text-black/55 max-w-xl">Draf di tab ini belum dikirim ke server. Ringkasan AI, transkrip, dan ekspor tersedia setelah integrasi pemrosesan audio.</p>
        </div>
        <a href="{{ route('add-memo') }}" class="rounded-full border border-[#d9d9d9] px-5 py-2.5 text-sm font-semibold">Kembali Sunting Draf</a>
    </div>
    <p x-show="error" x-text="error" role="alert" class="rounded-2xl bg-red-50 p-5 text-sm text-red-800"></p>
    <template x-if="draft">
        <article class="bg-white border border-[#d9d9d9] rounded-3xl p-8 sm:p-12 space-y-9">
            <div class="space-y-2 border-b border-[#d9d9d9] pb-6">
                <p class="text-xs font-bold uppercase tracking-wider text-black/50">Draf Notulensi Rapat</p>
                <h2 class="text-2xl font-bold tracking-tight" x-text="draft.meetingTitle"></h2>
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-3 text-sm">
                <dt class="text-black/50">Tanggal Rapat</dt><dd class="sm:col-span-2" x-text="draft.meetingDate"></dd>
                <dt class="text-black/50">Waktu Mulai</dt><dd class="sm:col-span-2" x-text="draft.meetingTimeStart ? draft.meetingTimeStart + ' WITA' : 'Belum diisi'"></dd>
                <dt class="text-black/50">Waktu Selesai (Draf)</dt><dd class="sm:col-span-2" x-text="draft.meetingTimeEnd ? draft.meetingTimeEnd + ' WITA' : 'Belum diisi'"></dd>
                <dt class="text-black/50">Lokasi</dt><dd class="sm:col-span-2" x-text="draft.meetingLocation || 'Belum diisi'"></dd>
                <dt class="text-black/50">Pimpinan Rapat</dt><dd class="sm:col-span-2" x-text="draft.meetingLeader || 'Belum diisi'"></dd>
                <dt class="text-black/50">Notulis</dt><dd class="sm:col-span-2" x-text="draft.meetingNotetaker || 'Belum diisi'"></dd>
            </dl>
            <section class="space-y-3">
                <h3 class="font-bold">Agenda Pembahasan (Draf)</h3>
                <p class="text-sm whitespace-pre-wrap leading-relaxed" x-text="draft.agenda || 'Belum diisi'"></p>
            </section>
            <section class="space-y-3">
                <h3 class="font-bold">Peserta Rapat</h3>
                <p x-show="!draft.attendees.length" class="text-sm text-black/50">Belum ada peserta.</p>
                <ol class="list-decimal pl-5 space-y-2 text-sm">
                    <template x-for="(person, index) in draft.attendees" :key="index">
                        <li><span x-text="person.name"></span><span x-show="person.agency_or_position" x-text="' — ' + person.agency_or_position" class="text-black/55"></span></li>
                    </template>
                </ol>
            </section>
            <section x-show="draft.includeLetter" class="space-y-4 border-t border-[#d9d9d9] pt-6">
                <h3 class="font-bold">Surat Pengantar</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-3 text-sm">
                    @foreach ([
                        'letter_number' => 'Nomor Surat', 'subject' => 'Perihal', 'letter_date' => 'Tanggal Surat',
                        'recipient' => 'Penerima', 'signer_name' => 'Penandatangan',
                        'signer_position' => 'Jabatan', 'signer_rank' => 'Pangkat',
                    ] as $field => $label)
                        <dt class="text-black/50">{{ $label }}</dt><dd class="sm:col-span-2" x-text="draft.letter.{{ $field }} || 'Belum diisi'"></dd>
                    @endforeach
                </dl>
                <p class="text-sm whitespace-pre-wrap leading-relaxed" x-text="draft.letter.opening_paragraph"></p>
            </section>
        </article>
    </template>
</div>
@endsection
