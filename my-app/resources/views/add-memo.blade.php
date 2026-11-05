@extends('layouts.app')

@section('main_class', 'flex-1 w-full px-6 sm:px-10 lg:px-14 pt-28')

@section('content')
<!-- ======================================================== -->
<!-- 1. LOCKED STATE (UNAUTHENTICATED): x-show="!isLoggedIn && !authLoading" -->
<!-- ======================================================== -->
<div x-show="!isLoggedIn && !authLoading" x-cloak class="max-w-xl mx-auto py-16 sm:py-24 text-center">
    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-10 sm:p-14 space-y-6 shadow-none">
        <div class="w-16 h-16 rounded-2xl bg-[#ff5347]/10 border border-[#ff5347]/20 flex items-center justify-center mx-auto text-[#ff5347]">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
            </svg>
        </div>

        <div class="space-y-2">
            <span class="inline-block px-3 py-1 rounded-full bg-[#ff5347]/10 text-[#ff5347] text-[11px] font-bold tracking-wider uppercase">
                Ruang Kerja Terproteksi
            </span>
            <h2 class="text-[32px] sm:text-[38px] font-black tracking-tighter text-black leading-tight">
                Ruang Rapat Terkunci.
            </h2>
            <p class="text-[15px] font-semibold text-black/85">
                Harap masuk untuk mulai mencatat rapat
            </p>
            <p class="text-[13px] text-black/55 max-w-md mx-auto leading-relaxed">
                Unggah rekaman audio dan susun notulensi rapat setelah masuk ke akun Anda.
            </p>
        </div>

        <div class="space-y-3 pt-2">
            <button type="button" 
                    @click="showLoginModal = true" 
                    class="w-full bg-[#ff5347] hover:bg-[#e0453a] text-white font-bold text-[14px] rounded-full py-3.5 transition-all duration-300 ease-out hover:-translate-y-0.5 active:scale-95 shadow-none cursor-pointer">
                Buka Pintu Masuk
            </button>
            <div class="flex items-center justify-center gap-3">
                <a href="{{ url('/login') }}" 
                   class="flex-1 bg-white hover:bg-black/[0.04] text-black border border-[#d9d9d9] font-semibold text-[13px] rounded-full py-2.5 transition-all text-center">
                    Masuk ke Akun
                </a>
                <a href="{{ url('/signup') }}" 
                   class="flex-1 bg-white hover:bg-black/[0.04] text-black border border-[#d9d9d9] font-semibold text-[13px] rounded-full py-2.5 transition-all text-center">
                    Minta Akses Akun
                </a>
            </div>
            <button type="button" 
                    @click="window.location.href = '{{ route('login') }}'"
                    class="text-[12px] font-semibold text-[#ff5347] hover:underline pt-2 cursor-pointer">
                Masuk ke Akun
            </button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- 2. AUTHENTICATED STATE: x-show="isLoggedIn" -->
