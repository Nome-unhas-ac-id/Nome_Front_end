@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-16 pb-24" 
     x-data="{
        activeSection: 'rapat',
        meetingInfo: {
            name: 'Rapat Pleno Koordinasi Pengembangan Sistem Akademik Unhas',
            date: '2026-10-07',
            timeStart: '09:00',
            timeEnd: '12:00',
            location: 'Ruang Senat Rektorat Lt. 2 / Hybrid Zoom',
            leader: 'Dr. Eng. Ir. Arman, M.T.',
            notetaker: 'Andi Muhammad Abigail (Notulis Resmi)'
        },
        letterInfo: {
            letterNumber: '085/UN4.6.1/PL/2026',
            subject: 'Undangan Koordinasi Teknis Transkripsi & Notulensi Digital',
            destination: 'Seluruh Ketua Departemen & Kepala Laboratorium Fakultas Teknik',
            openingParagraph: 'Sehubungan dengan implementasi otomatisasi tata kelola administrasi akademik dan perumusan dokumen memo dinas terintegrasi berbasis AI, bersama ini kami mengundang Bapak/Ibu untuk hadir pada rapat koordinasi yang dilaksanakan pada:'
        },
        newAttendeeName: '',
        newAttendeeRole: '',
        attendees: [
            { name: 'Dr. Eng. Ir. Arman, M.T.', role: 'Wakil Dekan Bidang Akademik', initial: 'AR', bg: 'bg-[#EAF4FE] text-[#1E40AF]' },
            { name: 'Prof. Dr. Ir. Indrabayu, S.T., M.T.', role: 'Ketua Departemen Informatika', initial: 'IB', bg: 'bg-[#F0EEFF] text-[#5B21B6]' },
            { name: 'Dr. Amil Ahmad Ilham, S.T., M.IT.', role: 'Dosen Pembina Kurikulum', initial: 'AI', bg: 'bg-[#FEF6EC] text-[#9A3412]' },
            { name: 'Dr. Ing. Farida Patittingi, M.Hum.', role: 'Tim Penjaminan Mutu', initial: 'FP', bg: 'bg-[#EDF7EE] text-[#166534]' },
            { name: 'Andi Muhammad Abigail', role: 'Notulis Utama Sistem Nome', initial: 'AM', bg: 'bg-black text-white' }
        ],
        addAttendee() {
            if (this.newAttendeeName.trim()) {
                const colors = [
                    { bg: 'bg-[#EAF4FE] text-[#1E40AF]' },
                    { bg: 'bg-[#F0EEFF] text-[#5B21B6]' },
                    { bg: 'bg-[#FEF6EC] text-[#9A3412]' },
                    { bg: 'bg-[#EDF7EE] text-[#166534]' }
                ];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                const words = this.newAttendeeName.trim().split(' ');
                const initial = words.length > 1 ? (words[0][0] + words[1][0]).toUpperCase() : words[0].slice(0, 2).toUpperCase();

                this.attendees.push({
                    name: this.newAttendeeName.trim(),
                    role: this.newAttendeeRole.trim() || 'Anggota Rapat',
                    initial: initial,
                    bg: randomColor.bg
                });
                this.newAttendeeName = '';
                this.newAttendeeRole = '';
            }
        },
        removeAttendee(index) {
            this.attendees.splice(index, 1);
        },

        // Audio & MediaRecorder state
        audioTab: 'record',
        isRecording: false,
        isPaused: false,
        recordTime: 0,
        recordTimer: null,
        mediaRecorder: null,
        audioChunks: [],
        recordedAudioUrl: null,
        uploadedFileName: null,
        uploadedFileSize: null,
        isTranscribing: false,

        formatTime(seconds) {
            const h = Math.floor(seconds / 3600).toString().padStart(2, '0');
            const m = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
            const s = (seconds % 60).toString().padStart(2, '0');
            return `${h}:${m}:${s}`;
        },

        async startRecording() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                this.mediaRecorder = new MediaRecorder(stream);
                this.audioChunks = [];
                this.recordedAudioUrl = null;

                this.mediaRecorder.ondataavailable = (event) => {
                    if (event.data.size > 0) {
                        this.audioChunks.push(event.data);
                    }
                };

                this.mediaRecorder.onstop = () => {
                    const audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
                    this.recordedAudioUrl = URL.createObjectURL(audioBlob);
                    stream.getTracks().forEach(track => track.stop());
                };

                this.mediaRecorder.start();
                this.isRecording = true;
                this.isPaused = false;
                this.recordTime = 0;

                this.recordTimer = setInterval(() => {
                    if (!this.isPaused) {
                        this.recordTime++;
                    }
                }, 1000);
            } catch (err) {
                // Fallback / simulation mode
                this.isRecording = true;
                this.recordTime = 0;
                this.recordTimer = setInterval(() => {
                    if (!this.isPaused) {
                        this.recordTime++;
                    }
                }, 1000);
            }
        },

        pauseRecording() {
            if (this.mediaRecorder && this.mediaRecorder.state === 'recording') {
                this.mediaRecorder.pause();
            }
            this.isPaused = true;
        },

        resumeRecording() {
            if (this.mediaRecorder && this.mediaRecorder.state === 'paused') {
                this.mediaRecorder.resume();
            }
            this.isPaused = false;
        },

        stopRecording() {
            if (this.mediaRecorder && this.mediaRecorder.state !== 'inactive') {
                this.mediaRecorder.stop();
            }
            clearInterval(this.recordTimer);
            this.isRecording = false;
            this.isPaused = false;
            if (!this.recordedAudioUrl) {
                this.recordedAudioUrl = '#mock-audio';
            }
        },

        handleFileUpload(e) {
            const file = e.target.files[0];
            if (file) {
                this.uploadedFileName = file.name;
                this.uploadedFileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            }
        },

        submitAndProceed() {
            this.isTranscribing = true;
            setTimeout(() => {
                window.location.href = '{{ url('/preview') }}';
            }, 1200);
        }
     }">

    <!-- 1. MACRO EDITORIAL HEADER -->
    <div class="space-y-4 pt-4 border-b border-[#d9d9d9]/60 pb-10">
        <div class="inline-flex items-center space-x-2.5 px-4 py-1.5 rounded-full bg-white border border-[#d9d9d9]/80 text-[12px] font-medium text-black/60">
            <a href="{{ url('/dashboard') }}" class="hover:text-black transition-colors">Workspace</a>
            <span>&bull;</span>
            <span class="text-black font-semibold">Formulir Alir Bebas</span>
        </div>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-[44px] sm:text-[56px] lg:text-[68px] font-black tracking-tighter text-black leading-[1.05]">
                    Notulensi Baru.
                </h1>
                <p class="text-[17px] text-black/55 mt-2 max-w-2xl font-normal leading-relaxed">
                    Isian mengalir bebas di atas kanvas. Masukkan data agenda, surat dinas, daftar kehadiran, lalu biarkan sistem AI Nome memproses transkrip rekaman suara rapat.
                </p>
            </div>

            <div class="flex items-center space-x-2 shrink-0 self-start md:self-auto">
                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/70 hover:bg-black hover:text-white transition-colors">
                    Batal
                </a>
                <button type="button" 
                        @click="submitAndProceed()"
                        :disabled="isTranscribing"
                        class="px-6 py-2.5 rounded-full bg-black text-white text-[13px] font-semibold hover:bg-black/85 transition-transform active:scale-95 inline-flex items-center space-x-2">
                    <span x-text="isTranscribing ? 'Memproses AI...' : 'Proses Notulensi'"></span>
                    <svg x-show="!isTranscribing" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- 2. AIRY SECTION NAVIGATION BAR (Minimalist Soft Pills) -->
    <div class="sticky top-6 z-20 bg-[#F8F7F3]/90 backdrop-blur-md py-2 border-b border-[#d9d9d9]/40">
        <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar">
            <a href="#section-rapat" 
               @click="activeSection = 'rapat'"
               :class="activeSection === 'rapat' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
               class="px-5 py-2 rounded-full text-[13px] font-medium transition-colors shrink-0">
                01 &bull; Informasi Rapat
            </a>
            <a href="#section-surat" 
               @click="activeSection = 'surat'"
               :class="activeSection === 'surat' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
               class="px-5 py-2 rounded-full text-[13px] font-medium transition-colors shrink-0">
                02 &bull; Ketetapan Surat
            </a>
            <a href="#section-hadir" 
               @click="activeSection = 'hadir'"
               :class="activeSection === 'hadir' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
               class="px-5 py-2 rounded-full text-[13px] font-medium transition-colors shrink-0">
                03 &bull; Daftar Hadir (<span x-text="attendees.length"></span>)
            </a>
            <a href="#section-audio" 
               @click="activeSection = 'audio'"
               :class="activeSection === 'audio' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
               class="px-5 py-2 rounded-full text-[13px] font-medium transition-colors shrink-0">
                04 &bull; Rekaman Suara AI
            </a>
        </div>
    </div>

    <!-- 3. UNBOXED FLOWING SECTIONS -->

    <!-- SECTION 01: INFORMASI RAPAT -->
    <section id="section-rapat" class="space-y-8 scroll-mt-28">
        <div class="flex items-center space-x-3">
            <span class="w-8 h-8 rounded-full bg-black text-white text-[12px] font-bold flex items-center justify-center">01</span>
            <div>
                <h2 class="text-[26px] sm:text-[32px] font-black tracking-tight text-black">
                    Informasi Rapat & Agenda
                </h2>
                <p class="text-[14px] text-black/55">Agenda utama, jadwal dinas, dan penanggung jawab forum.</p>
            </div>
        </div>

        <div class="space-y-8 pt-2">
            <!-- Nama Rapat (Macro Input) -->
            <div class="space-y-2">
                <label class="block text-[18px] sm:text-[20px] font-bold tracking-tight text-black">
                    Nama Rapat atau Agenda Utama <span class="text-[#ff5347]">*</span>
                </label>
                <input type="text" 
                       x-model="meetingInfo.name"
                       placeholder="Masukkan judul agenda rapat..."
                       class="w-full bg-white border border-[#d9d9d9] rounded-2xl px-5 py-4 text-[17px] text-black font-medium placeholder-black/30 focus:outline-none focus:border-black transition-colors">
                <p class="text-[12px] text-black/45">Gunakan penamaan yang deskriptif untuk memudahkan pencarian di kemudian hari.</p>
            </div>

            <!-- Tanggal & Waktu (Spacious Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[15px] font-bold text-black">
                        Tanggal Pelaksanaan <span class="text-[#ff5347]">*</span>
                    </label>
                    <input type="date" 
                           x-model="meetingInfo.date"
                           class="w-full bg-white border border-[#d9d9d9] rounded-2xl px-5 py-3.5 text-[15px] text-black font-medium focus:outline-none focus:border-black transition-colors">
                </div>

                <div class="space-y-2">
                    <label class="block text-[15px] font-bold text-black">
                        Waktu Pertemuan (Mulai & Selesai) <span class="text-[#ff5347]">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="time" 
                               x-model="meetingInfo.timeStart"
                               class="w-full bg-white border border-[#d9d9d9] rounded-2xl px-4 py-3.5 text-[15px] text-black font-medium focus:outline-none focus:border-black transition-colors">
                        <input type="time" 
                               x-model="meetingInfo.timeEnd"
                               class="w-full bg-white border border-[#d9d9d9] rounded-2xl px-4 py-3.5 text-[15px] text-black font-medium focus:outline-none focus:border-black transition-colors">
                    </div>
                </div>
            </div>

            <!-- Tempat / Ruang Rapat -->
            <div class="space-y-2">
                <label class="block text-[15px] font-bold text-black">
                    Tempat, Ruang Rapat, atau Tautan Virtual <span class="text-[#ff5347]">*</span>
                </label>
                <input type="text" 
                       x-model="meetingInfo.location"
                       placeholder="Contoh: Ruang Senat Rektorat Lt. 2 / Hybrid Zoom Meeting"
                       class="w-full bg-white border border-[#d9d9d9] rounded-2xl px-5 py-4 text-[15px] text-black placeholder-black/30 focus:outline-none focus:border-black transition-colors">
            </div>

            <!-- Pimpinan & Notulis Rapat -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[15px] font-bold text-black">
                        Pimpinan Rapat <span class="text-[#ff5347]">*</span>
                    </label>
                    <input type="text" 
                           x-model="meetingInfo.leader"
                           placeholder="Nama Pimpinan & Gelar Lengkap"
                           class="w-full bg-white border border-[#d9d9d9] rounded-2xl px-5 py-3.5 text-[15px] text-black font-medium placeholder-black/30 focus:outline-none focus:border-black transition-colors">
                </div>

                <div class="space-y-2">
                    <label class="block text-[15px] font-bold text-black">
                        Notulis Resmi <span class="text-[#ff5347]">*</span>
                    </label>
                    <input type="text" 
                           x-model="meetingInfo.notetaker"
                           placeholder="Nama Pencatat Risalah"
                           class="w-full bg-white border border-[#d9d9d9] rounded-2xl px-5 py-3.5 text-[15px] text-black font-medium placeholder-black/30 focus:outline-none focus:border-black transition-colors">
                </div>
            </div>
        </div>
    </section>

    <!-- DELICATE SECTION SEPARATOR -->
    <div class="h-px bg-[#d9d9d9]/60"></div>

    <!-- SECTION 02: KETETAPAN SURAT & TATA NASKAH -->
    <section id="section-surat" class="space-y-8 scroll-mt-28">
        <div class="flex items-center space-x-3">
            <span class="w-8 h-8 rounded-full bg-black text-white text-[12px] font-bold flex items-center justify-center">02</span>
            <div>
                <h2 class="text-[26px] sm:text-[32px] font-black tracking-tight text-black">
                    Informasi Surat & Naskah Dinas
                </h2>
                <p class="text-[14px] text-black/55">Ketetapan administrasi, nomor persuratan resmi, dan dasar pelaksanaan.</p>
            </div>
        </div>

        <div class="space-y-8 pt-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[15px] font-bold text-black">
                        Nomor Surat Dinas <span class="text-[#ff5347]">*</span>
                    </label>
                    <input type="text" 
                           x-model="letterInfo.letterNumber"
                           placeholder="085/UN4.6.1/PL/2026"
                           class="w-full bg-white border border-[#d9d9d9] rounded-2xl px-5 py-3.5 text-[15px] font-mono text-black placeholder-black/30 focus:outline-none focus:border-black transition-colors">
                </div>

                <div class="space-y-2">
                    <label class="block text-[15px] font-bold text-black">
                        Perihal Surat <span class="text-[#ff5347]">*</span>
                    </label>
                    <input type="text" 
                           x-model="letterInfo.subject"
                           placeholder="Undangan Koordinasi Teknis"
                           class="w-full bg-white border border-[#d9d9d9] rounded-2xl px-5 py-3.5 text-[15px] text-black placeholder-black/30 focus:outline-none focus:border-black transition-colors">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[15px] font-bold text-black">
                    Tujuan / Sasaran Dokumen <span class="text-[#ff5347]">*</span>
                </label>
                <input type="text" 
                       x-model="letterInfo.destination"
                       placeholder="Seluruh Anggota Komisi Akademik"
                       class="w-full bg-white border border-[#d9d9d9] rounded-2xl px-5 py-4 text-[15px] text-black placeholder-black/30 focus:outline-none focus:border-black transition-colors">
            </div>

            <div class="space-y-2">
                <label class="block text-[15px] font-bold text-black">
                    Paragraf Pembuka / Konsiderans Rapat
                </label>
                <textarea rows="4" 
                          x-model="letterInfo.openingParagraph"
                          placeholder="Tuliskan narasi pembuka risalah dinas..."
                          class="w-full bg-white border border-[#d9d9d9] rounded-2xl p-5 text-[15px] text-black leading-relaxed placeholder-black/30 focus:outline-none focus:border-black transition-colors"></textarea>
                <p class="text-[12px] text-black/45">Teks ini akan dicantumkan pada mukadimah dokumen berita acara ekspor PDF.</p>
            </div>
        </div>
    </section>

    <!-- DELICATE SECTION SEPARATOR -->
    <div class="h-px bg-[#d9d9d9]/60"></div>

    <!-- SECTION 03: DAFTAR HADIR PESERTA -->
    <section id="section-hadir" class="space-y-8 scroll-mt-28">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <span class="w-8 h-8 rounded-full bg-black text-white text-[12px] font-bold flex items-center justify-center">03</span>
                <div>
                    <h2 class="text-[26px] sm:text-[32px] font-black tracking-tight text-black">
                        Daftar Kehadiran Peserta
                    </h2>
                    <p class="text-[14px] text-black/55">Peserta yang tercatat dalam risalah dan verifikasi kuorum rapat.</p>
                </div>
            </div>

            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white border border-[#d9d9d9] text-[13px] font-semibold text-black self-start sm:self-auto">
                <span x-text="attendees.length" class="text-[#ff5347] mr-1.5"></span> Peserta Terdaftar
            </div>
        </div>

        <div class="space-y-6 pt-2">
            <!-- Minimalist Quick-Add Input Row -->
            <div class="bg-white border border-[#d9d9d9]/70 rounded-3xl p-6 sm:p-8 space-y-4">
                <h3 class="text-[15px] font-bold text-black tracking-tight">Tambah Peserta Baru ke Daftar</h3>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                    <div class="sm:col-span-6">
                        <input type="text" 
                               x-model="newAttendeeName"
                               @keydown.enter.prevent="addAttendee()"
                               placeholder="Nama Lengkap & Gelar..."
                               class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-full px-4 py-2.5 text-[14px] text-black placeholder-black/40 focus:outline-none focus:border-black transition-colors">
                    </div>
                    <div class="sm:col-span-4">
                        <input type="text" 
                               x-model="newAttendeeRole"
                               @keydown.enter.prevent="addAttendee()"
                               placeholder="Jabatan / Peranan..."
                               class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-full px-4 py-2.5 text-[14px] text-black placeholder-black/40 focus:outline-none focus:border-black transition-colors">
                    </div>
                    <div class="sm:col-span-2">
                        <button type="button" 
                                @click="addAttendee()"
                                class="w-full bg-black text-white rounded-full py-2.5 text-[13px] font-semibold hover:bg-black/85 transition-colors">
                            + Tambah
                        </button>
                    </div>
                </div>
            </div>

            <!-- Airy Attendee Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <template x-for="(att, idx) in attendees" :key="idx">
                    <div class="bg-white border border-[#d9d9d9]/70 rounded-2xl p-4 flex items-center justify-between hover:border-black/30 transition-colors">
                        <div class="flex items-center space-x-3.5 min-w-0">
                            <span class="w-10 h-10 rounded-full font-bold text-[13px] flex items-center justify-center shrink-0"
                                  :class="att.bg" 
                                  x-text="att.initial"></span>
                            <div class="min-w-0">
                                <p class="text-[14px] font-bold text-black truncate" x-text="att.name"></p>
                                <p class="text-[12px] text-black/55 truncate" x-text="att.role"></p>
                            </div>
                        </div>

                        <button type="button" 
                                @click="removeAttendee(idx)"
                                class="p-2 text-black/30 hover:text-red-500 rounded-full hover:bg-black/5 transition-colors shrink-0"
                                title="Hapus dari daftar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- DELICATE SECTION SEPARATOR -->
    <div class="h-px bg-[#d9d9d9]/60"></div>

    <!-- SECTION 04: AUDIO RECORDING & AI UPLOAD -->
    <section id="section-audio" class="space-y-8 scroll-mt-28">
        <div class="flex items-center space-x-3">
            <span class="w-8 h-8 rounded-full bg-black text-white text-[12px] font-bold flex items-center justify-center">04</span>
            <div>
                <h2 class="text-[26px] sm:text-[32px] font-black tracking-tight text-black">
                    Audio & Pemrosesan AI
                </h2>
                <p class="text-[14px] text-black/55">Perekaman langsung via browser atau unggah berkas rekaman suara.</p>
            </div>
        </div>

        <div class="space-y-6 pt-2">
            <!-- Mode Switcher Pills -->
            <div class="flex items-center space-x-2">
                <button type="button" 
                        @click="audioTab = 'record'"
                        :class="audioTab === 'record' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-5 py-2 rounded-full text-[13px] font-medium transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    <span>Perekam Suara Langsung</span>
                </button>
                <button type="button" 
                        @click="audioTab = 'upload'"
                        :class="audioTab === 'upload' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-5 py-2 rounded-full text-[13px] font-medium transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <span>Unggah Berkas Audio</span>
                </button>
            </div>

            <!-- MODE 1: LIVE AUDIO RECORDER (Editorial Minimalist Studio) -->
            <div x-show="audioTab === 'record'" class="bg-white border border-[#d9d9d9]/70 rounded-3xl p-8 sm:p-12 text-center space-y-6">
                <!-- Large Digital Stopwatch -->
                <div class="space-y-1">
                    <span class="text-[12px] font-semibold tracking-wider text-black/40 uppercase">Durasi Perekaman</span>
                    <div class="font-mono text-[56px] sm:text-[68px] font-black text-black tracking-tighter" x-text="formatTime(recordTime)"></div>
                </div>

                <!-- Pulsing Waveform Simulation -->
                <div class="h-16 flex items-center justify-center space-x-1.5 py-2">
                    <template x-for="i in 32" :key="i">
                        <span class="w-1.5 rounded-full transition-all duration-150"
                              :class="isRecording && !isPaused ? 'bg-[#ff5347]' : 'bg-[#d9d9d9]'"
                              :style="isRecording && !isPaused ? `height: ${Math.max(8, Math.sin(i * 0.4 + recordTime) * 44 + 20)}px;` : 'height: 6px;'"></span>
                    </template>
                </div>

                <!-- Status Feedback Message -->
                <div class="text-[14px]">
                    <template x-if="!isRecording && recordTime === 0">
                        <span class="text-black/55">Mikrofon peramban siap digunakan. Klik "Mulai Rekam" saat sidang dibuka.</span>
                    </template>
                    <template x-if="isRecording && !isPaused">
                        <span class="text-[#ff5347] font-semibold flex items-center justify-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#ff5347] animate-ping"></span>
                            <span>Sedang merekam suara rapat secara real-time...</span>
                        </span>
                    </template>
                    <template x-if="isRecording && isPaused">
                        <span class="text-amber-600 font-semibold">Perekaman dijeda sementara.</span>
                    </template>
                    <template x-if="!isRecording && recordTime > 0">
                        <span class="text-emerald-700 font-semibold">Perekaman selesai! Siap ditranskripsikan oleh modul AI.</span>
                    </template>
                </div>

                <!-- Recorder Controls -->
                <div class="flex items-center justify-center space-x-3 pt-2">
                    <template x-if="!isRecording && recordTime === 0">
                        <button type="button" 
                                @click="startRecording()"
                                class="bg-[#ff5347] text-white rounded-full px-8 py-3.5 text-[15px] font-bold hover:bg-[#e0453a] transition-transform active:scale-95 flex items-center space-x-2.5">
                            <span class="w-3 h-3 rounded-full bg-white animate-pulse"></span>
                            <span>Mulai Rekam Suara Rapat</span>
                        </button>
                    </template>

                    <template x-if="isRecording">
                        <div class="flex items-center space-x-3">
                            <button type="button" 
                                    x-show="!isPaused" 
                                    @click="pauseRecording()"
                                    class="bg-white border border-[#d9d9d9] text-black font-medium text-[14px] rounded-full px-6 py-2.5 hover:bg-black/5 transition-colors">
                                Jeda
                            </button>
                            <button type="button" 
                                    x-show="isPaused" 
                                    @click="resumeRecording()"
                                    class="bg-white border border-[#d9d9d9] text-black font-semibold text-[14px] rounded-full px-6 py-2.5 hover:bg-black/5 transition-colors">
                                Lanjutkan
                            </button>
                            <button type="button" 
                                    @click="stopRecording()"
                                    class="bg-black text-white font-medium text-[14px] rounded-full px-6 py-2.5 hover:bg-black/85 transition-colors">
                                Selesai & Simpan Rekaman
                            </button>
                        </div>
                    </template>

                    <template x-if="!isRecording && recordTime > 0">
                        <button type="button" 
                                @click="startRecording()"
                                class="border border-[#d9d9d9] text-black/75 rounded-full px-5 py-2 text-[13px] font-medium hover:bg-black hover:text-white transition-colors">
                            Rekam Ulang
                        </button>
                    </template>
                </div>
            </div>

            <!-- MODE 2: AUDIO FILE UPLOAD (Line-Art Doodle Dropzone) -->
            <div x-show="audioTab === 'upload'" class="space-y-4">
                <div class="border-2 border-dashed border-[#d9d9d9] hover:border-black/50 transition-colors rounded-3xl p-10 sm:p-14 bg-white text-center space-y-4 relative">
                    <input type="file" 
                           @change="handleFileUpload($event)"
                           accept="audio/*" 
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                    <!-- Monochrome Doodle Line Art -->
                    <div class="w-24 h-24 mx-auto text-black/40">
                        <svg viewBox="0 0 100 100" fill="none" stroke="currentColor" class="w-full h-full">
                            <circle cx="50" cy="50" r="38" stroke-width="2" stroke-dasharray="3 3"/>
                            <rect x="35" y="30" width="30" height="40" rx="6" stroke-width="2"/>
                            <path d="M42 42h16M42 50h16M42 58h10" stroke-width="2" stroke-linecap="round"/>
                            <path d="M35 52 Q20 52 20 65 Q20 78 50 78 Q80 78 80 65 Q80 52 65 52" stroke-width="1.5" stroke-dasharray="2 2"/>
                        </svg>
                    </div>

                    <div class="space-y-1">
                        <h4 class="text-[18px] font-bold text-black">Tarik & Letakkan Berkas Audio di Sini</h4>
                        <p class="text-[14px] text-black/55">Mendukung MP3, WAV, M4A, AAC, atau FLAC (Hingga 500 MB)</p>
                    </div>

                    <button type="button" class="bg-black text-white rounded-full px-6 py-2.5 text-[13px] font-semibold hover:bg-black/85 transition-colors">
                        Pilih Berkas Audio dari Komputer
                    </button>
                </div>

                <!-- Uploaded File Badge -->
                <div x-show="uploadedFileName" class="bg-white border border-[#d9d9d9]/70 rounded-2xl p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-10 h-10 rounded-full bg-[#EAF4FE] text-[#1E40AF] font-bold text-[12px] flex items-center justify-center">
                            MP3
                        </div>
                        <div>
                            <p class="text-[14px] font-bold text-black" x-text="uploadedFileName"></p>
                            <p class="text-[12px] text-black/50" x-text="uploadedFileSize"></p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                        Berkas Siap Diproses
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. BOTTOM FLOATING ACTION BAR -->
    <div class="pt-8 border-t border-[#d9d9d9]/60 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-[13px] text-black/50">
            Pastikan seluruh data dan rekaman telah terverifikasi sebelum mengirim.
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ url('/dashboard') }}" class="px-6 py-3 rounded-full border border-[#d9d9d9] text-[14px] font-medium text-black/70 hover:bg-black hover:text-white transition-colors">
                Kembali ke Beranda
            </a>
            <button type="button" 
                    @click="submitAndProceed()"
                    :disabled="isTranscribing"
                    class="px-8 py-3.5 rounded-full bg-black text-white text-[15px] font-bold hover:bg-black/85 transition-transform active:scale-95 inline-flex items-center space-x-2.5">
                <template x-if="!isTranscribing">
                    <div class="flex items-center space-x-2">
                        <span>Mulai Transkripsi & Ekspor AI</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </template>
                <template x-if="isTranscribing">
                    <div class="flex items-center space-x-2">
                        <span class="w-4 h-4 rounded-full border-2 border-white border-t-transparent animate-spin"></span>
                        <span>Memproses Whisper & PyAnnote...</span>
                    </div>
                </template>
            </button>
        </div>
    </div>
</div>
@endsection
