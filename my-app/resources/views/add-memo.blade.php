@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-8" 
     x-data="{
        currentStep: 1,
        totalSteps: 4,
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
            { name: 'Dr. Eng. Ir. Arman, M.T.', role: 'Wakil Dekan Bidang Akademik', status: 'Hadir' },
            { name: 'Prof. Dr. Ir. Indrabayu, S.T., M.T.', role: 'Ketua Departemen Informatika', status: 'Hadir' },
            { name: 'Dr. Amil Ahmad Ilham, S.T., M.IT.', role: 'Dosen Pembina Kurikulum', status: 'Hadir' },
            { name: 'Dr. Ing. Farida Patittingi, M.Hum.', role: 'Tim Penjaminan Mutu', status: 'Hadir' },
            { name: 'Andi Muhammad Abigail', role: 'Notulis Utama Sistem Nome', status: 'Hadir' }
        ],
        addAttendee() {
            if (this.newAttendeeName.trim()) {
                this.attendees.push({
                    name: this.newAttendeeName.trim(),
                    role: this.newAttendeeRole.trim() || 'Anggota Rapat',
                    status: 'Hadir'
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
                alert('Izin mikrofon diperlukan untuk melakukan perekaman audio live. Mengaktifkan mode simulasi perekam.');
                this.isRecording = true;
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

    <!-- Page Title & Step Description -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 border-b border-[#d9d9d9]">
        <div>
            <div class="inline-flex items-center space-x-2 text-[12px] text-black/60 font-medium mb-2">
                <a href="{{ url('/dashboard') }}" class="hover:text-black">Dashboard</a>
                <span>/</span>
                <span class="text-black font-semibold">Buat Memo Rapat Baru</span>
            </div>
            <h1 class="text-[32px] md:text-[38px] font-bold tracking-tight text-black leading-tight">
                Formulir Notulensi & Rekaman Rapat
            </h1>
            <p class="text-[15px] text-black/60 mt-1">
                Lengkapi rincian rapat dinas, daftar hadir peserta, dan rekam atau unggah audio untuk diproses oleh AI.
            </p>
        </div>

        <div class="flex items-center space-x-2 text-[13px] text-black/70 bg-white border border-[#d9d9d9] px-3.5 py-1.5 rounded-[8px]">
            <span>Langkah:</span>
            <span class="font-bold text-[#ff5347]" x-text="currentStep"></span>
            <span>dari</span>
            <span class="font-bold text-black" x-text="totalSteps"></span>
        </div>
    </div>

    <!-- Stepper Navigation Tabs (Tactile Warm Paper Vibe) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 bg-[#F8F7F3] p-1 border border-[#d9d9d9] rounded-[12px]">
        <button @click="currentStep = 1" 
                class="flex items-center justify-center space-x-2.5 py-2.5 px-3 rounded-[8px] text-[13px] font-medium transition-all"
                :class="currentStep === 1 ? 'bg-white border border-[#d9d9d9] text-black font-semibold' : 'text-black/60 hover:text-black hover:bg-white/50'">
            <span class="w-5 h-5 rounded-full flex items-center justify-center text-[11px] font-bold"
                  :class="currentStep === 1 ? 'bg-[#ff5347] text-white' : 'bg-black/10 text-black/70'">1</span>
            <span class="truncate">Informasi Rapat</span>
        </button>

        <button @click="currentStep = 2" 
                class="flex items-center justify-center space-x-2.5 py-2.5 px-3 rounded-[8px] text-[13px] font-medium transition-all"
                :class="currentStep === 2 ? 'bg-white border border-[#d9d9d9] text-black font-semibold' : 'text-black/60 hover:text-black hover:bg-white/50'">
            <span class="w-5 h-5 rounded-full flex items-center justify-center text-[11px] font-bold"
                  :class="currentStep === 2 ? 'bg-[#ff5347] text-white' : 'bg-black/10 text-black/70'">2</span>
            <span class="truncate">Informasi Surat</span>
        </button>

        <button @click="currentStep = 3" 
                class="flex items-center justify-center space-x-2.5 py-2.5 px-3 rounded-[8px] text-[13px] font-medium transition-all"
                :class="currentStep === 3 ? 'bg-white border border-[#d9d9d9] text-black font-semibold' : 'text-black/60 hover:text-black hover:bg-white/50'">
            <span class="w-5 h-5 rounded-full flex items-center justify-center text-[11px] font-bold"
                  :class="currentStep === 3 ? 'bg-[#ff5347] text-white' : 'bg-black/10 text-black/70'">3</span>
            <span class="truncate">Daftar Hadir</span>
        </button>

        <button @click="currentStep = 4" 
                class="flex items-center justify-center space-x-2.5 py-2.5 px-3 rounded-[8px] text-[13px] font-medium transition-all"
                :class="currentStep === 4 ? 'bg-white border border-[#d9d9d9] text-black font-semibold' : 'text-black/60 hover:text-black hover:bg-white/50'">
            <span class="w-5 h-5 rounded-full flex items-center justify-center text-[11px] font-bold"
                  :class="currentStep === 4 ? 'bg-[#ff5347] text-white' : 'bg-black/10 text-black/70'">4</span>
            <span class="truncate">Audio & Rekaman</span>
        </button>
    </div>

    <!-- Step 1: Informasi Rapat -->
    <div x-show="currentStep === 1" 
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-6">
        <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 sm:p-8 space-y-6">
            <div class="border-b border-[#d9d9d9] pb-4">
                <h2 class="text-[22px] font-bold tracking-tight text-black mb-1">Informasi Rapat</h2>
                <p class="text-[13px] text-black/60">Tentukan nama agenda, jadwal pelaksanaan, lokasi, serta notulis resmi rapat.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Rapat -->
                <div class="md:col-span-2">
                    <label class="block text-[13px] font-semibold text-black mb-1.5">Nama Rapat / Agenda Utama <span class="text-[#ff5347]">*</span></label>
                    <input type="text" 
                           x-model="meetingInfo.name"
                           placeholder="Contoh: Rapat Koordinasi Kurikulum Semester Gasal"
                           class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-[13px] font-semibold text-black mb-1.5">Tanggal Pelaksanaan <span class="text-[#ff5347]">*</span></label>
                    <input type="date" 
                           x-model="meetingInfo.date"
                           class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
                </div>

                <!-- Waktu (Start - End) -->
                <div>
                    <label class="block text-[13px] font-semibold text-black mb-1.5">Waktu Rapat (Mulai - Selesai) <span class="text-[#ff5347]">*</span></label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="time" 
                               x-model="meetingInfo.timeStart"
                               class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
                        <input type="time" 
                               x-model="meetingInfo.timeEnd"
                               class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
                    </div>
                </div>

                <!-- Tempat / Lokasi -->
                <div class="md:col-span-2">
                    <label class="block text-[13px] font-semibold text-black mb-1.5">Tempat / Ruang Rapat / Tautan Virtual <span class="text-[#ff5347]">*</span></label>
                    <input type="text" 
                           x-model="meetingInfo.location"
                           placeholder="Contoh: Ruang Senat Fakultas Teknik Lt. 2 / Ruang Zoom ID: 948 2210 112"
                           class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
                </div>

                <!-- Pimpinan Rapat -->
                <div>
                    <label class="block text-[13px] font-semibold text-black mb-1.5">Pimpinan Rapat / Penanggung Jawab <span class="text-[#ff5347]">*</span></label>
                    <input type="text" 
                           x-model="meetingInfo.leader"
                           placeholder="Nama Pimpinan & Gelar"
                           class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
                </div>

                <!-- Notulis Rapat -->
                <div>
                    <label class="block text-[13px] font-semibold text-black mb-1.5">Notulis / Pencatat Risalah <span class="text-[#ff5347]">*</span></label>
                    <input type="text" 
                           x-model="meetingInfo.notetaker"
                           placeholder="Nama Notulis Rapat"
                           class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
                </div>
            </div>

            <!-- Card Action Footer -->
            <div class="flex items-center justify-between pt-6 border-t border-[#d9d9d9]">
                <a href="{{ url('/dashboard') }}" class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[14px] rounded-[4px] px-4 py-2 hover:bg-black/5 transition-colors">
                    Batal
                </a>
                <button @click="currentStep = 2" class="bg-[#ff5347] text-white font-medium text-[14px] rounded-[8px] px-5 py-2 hover:bg-[#e0453a] transition-colors flex items-center space-x-1.5">
                    <span>Lanjut: Informasi Surat</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Step 2: Informasi Surat -->
    <div x-show="currentStep === 2" 
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-6">
        <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 sm:p-8 space-y-6">
            <div class="border-b border-[#d9d9d9] pb-4">
                <h2 class="text-[22px] font-bold tracking-tight text-black mb-1">Informasi Surat & Ketetapan Dinas</h2>
                <p class="text-[13px] text-black/60">Lengkapi nomor tata naskah dinas, perihal, sasaran tujuan surat, dan dasar pertimbangan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nomor Surat -->
                <div>
                    <label class="block text-[13px] font-semibold text-black mb-1.5">Nomor Surat / Tata Naskah Dinas <span class="text-[#ff5347]">*</span></label>
                    <input type="text" 
                           x-model="letterInfo.letterNumber"
                           placeholder="Contoh: 085/UN4.6.1/PL/2026"
                           class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] font-mono text-black focus:outline-none focus:border-[#ff5347] transition-colors">
                </div>

                <!-- Perihal -->
                <div>
                    <label class="block text-[13px] font-semibold text-black mb-1.5">Perihal / Hal <span class="text-[#ff5347]">*</span></label>
                    <input type="text" 
                           x-model="letterInfo.subject"
                           placeholder="Contoh: Notulensi Rapat Koordinasi Kurikulum"
                           class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
                </div>

                <!-- Tujuan / Sasaran -->
                <div class="md:col-span-2">
                    <label class="block text-[13px] font-semibold text-black mb-1.5">Tujuan / Ditujukan Kepada <span class="text-[#ff5347]">*</span></label>
                    <input type="text" 
                           x-model="letterInfo.destination"
                           placeholder="Contoh: Para Dosen & Staf Akademik Departemen Informatika"
                           class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
                </div>

                <!-- Paragraf Pembuka -->
                <div class="md:col-span-2">
                    <label class="block text-[13px] font-semibold text-black mb-1.5">Paragraf Pembuka / Dasar Pelaksanaan</label>
                    <textarea rows="4" 
                              x-model="letterInfo.openingParagraph"
                              placeholder="Masukkan narasi pembuka dokumen resmi notulensi..."
                              class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black leading-relaxed focus:outline-none focus:border-[#ff5347] transition-colors"></textarea>
                </div>
            </div>

            <!-- Card Action Footer -->
            <div class="flex items-center justify-between pt-6 border-t border-[#d9d9d9]">
                <button @click="currentStep = 1" class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[14px] rounded-[4px] px-4 py-2 hover:bg-black/5 transition-colors">
                    Kembali: Info Rapat
                </button>
                <button @click="currentStep = 3" class="bg-[#ff5347] text-white font-medium text-[14px] rounded-[8px] px-5 py-2 hover:bg-[#e0453a] transition-colors flex items-center space-x-1.5">
                    <span>Lanjut: Daftar Hadir</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Step 3: Daftar Hadir -->
    <div x-show="currentStep === 3" 
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-6">
        <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#d9d9d9] pb-4">
                <div>
                    <h2 class="text-[22px] font-bold tracking-tight text-black mb-1">Daftar Hadir Peserta Rapat</h2>
                    <p class="text-[13px] text-black/60">Daftar nama dan peranan peserta yang hadir dalam forum pertemuan.</p>
                </div>
                <div class="px-3 py-1 rounded-full bg-[#F8F7F3] border border-[#d9d9d9] text-[12px] font-semibold text-black/70 self-start sm:self-auto">
                    Total: <span x-text="attendees.length" class="text-[#ff5347]"></span> Peserta
                </div>
            </div>

            <!-- Input Penambahan Peserta Baru -->
            <div class="bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] p-4 space-y-3">
                <span class="text-[12px] font-bold uppercase tracking-wider text-black/70">Tambah Peserta Baru</span>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                    <div class="sm:col-span-6">
                        <input type="text" 
                               x-model="newAttendeeName"
                               @keydown.enter.prevent="addAttendee()"
                               placeholder="Nama Lengkap & Gelar Peserta..."
                               class="w-full bg-white border border-[#d9d9d9] rounded-[8px] px-3.5 py-2 text-[14px] text-black focus:outline-none focus:border-[#ff5347]">
                    </div>
                    <div class="sm:col-span-4">
                        <input type="text" 
                               x-model="newAttendeeRole"
                               @keydown.enter.prevent="addAttendee()"
                               placeholder="Jabatan / Instansi (Opsional)"
                               class="w-full bg-white border border-[#d9d9d9] rounded-[8px] px-3.5 py-2 text-[14px] text-black focus:outline-none focus:border-[#ff5347]">
                    </div>
                    <div class="sm:col-span-2">
                        <button type="button" 
                                @click="addAttendee()"
                                class="w-full bg-black text-white font-medium text-[13px] rounded-[8px] py-2 hover:bg-black/80 transition-colors">
                            + Tambah
                        </button>
                    </div>
                </div>
            </div>

            <!-- Attendees Table -->
            <div class="border border-[#d9d9d9] rounded-[8px] overflow-hidden">
                <table class="w-full text-left text-[14px]">
                    <thead class="bg-[#F8F7F3] border-b border-[#d9d9d9] text-[12px] uppercase tracking-wider text-black/60 font-semibold">
                        <tr>
                            <th class="px-4 py-3 w-12 text-center">No</th>
                            <th class="px-4 py-3">Nama Lengkap</th>
                            <th class="px-4 py-3">Peranan / Jabatan</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#d9d9d9] bg-white">
                        <template x-for="(att, idx) in attendees" :key="idx">
                            <tr class="hover:bg-[#F8F7F3]/40 transition-colors">
                                <td class="px-4 py-3 text-center text-[12px] text-black/50" x-text="idx + 1"></td>
                                <td class="px-4 py-3 font-semibold text-black" x-text="att.name"></td>
                                <td class="px-4 py-3 text-[13px] text-black/70" x-text="att.role"></td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Hadir
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button type="button" 
                                            @click="removeAttendee(idx)"
                                            class="text-red-500 hover:text-red-700 text-[12px] font-medium p-1"
                                            title="Hapus Peserta">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Card Action Footer -->
            <div class="flex items-center justify-between pt-6 border-t border-[#d9d9d9]">
                <button @click="currentStep = 2" class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[14px] rounded-[4px] px-4 py-2 hover:bg-black/5 transition-colors">
                    Kembali: Info Surat
                </button>
                <button @click="currentStep = 4" class="bg-[#ff5347] text-white font-medium text-[14px] rounded-[8px] px-5 py-2 hover:bg-[#e0453a] transition-colors flex items-center space-x-1.5">
                    <span>Lanjut: Rekam / Unggah Suara</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Step 4: Audio Input & MediaRecorder -->
    <div x-show="currentStep === 4" 
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-6">
        <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 sm:p-8 space-y-6">
            <div class="border-b border-[#d9d9d9] pb-4">
                <h2 class="text-[22px] font-bold tracking-tight text-black mb-1">Masukan Audio Rapat</h2>
                <p class="text-[13px] text-black/60">Gunakan perekam audio langsung via browser atau unggah berkas rekaman suara (.mp3, .wav, .m4a).</p>
            </div>

            <!-- Tab Switcher: Live Record vs Upload -->
            <div class="flex space-x-2 border-b border-[#d9d9d9] pb-3">
                <button type="button" 
                        @click="audioTab = 'record'"
                        :class="audioTab === 'record' ? 'bg-[#ff5347] text-white font-semibold' : 'bg-white border border-[#d9d9d9] text-black/70 hover:text-black'"
                        class="px-4 py-2 rounded-[8px] text-[13px] font-medium transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    <span>Perekam Langsung (MediaRecorder)</span>
                </button>
                <button type="button" 
                        @click="audioTab = 'upload'"
                        :class="audioTab === 'upload' ? 'bg-[#ff5347] text-white font-semibold' : 'bg-white border border-[#d9d9d9] text-black/70 hover:text-black'"
                        class="px-4 py-2 rounded-[8px] text-[13px] font-medium transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <span>Unggah Berkas Audio</span>
                </button>
            </div>

            <!-- Mode 1: Live Audio Recording (Browser MediaRecorder) -->
            <div x-show="audioTab === 'record'" class="space-y-6">
                <div class="border border-[#d9d9d9] rounded-[12px] p-6 bg-[#F8F7F3] text-center space-y-4">
                    <!-- Recording Timer Display -->
                    <div class="space-y-1">
                        <span class="text-[12px] font-semibold uppercase tracking-wider text-black/50">Durasi Rekaman Rapat</span>
                        <div class="font-mono text-[42px] font-bold text-black tracking-tight" x-text="formatTime(recordTime)"></div>
                    </div>

                    <!-- Live Pulsing Waveform Simulation -->
                    <div class="h-14 flex items-center justify-center space-x-1.5 py-2">
                        <template x-for="i in 24" :key="i">
                            <span class="w-1.5 rounded-full transition-all duration-150"
                                  :class="isRecording && !isPaused ? 'bg-[#ff5347]' : 'bg-[#d9d9d9]'"
                                  :style="isRecording && !isPaused ? `height: ${Math.max(10, Math.sin(i + recordTime) * 36 + 20)}px;` : 'height: 8px;'"></span>
                        </template>
                    </div>

                    <!-- Status Text -->
                    <div class="text-[13px] font-medium">
                        <template x-if="!isRecording && recordTime === 0">
                            <span class="text-black/60">Mikrofon siap. Klik tombol "Mulai Perekaman" di bawah saat rapat dibuka.</span>
                        </template>
                        <template x-if="isRecording && !isPaused">
                            <span class="text-[#ff5347] flex items-center justify-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#ff5347] animate-ping"></span>
                                <span>Sedang Merekam Suara Rapat Secara Real-Time...</span>
                            </span>
                        </template>
                        <template x-if="isRecording && isPaused">
                            <span class="text-amber-600 font-semibold">Perekaman Dijeda Sementara.</span>
                        </template>
                        <template x-if="!isRecording && recordTime > 0">
                            <span class="text-emerald-600 font-semibold">Perekaman Selesai! Berkas suara siap dikonversi ke transkrip AI.</span>
                        </template>
                    </div>

                    <!-- Recording Control Buttons -->
                    <div class="flex items-center justify-center space-x-3 pt-2">
                        <!-- Start Button -->
                        <template x-if="!isRecording && recordTime === 0">
                            <button type="button" 
                                    @click="startRecording()"
                                    class="bg-[#ff5347] text-white font-medium text-[14px] rounded-[8px] px-6 py-2.5 hover:bg-[#e0453a] transition-colors flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-white animate-pulse"></span>
                                <span>Mulai Perekaman Suara</span>
                            </button>
                        </template>

                        <!-- In-recording Controls -->
                        <template x-if="isRecording">
                            <div class="flex items-center space-x-3">
                                <button type="button" 
                                        x-show="!isPaused" 
                                        @click="pauseRecording()"
                                        class="bg-white border border-[#d9d9d9] text-black/90 font-medium text-[14px] rounded-[8px] px-4 py-2 hover:bg-black/5 transition-colors">
                                    Jeda
                                </button>
                                <button type="button" 
                                        x-show="isPaused" 
                                        @click="resumeRecording()"
                                        class="bg-white border border-[#d9d9d9] text-black font-semibold text-[14px] rounded-[8px] px-4 py-2 hover:bg-black/5 transition-colors">
                                    Lanjutkan
                                </button>
                                <button type="button" 
                                        @click="stopRecording()"
                                        class="bg-black text-white font-medium text-[14px] rounded-[8px] px-5 py-2 hover:bg-black/80 transition-colors">
                                    Hentikan & Simpan Audio
                                </button>
                            </div>
                        </template>

                        <!-- Restart Button if completed -->
                        <template x-if="!isRecording && recordTime > 0">
                            <button type="button" 
                                    @click="startRecording()"
                                    class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[13px] rounded-[6px] px-4 py-2 hover:bg-black/5 transition-colors">
                                Rekam Ulang
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Mode 2: Audio File Upload UI -->
            <div x-show="audioTab === 'upload'" class="space-y-4">
                <div class="border-2 border-dashed border-[#d9d9d9] rounded-[12px] p-8 bg-[#F8F7F3] text-center space-y-3 relative">
                    <input type="file" 
                           @change="handleFileUpload($event)"
                           accept="audio/*" 
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    
                    <div class="w-12 h-12 rounded-full bg-white border border-[#d9d9d9] mx-auto flex items-center justify-center text-black/60">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>

                    <div class="space-y-1">
                        <p class="text-[15px] font-bold text-black">Tarik & Letakkan Berkas Audio di Sini</p>
                        <p class="text-[13px] text-black/60">Mendukung format WAV, MP3, M4A, AAC, atau FLAC (Maks. 500 MB)</p>
                    </div>

                    <button type="button" class="bg-white border border-[#d9d9d9] text-black/90 font-medium text-[13px] rounded-[8px] px-4 py-1.5 hover:bg-black/5 transition-colors">
                        Pilih Berkas dari Komputer
                    </button>
                </div>

                <!-- Uploaded file display -->
                <div x-show="uploadedFileName" class="bg-white border border-[#d9d9d9] rounded-[8px] p-3.5 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="w-8 h-8 rounded-[6px] bg-[#ff5347]/10 text-[#ff5347] font-bold text-[12px] flex items-center justify-center">AUDIO</span>
                        <div>
                            <p class="text-[13px] font-semibold text-black" x-text="uploadedFileName"></p>
                            <p class="text-[11px] text-black/50" x-text="uploadedFileSize"></p>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Siap Diunggah
                    </span>
                </div>
            </div>

            <!-- Card Action Footer: Submit & Process AI -->
            <div class="flex items-center justify-between pt-6 border-t border-[#d9d9d9]">
                <button @click="currentStep = 3" class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[14px] rounded-[4px] px-4 py-2 hover:bg-black/5 transition-colors">
                    Kembali: Daftar Hadir
                </button>
                
                <button @click="submitAndProceed()" 
                        :disabled="isTranscribing"
                        class="bg-[#ff5347] text-white font-medium text-[14px] rounded-[8px] px-6 py-2.5 hover:bg-[#e0453a] transition-colors flex items-center space-x-2">
                    <template x-if="!isTranscribing">
                        <div class="flex items-center space-x-2">
                            <span>Kirim & Transkripsikan AI</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </template>
                    <template x-if="isTranscribing">
                        <div class="flex items-center space-x-2">
                            <span class="w-3.5 h-3.5 rounded-full border-2 border-white border-t-transparent animate-spin"></span>
                            <span>Memproses Whisper & PyAnnote...</span>
                        </div>
                    </template>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