<!-- ======================================================== -->
<div x-show="isLoggedIn" x-cloak class="max-w-4xl mx-auto"
     :class="step === 1 ? 'h-[calc(100vh-7rem)] flex flex-col justify-center pb-24 overflow-hidden' : 'space-y-10 py-10 sm:py-14 min-h-screen overflow-visible'" 
     x-data="{
        step: 1,
        meetingTitle: '',
        meetingDate: '',
        meetingTimeStart: '',
        meetingTimeEnd: '',
        meetingLocation: '',
        meetingLeader: '',
        meetingNotetaker: '',
        agenda: '',
        includeLetter: false,
        letter: {
            letter_number: '', subject: '', letter_date: '', recipient: '', opening_paragraph: '',
            signer_name: '', signer_position: '', signer_rank: ''
        },
        attendees: [],
        errors: {},
        notice: '',
        isSaving: false,
        serverMemoId: null,
        async init() {
            try {
                const fields = await import(new URL('{{ asset('js/memo-fields.js') }}', window.location.href).href);
                this.meetingDate = fields.meetingDateToday();
                const saved = fields.restoreMemoDraft(sessionStorage.getItem('nome_memo_draft_v1'));
                if (saved) {
                    Object.assign(this, saved);
                    this.step = 2;
                    this.notice = 'Draf dipulihkan. Pilih ulang berkas audio bila diperlukan.';
                }
            } catch {
                this.notice = 'Draf lama tidak tersedia atau penyimpanan tab diblokir. Anda tetap dapat mengisi formulir.';
            }
        },
        newAttendeeName: '',
        newAttendeeRole: '',
        addAttendee() {
            if (this.newAttendeeName.trim()) {
                this.attendees.push({
                    name: this.newAttendeeName.trim(),
                    agency_or_position: this.newAttendeeRole.trim(),
                    source: 'manual'
                });
                this.newAttendeeName = '';
                this.newAttendeeRole = '';
            }
        },
        removeAttendee(idx) {
            this.attendees.splice(idx, 1);
        },

        // Audio controls
        audioMode: 'record',
        isRecording: false,
        recordTime: 0,
        recordTimer: null,
        formatTime(seconds) {
            const m = Math.floor(seconds / 60).toString().padStart(2, '0');
            const s = (seconds % 60).toString().padStart(2, '0');
            return `00:${m}:${s}`;
        },
        toggleRecording() {
            if (!this.isRecording) {
                this.isRecording = true;
                this.recordTimer = setInterval(() => { this.recordTime++; }, 1000);
            } else {
                clearInterval(this.recordTimer);
                this.isRecording = false;
            }
        },
        uploadedFileName: null,
        uploadedFileSize: null,
        uploadedFile: null,
        async handleFileUpload(e) {
            const input = e.target;
            const file = input.files[0];
            if (!file) return;
            this.uploadedFile = null;
            this.uploadedFileName = null;
            this.uploadedFileSize = null;
            try {
                const { validateAudioFile } = await import(new URL('{{ asset('js/memo-fields.js') }}', window.location.href).href);
                const error = validateAudioFile(file);
                this.errors.audio = error;
                if (error) {
                    input.value = '';
                    return;
                }
                this.uploadedFile = file;
                this.uploadedFileName = file.name;
                this.uploadedFileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            } catch {
                input.value = '';
                this.errors.audio = 'Berkas tidak dapat diperiksa. Silakan coba lagi.';
            }
        },

        async saveDraft(preview = false) {
            if (this.isSaving) return;
            this.isSaving = true;
            this.notice = '';
            try {
                const { validateMemoFields, createMemoDraft } = await import(new URL('{{ asset('js/memo-fields.js') }}', window.location.href).href);
                this.errors = { ...validateMemoFields(this), audio: this.errors.audio };
                if (Object.values(this.errors).some(Boolean)) {
                    this.notice = 'Periksa isian yang ditandai sebelum menyimpan.';
                    return;
                }
                sessionStorage.setItem('nome_memo_draft_v1', JSON.stringify(createMemoDraft(this)));
                this.notice = 'Draf tersimpan di tab ini. Audio belum diunggah dan belum ada pemrosesan AI.';
                if (preview) window.location.href = '{{ route('preview', ['draft' => 1]) }}';
            } catch {
                this.notice = 'Draf gagal disimpan. Penyimpanan tab mungkin penuh atau diblokir.';
            } finally {
                this.isSaving = false;
            }
        },
        async submitMemo() {
            if (this.isSaving) return;
            this.isSaving = true;
            this.notice = '';
            try {
                const { validateMemoFields, createMemoPayload } = await import(new URL('{{ asset('js/memo-fields.js') }}', window.location.href).href);
                this.errors = { ...validateMemoFields(this), audio: this.errors.audio };
                if (Object.values(this.errors).some(Boolean)) {
                    this.notice = 'Periksa isian yang ditandai.';
                    return;
                }
                const api = await window.nomeApiReady;
                if (!this.serverMemoId) {
                    const record = await api.request('memos', { method: 'POST', body: createMemoPayload(this) });
                    this.serverMemoId = record.id;
                } else {
                    const status = await api.request('memos/' + this.serverMemoId + '/status');
                    if (['pending', 'processing'].includes(status.status)) {
                        window.location.href = '/preview?memo=' + encodeURIComponent(this.serverMemoId);
                        return;
                    }
                    const payload = createMemoPayload(this);
                    await api.request('memos/' + this.serverMemoId, { method: 'PUT', body: { ...payload, letter: this.includeLetter ? payload.letter : null } });
                }
                if (this.uploadedFile) {
                    const body = new FormData();
                    body.append('audio', this.uploadedFile);
                    await api.request('memos/' + this.serverMemoId + '/upload-audio', { method: 'POST', body });
                }
                sessionStorage.removeItem('nome_memo_draft_v1');
                window.location.href = '/preview?memo=' + encodeURIComponent(this.serverMemoId);
            } catch (error) {
                this.notice = error.message + (this.serverMemoId ? ' Memo sudah tersimpan; lanjutkan melalui riwayat.' : '');
                for (const [field, messages] of Object.entries(error.errors ?? {})) this.errors[field] = messages[0];
            } finally { this.isSaving = false; }
        },
        destroy() {
            clearInterval(this.recordTimer);
        }
     }">

    <!-- STEP 1 (INITIAL VIEW): GIANT BORDERLESS INPUT FOR MEETING TITLE -->
    <div class="space-y-4 pt-4">
        <input type="text" 
               x-model="meetingTitle"
               required aria-label="Judul Rapat"
               placeholder="Judul Rapat..." 
               @keydown.enter.prevent="if (meetingTitle.trim().length > 0) { step = 2; }" 
               class="text-4xl sm:text-5xl font-bold w-full bg-transparent border-none outline-none focus:ring-0 placeholder-gray-300 text-black leading-tight tracking-tight caret-[#ff5347]">

        <!-- Small muted helper text -->
        <p x-show="step === 1" 
           x-transition.opacity.duration.300ms
           class="text-[15px] text-black/40 font-normal">
            Tekan Enter untuk mulai mengatur catatan rapat...
        </p>
        <button type="button" x-show="step === 1" @click="if (meetingTitle.trim()) { step = 2; } else { errors.title = 'Judul rapat wajib diisi.'; }" class="rounded-full bg-[#ff5347] px-6 py-2.5 text-sm font-semibold text-white">Lanjut</button>
        <p x-show="errors.title" x-text="errors.title" role="alert" class="text-sm text-red-700"></p>
        <p x-show="notice" x-text="notice" role="status" class="text-sm text-black/60"></p>
    </div>

    <!-- STEP 2 (REVEAL): PROGRESSIVE DISCLOSURE VIA SMOOTH TRANSITION -->
    <div x-show="step === 2" 
         x-transition.opacity.duration.500ms
         class="space-y-12"
         style="display: none;">

        <p class="text-sm text-black/60 leading-relaxed">Simpan memo ke akun Anda. Pilih audio untuk memulai pemrosesan, atau simpan tanpa audio sebagai draf.</p>

        <!-- 1. PROPERTIES / METADATA (Notion-style inline table fields) -->
        <div class="space-y-6 pt-2 border-t border-[#d9d9d9]/60">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Tanggal & Waktu -->
                <div class="space-y-2">
                    <label class="block text-[12px] font-bold text-black/45 uppercase tracking-wider">
                        Tanggal Pelaksanaan
                    </label>
                    <input type="date" required
                           x-model="meetingDate"
                           class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[15px] text-black font-medium transition-colors">
                    <p x-show="errors.meeting_date" x-text="errors.meeting_date" role="alert" class="text-sm text-red-700"></p>
                </div>

                <div class="space-y-2">
                    <label class="block text-[12px] font-bold text-black/45 uppercase tracking-wider">
                        Waktu Mulai & Selesai (WITA)
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="time" 
                               x-model="meetingTimeStart"
                               aria-label="Waktu mulai (WITA)"
                               class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[15px] text-black font-medium transition-colors">
                        <input type="time" 
                               x-model="meetingTimeEnd"
                               aria-label="Waktu selesai (WITA)"
                               class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[15px] text-black font-medium transition-colors">
                    </div>
                    <p class="text-xs text-black/50">Waktu rapat menggunakan WITA. Untuk rapat melewati tengah malam, waktu selesai dapat lebih awal dari waktu mulai.</p>
                    <p x-show="errors.meeting_time || errors.meeting_end_time" x-text="errors.meeting_time || errors.meeting_end_time" role="alert" class="text-sm text-red-700"></p>
                </div>

                <!-- Ruang / Lokasi -->
                <div class="space-y-2">
                    <label class="block text-[12px] font-bold text-black/45 uppercase tracking-wider">
                        Lokasi / Tautan Sesi
                    </label>
                    <input type="text" 
                           x-model="meetingLocation"
                           placeholder="Ruang diskusi, studio, atau tautan Google Meet / Zoom..."
                           class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[15px] text-black font-medium transition-colors">
                </div>

                <!-- Pemandu & Pencatat -->
                <div class="space-y-2">
                    <label class="block text-[12px] font-bold text-black/45 uppercase tracking-wider">
                        Pemandu & Pencatat Diskusi
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" 
                               x-model="meetingLeader"
                               placeholder="Pemandu / Fasilitator"
                               class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[15px] text-black font-medium transition-colors">
                        <input type="text" 
                               x-model="meetingNotetaker"
                               placeholder="Pencatat / Notulis"
                               class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[15px] text-black font-medium transition-colors">
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. AGENDA PEMBAHASAN -->
        <div class="space-y-3">
            <label class="block text-[12px] font-bold text-black/45 uppercase tracking-wider">
                Agenda & Topik Bahasan
            </label>
            <textarea rows="3" 
                      x-model="agenda"
                      placeholder="Tuliskan pokok agenda, topik bahasan, atau tujuan sesi brainstorming di sini..."
                      class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2 text-[16px] text-black leading-relaxed placeholder-black/30 transition-colors resize-none"></textarea>
            <p class="text-xs text-black/50">Agenda disimpan bersama memo dan disertakan dalam ekspor.</p>
        </div>



        <!-- 3. ATTENDEES (DAFTAR PESERTA) -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <label class="block text-[12px] font-bold text-black/45 uppercase tracking-wider">
                    Daftar Peserta Hadir (<span x-text="attendees.length"></span>)
                </label>
            </div>

            <!-- Minimal Quick-Add Row -->
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <input type="text" 
                       x-model="newAttendeeName"
                       @keydown.enter.prevent="addAttendee()"
                       placeholder="Nama Peserta..."
                       class="flex-1 w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2 text-[14px] text-black font-medium placeholder-black/30 transition-colors">
                <input type="text" 
                       x-model="newAttendeeRole"
                       @keydown.enter.prevent="addAttendee()"
                       placeholder="Instansi / Jabatan (Opsional)..."
                       class="w-full sm:w-56 border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2 text-[14px] text-black font-medium placeholder-black/30 transition-colors">
                <button type="button" 
                        @click="addAttendee()"
                        class="px-5 py-2 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black hover:bg-black hover:text-white transition-colors shrink-0 self-end sm:self-auto">
                    + Tambah
                </button>
            </div>

            <!-- Clean Tag Pills of Attendees (Borderless soft gray, no bullets) -->
            <div class="flex flex-wrap gap-2 pt-2">
                <template x-for="(att, idx) in attendees" :key="idx">
                    <div class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg border-none bg-gray-100/80 text-sm text-gray-800">
                        <span class="font-medium" x-text="att.name"></span>
                        <span class="text-gray-500" x-text="att.agency_or_position"></span>
                        <button type="button" 
                                @click="removeAttendee(idx)"
                                class="text-gray-400 hover:text-black transition-colors ml-1 leading-none"
                                title="Hapus">
                            &times;
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- 4. AUDIO FILE UPLOAD / RECORD BUTTON -->
        <div class="space-y-4 pt-4 border-t border-[#d9d9d9]/60" x-init="audioMode = 'upload'">
            <div class="flex items-center justify-between">
                <label class="block text-[12px] font-bold text-black/45 uppercase tracking-wider">
                    Audio Sesi & Rekaman Suara
                </label>
                <!-- Simple Mode Toggle -->
                <div class="flex items-center space-x-3 text-[13px]">
                    <button type="button" 
                            disabled title="Perekaman langsung belum tersedia"
                            :class="audioMode === 'record' ? 'font-bold text-black underline underline-offset-4' : 'text-black/50 hover:text-black'"
                            class="transition-colors">
                        Rekam Langsung (Segera)
                    </button>
                    <span class="text-black/30">|</span>
                    <button type="button" 
                            @click="audioMode = 'upload'"
                            :class="audioMode === 'upload' ? 'font-bold text-black underline underline-offset-4' : 'text-black/50 hover:text-black'"
                            class="transition-colors">
                        Unggah Berkas
                    </button>
                </div>
            </div>

            <!-- Mode 1: Live Record -->
            <div x-show="audioMode === 'record'" class="py-6 space-y-4">
                <div class="flex items-center space-x-5">
                    <!-- Live Recording Indicator Placeholder (Simple colored div) -->
                    <div class="w-12 h-12 rounded-full border border-[#d9d9d9] flex items-center justify-center shrink-0"
                         :class="isRecording ? 'bg-[#ff5347]/10 border-[#ff5347]' : 'bg-gray-100'">
                        <div class="w-3.5 h-3.5 rounded-full"
                             :class="isRecording ? 'bg-[#ff5347] animate-pulse' : 'bg-gray-400'"></div>
                    </div>

                    <div>
                        <div class="font-mono text-[28px] font-bold text-black tracking-tight" x-text="formatTime(recordTime)"></div>
                        <p class="text-[13px] text-black/50" x-text="isRecording ? 'Sedang merekam suara percakapan...' : 'Klik tombol di samping untuk mulai merekam.'"></p>
                    </div>

                    <div class="pl-4">
                        <button type="button" 
                                @click="toggleRecording()"
                                :class="isRecording ? 'bg-black text-white hover:bg-black/85' : 'bg-[#ff5347] text-white hover:bg-[#e0453a]'"
                                class="px-6 py-2.5 rounded-full text-[13px] font-semibold transition-all">
                            <span x-text="isRecording ? 'Selesai Rekaman' : 'Mulai Rekam'"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mode 2: Upload File -->
            <div x-show="audioMode === 'upload'" class="py-4 space-y-3" style="display: none;">
                <div class="border border-dashed border-[#d9d9d9] hover:border-black/50 transition-colors rounded-2xl p-8 text-center space-y-3 relative">
                    <input type="file" 
                           @change="handleFileUpload($event)"
                           accept=".mp3,.wav,.m4a,.ogg"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                    <!-- Upload audio illustration -->
                    <div class="w-12 h-12 mx-auto flex items-center justify-center">
                        <img src="/images/soundwave_blob.svg" alt="Unggah Audio" class="w-full h-full object-contain">
                    </div>

                    <div class="space-y-1">
                        <p class="text-[14px] font-medium text-black">Klik atau seret berkas audio ke sini</p>
                        <p class="text-[12px] text-black/45">Mendukung MP3, WAV, M4A, OGG (Maksimal 100 MB)</p>
                    </div>
                </div>

                <!-- Uploaded file display -->
                <div x-show="uploadedFileName" class="flex items-center justify-between text-[13px] border-b border-[#d9d9d9] py-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-black/60"></div>
                        <span class="font-medium text-black" x-text="uploadedFileName"></span>
                        <span class="text-black/40" x-text="'(' + uploadedFileSize + ')'"></span>
                    </div>
                    <span class="text-gray-600 font-medium">Siap diproses</span>
                </div>
            </div>
            <p x-show="errors.audio" x-text="errors.audio" role="alert" class="text-sm text-red-700"></p>
        </div>

        <!-- 5. GENERATIVE CTA ACTION BAR -->
        <div class="pt-8 border-t border-[#d9d9d9]/60 flex flex-wrap items-center justify-between gap-4">
            <button type="button" 
                    @click="step = 1"
                    class="text-[14px] font-medium text-black/55 hover:text-black transition-colors">
                &larr; Ubah Judul
            </button>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/70 hover:bg-black hover:text-white transition-all">
                    Batal
                </a>
                <button type="button" @click="saveDraft()" :disabled="isSaving" class="px-5 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium disabled:opacity-50">Simpan Draf di Tab Ini</button>
                <button type="button" 
                        @click="submitMemo()"
                        :disabled="isSaving"
                        class="px-7 py-3 rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white text-[14px] font-bold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95 inline-flex items-center space-x-2">
                    <span x-text="isSaving ? 'Menyimpan...' : (uploadedFile ? 'Simpan & Proses Audio' : 'Simpan Memo')"></span>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
