@extends('layouts.app')

@section('main_class', 'flex-1 w-full px-6 sm:px-10 lg:px-14 pt-28')

@section('content')
<div class="max-w-4xl mx-auto"
     :class="step === 1 ? 'h-[calc(100vh-7rem)] flex flex-col justify-center pb-24 overflow-hidden' : 'space-y-10 py-10 sm:py-14 min-h-screen overflow-visible'" 
     x-data="{
        step: 1,
        meetingTitle: '',
        meetingDate: '2026-10-07',
        meetingTimeStart: '09:00',
        meetingTimeEnd: '11:00',
        meetingLocation: '',
        meetingLeader: '',
        meetingNotetaker: '',
        agenda: '',
        attendees: [
            { name: 'Peserta 1', role: 'Fasilitator' },
            { name: 'Peserta 2', role: 'Pencatat' }
        ],
        newAttendeeName: '',
        newAttendeeRole: '',
        addAttendee() {
            if (this.newAttendeeName.trim()) {
                this.attendees.push({
                    name: this.newAttendeeName.trim(),
                    role: this.newAttendeeRole.trim() || 'Peserta'
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
        handleFileUpload(e) {
            const file = e.target.files[0];
            if (file) {
                this.uploadedFileName = file.name;
                this.uploadedFileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            }
        },

        isTranscribing: false,
        submitMemo() {
            this.isTranscribing = true;
            setTimeout(() => {
                window.location.href = '{{ url('/preview') }}';
            }, 1000);
        }
     }">

    <!-- STEP 1 (INITIAL VIEW): GIANT BORDERLESS INPUT FOR MEETING TITLE -->
    <div class="space-y-4 pt-4">
        <input type="text" 
               x-model="meetingTitle"
               placeholder="Judul Rapat..." 
               @keydown.enter.prevent="if (meetingTitle.trim().length > 0) { step = 2; }" 
               class="text-4xl sm:text-5xl font-bold w-full bg-transparent border-none outline-none focus:ring-0 placeholder-gray-300 text-black leading-tight tracking-tight caret-[#ff5347]">

        <!-- Small muted helper text -->
        <p x-show="step === 1" 
           x-transition.opacity.duration.300ms
           class="text-[15px] text-black/40 font-normal">
            Tekan Enter untuk mulai mengatur agenda rapat...
        </p>
    </div>

    <!-- STEP 2 (REVEAL): PROGRESSIVE DISCLOSURE VIA SMOOTH TRANSITION -->
    <div x-show="step === 2" 
         x-transition.opacity.duration.500ms
         class="space-y-12"
         style="display: none;">

        <!-- 1. PROPERTIES / METADATA (Notion-style inline table fields) -->
        <div class="space-y-6 pt-2 border-t border-[#d9d9d9]/60">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Tanggal & Waktu -->
                <div class="space-y-2">
                    <label class="block text-[12px] font-bold text-black/45 uppercase tracking-wider">
                        Tanggal Pelaksanaan
                    </label>
                    <input type="date" 
                           x-model="meetingDate"
                           class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[15px] text-black font-medium transition-colors">
                </div>

                <div class="space-y-2">
                    <label class="block text-[12px] font-bold text-black/45 uppercase tracking-wider">
                        Waktu (Mulai & Selesai)
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="time" 
                               x-model="meetingTimeStart"
                               class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[15px] text-black font-medium transition-colors">
                        <input type="time" 
                               x-model="meetingTimeEnd"
                               class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[15px] text-black font-medium transition-colors">
                    </div>
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
                       placeholder="Peran Anda (Opsional)..."
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
                        <span class="text-gray-500" x-text="att.role"></span>
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
        <div class="space-y-4 pt-4 border-t border-[#d9d9d9]/60">
            <div class="flex items-center justify-between">
                <label class="block text-[12px] font-bold text-black/45 uppercase tracking-wider">
                    Audio Sesi & Rekaman Suara
                </label>
                <!-- Simple Mode Toggle -->
                <div class="flex items-center space-x-3 text-[13px]">
                    <button type="button" 
                            @click="audioMode = 'record'"
                            :class="audioMode === 'record' ? 'font-bold text-black underline underline-offset-4' : 'text-black/50 hover:text-black'"
                            class="transition-colors">
                        Rekam Langsung
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
                           accept="audio/*" 
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                    <!-- Simple Colored Div Placeholder for upload icon -->
                    <div class="w-10 h-10 rounded-full bg-gray-200 mx-auto flex items-center justify-center text-black/50 text-[12px] font-bold">
                        AI
                    </div>

                    <div class="space-y-1">
                        <p class="text-[14px] font-medium text-black">Klik atau seret berkas audio ke sini</p>
                        <p class="text-[12px] text-black/45">Mendukung format MP3, WAV, M4A, AAC (Hingga 500 MB)</p>
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
        </div>

        <!-- 5. GENERATIVE CTA ACTION BAR -->
        <div class="pt-8 border-t border-[#d9d9d9]/60 flex items-center justify-between gap-4">
            <button type="button" 
                    @click="step = 1"
                    class="text-[14px] font-medium text-black/55 hover:text-black transition-colors">
                &larr; Ubah Judul
            </button>

            <div class="flex items-center space-x-3">
                <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/70 hover:bg-black hover:text-white transition-all">
                    Batal
                </a>
                <button type="button" 
                        @click="submitMemo()"
                        :disabled="isTranscribing"
                        class="px-7 py-3 rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white text-[14px] font-bold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95 inline-flex items-center space-x-2">
                    <span x-text="isTranscribing ? 'Memproses Rangkuman...' : 'Mulai Rangkum Catatan'"></span>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
