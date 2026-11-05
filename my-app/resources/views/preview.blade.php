@extends('layouts.app')

@section('content')
<div x-data="nomePreview" class="max-w-6xl mx-auto space-y-7 pb-20">
    <div class="flex flex-wrap justify-between items-center gap-4 pt-6">
        <h1 class="text-4xl sm:text-5xl font-black tracking-tighter">Pratinjau Catatan.</h1>
        <a href="{{ route('memo') }}" class="rounded-full border border-[#d9d9d9] px-5 py-2.5 text-sm">Kembali ke Memo</a>
    </div>
    <p x-show="!isLoggedIn && !authLoading" class="text-sm">Masuk untuk membuka memo. <a href="{{ route('login') }}" class="underline">Masuk ke Akun</a></p>
    <p x-show="loading && isLoggedIn" role="status">Memuat memo...</p>
    <p x-show="error" x-text="error" role="alert" class="bg-red-50 text-red-800 rounded-xl p-4 text-sm"></p>
    <button x-show="error && data" type="button" @click="if (!dirty || confirm('Muat ulang dan buang perubahan yang belum disimpan?')) load()" class="text-sm underline">Muat Ulang Memo</button>
    <p x-show="notice" x-text="notice" role="status" class="text-sm text-green-800"></p>
    <template x-if="data && isLoggedIn">
        <div class="space-y-7">
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <span class="rounded-full bg-gray-100 px-4 py-2 font-semibold" x-text="statusLabel"></span>
                <span x-show="processing">Audio sedang diproses. Anda dapat meninggalkan halaman dan kembali melalui riwayat.</span>
                <span x-show="dirty" class="text-amber-800">Ada perubahan yang belum disimpan.</span>
            </div>
            <p x-show="data.memo.error_message" x-text="data.memo.error_message" role="alert" class="text-red-700 text-sm"></p>
            <div class="flex flex-wrap gap-3">
                <button type="button" @click="save()" :disabled="busy || processing" class="rounded-full bg-[#ff5347] px-6 py-3 text-sm font-bold text-white disabled:opacity-40">Simpan Perubahan</button>
                <button type="button" @click="download('pdf')" :disabled="busy || !data.can_export || dirty" class="rounded-full border border-[#d9d9d9] px-5 py-3 text-sm disabled:opacity-40">Unduh PDF</button>
                <button type="button" @click="download('docx')" :disabled="busy || !data.can_export || dirty" class="rounded-full border border-[#d9d9d9] px-5 py-3 text-sm disabled:opacity-40">Unduh DOCX</button>
                <button type="button" @click="remove()" :disabled="busy || processing" class="rounded-full border border-red-200 text-red-700 px-5 py-3 text-sm disabled:opacity-40">Hapus Memo</button>
            </div>
            <div class="rounded-2xl border border-[#d9d9d9] p-5 space-y-2">
                <label for="memo-audio" class="block text-sm font-semibold">Unggah / Ganti Audio</label>
                <input id="memo-audio" type="file" accept=".mp3,.wav,.m4a,.ogg" @change="upload($event)" :disabled="busy || processing" class="text-sm max-w-full">
                <p class="text-xs text-black/55">MP3, WAV, M4A, OGG; maksimal 100 MB. Hasil baru menggantikan ringkasan lama setelah berhasil diproses.</p>
                <button x-show="error && processing" type="button" @click="poll()" class="text-sm underline">Periksa Status Lagi</button>
            </div>
            <details class="rounded-2xl border border-[#d9d9d9] bg-white p-6">
                <summary class="font-bold cursor-pointer">Sunting Detail Rapat, Surat & Peserta</summary>
                <fieldset :disabled="busy || processing" @input="dirty = true" @change="dirty = true" class="space-y-6 pt-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @foreach (['title' => ['Judul Rapat', 'text'], 'meeting_date' => ['Tanggal Rapat', 'date'], 'meeting_time' => ['Waktu Mulai (WITA)', 'time'], 'meeting_end_time' => ['Waktu Selesai (WITA)', 'time'], 'location' => ['Lokasi', 'text'], 'leader_name' => ['Pimpinan Rapat', 'text'], 'notetaker_name' => ['Notulis', 'text']] as $field => [$label, $type])
                            <label class="block space-y-2 text-sm">{{ $label }}<input type="{{ $type }}" x-model="metadata.{{ $field }}" class="block w-full border border-[#d9d9d9] rounded-lg p-2.5"></label>
                        @endforeach
                    </div>
                    <label class="block text-sm space-y-2">Agenda<textarea rows="3" x-model="metadata.agenda" class="block w-full border border-[#d9d9d9] rounded-lg p-2.5"></textarea></label>
                    <label class="flex items-center gap-2 text-sm"><input type="checkbox" x-model="includeLetter"> Sertakan Surat Pengantar</label>
                    <div x-show="includeLetter" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @foreach (['letter_number' => ['Nomor Surat', 'text'], 'subject' => ['Perihal', 'text'], 'letter_date' => ['Tanggal Surat', 'date'], 'recipient' => ['Penerima', 'text'], 'signer_name' => ['Penandatangan', 'text'], 'signer_position' => ['Jabatan', 'text'], 'signer_rank' => ['Pangkat', 'text']] as $field => [$label, $type])
                            <label class="text-sm space-y-2">{{ $label }}<input type="{{ $type }}" x-model="letter.{{ $field }}" class="block w-full border border-[#d9d9d9] rounded-lg p-2.5"></label>
                        @endforeach
                        <label class="text-sm space-y-2 sm:col-span-2">Paragraf Pembuka<textarea x-model="letter.opening_paragraph" class="block w-full border border-[#d9d9d9] rounded-lg p-2.5"></textarea></label>
                    </div>
                    <div class="space-y-3">
                        <h2 class="font-bold">Daftar Peserta</h2>
                        <template x-for="(person, index) in attendees" :key="index">
                            <div class="flex flex-wrap gap-3">
                                <input x-model="person.name" aria-label="Nama peserta" placeholder="Nama peserta" class="flex-1 min-w-40 border border-[#d9d9d9] rounded-lg p-2 text-sm">
                                <input x-model="person.agency_or_position" aria-label="Instansi atau jabatan" placeholder="Instansi / Jabatan" class="flex-1 min-w-40 border border-[#d9d9d9] rounded-lg p-2 text-sm">
                                <button type="button" @click="attendees.splice(index, 1); dirty = true" class="text-sm text-red-700">Hapus Peserta</button>
                            </div>
                        </template>
                        <button type="button" @click="attendees.push({ name: '', agency_or_position: '', source: 'manual' }); dirty = true" class="text-sm underline">Tambah Peserta</button>
                    </div>
                </fieldset>
            </details>
            <div class="flex flex-wrap gap-2">
                <button type="button" @click="activeTab = 'document'" class="rounded-full border border-[#d9d9d9] px-5 py-2 text-sm" :class="activeTab === 'document' ? 'bg-black text-white' : ''">Dokumen</button>
                <button type="button" @click="activeTab = 'transcript'" class="rounded-full border border-[#d9d9d9] px-5 py-2 text-sm" :class="activeTab === 'transcript' ? 'bg-black text-white' : ''">Transkrip</button>
                <button type="button" x-show="data.ai_raw_json" @click="activeTab = 'json'" class="rounded-full border border-[#d9d9d9] px-5 py-2 text-sm">Data AI</button>
            </div>
            <article x-show="activeTab === 'document'" class="bg-white rounded-3xl border border-[#d9d9d9] p-7 sm:p-12 space-y-6">
                <h2 class="text-2xl font-bold" x-text="data.memo.title"></h2>
                <p class="text-sm text-black/55" x-text="data.memo.meeting_date_label + ' • ' + (data.memo.meeting_time_label ?? '')"></p>
                <p class="text-sm whitespace-pre-wrap" x-text="data.memo.agenda"></p>
                <div class="flex gap-3 text-sm" x-show="!processing">
                    <button type="button" @mousedown.prevent @click="document.execCommand('bold'); dirty = true" class="font-bold border rounded px-3 py-1">Tebal</button>
                    <button type="button" @mousedown.prevent @click="document.execCommand('italic'); dirty = true" class="italic border rounded px-3 py-1">Miring</button>
                    <button type="button" @mousedown.prevent @click="document.execCommand('insertUnorderedList'); dirty = true" class="border rounded px-3 py-1">Daftar Poin</button>
                </div>
                <p x-show="!data.summary_html && !dirty" class="text-sm text-black/50">Belum ada ringkasan. Unggah audio atau tulis catatan di bawah.</p>
                <div x-ref="summary" x-html="data.summary_html" :contenteditable="!processing && !busy" @input="dirty = true" @paste.prevent="pasteSummary($event)" role="textbox" aria-label="Ringkasan rapat" aria-multiline="true" class="min-h-48 border border-[#d9d9d9] rounded-xl p-5 text-sm leading-relaxed [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:list-decimal [&_ol]:pl-6"></div>
                <p class="text-xs text-black/50">Simpan perubahan sebelum mengunduh. Ekspor tersedia setelah pemrosesan selesai.</p>
            </article>
            <section x-show="activeTab === 'transcript'" class="bg-white rounded-3xl border border-[#d9d9d9] p-8">
                <h2 class="text-xl font-bold mb-4">Transkrip Percakapan</h2>
                <p class="whitespace-pre-wrap leading-relaxed text-sm" x-text="data.transcript || 'Transkrip belum tersedia.'"></p>
            </section>
            <pre x-show="activeTab === 'json'" x-text="JSON.stringify(data.ai_raw_json, null, 2)" class="bg-black text-white p-7 rounded-3xl overflow-x-auto text-xs"></pre>
        </div>
    </template>
</div>
@endsection
