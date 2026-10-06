@extends('layouts.app')

@section('content')
<div class="space-y-12 max-w-6xl mx-auto pb-24" 
     x-data="{
        activeTab: 'document', // 'document', 'transcript', 'json'
        isExportingPdf: false,
        isExportingDocx: false,
        showToast: false,
        toastMessage: '',
        memoData: {
            letterNumber: '085/NOT-TIM/2026',
            title: 'Rapat Sinkronisasi Rencana Kerja & Roadmap Fitur',
            date: 'Rabu, 07 Oktober 2026',
            time: '09:00 - 11:45 WIB',
            location: 'Ruang Rapat Utama / Hybrid Video Call',
            leader: 'Peserta 1',
            notetaker: 'Peserta 2',
            agenda: 'Penyelarasan target kuartal, pembagian tugas prioritas, dan uji coba sistem pencatatan otomatis.',
            conclusions: [
                'Menyetujui ringkasan rencana kerja dan prioritas tugas untuk kuartal ini.',
                'Pembagian penanggung jawab fitur diselesaikan paling lambat minggu depan.',
                'Menggunakan sistem pencatatan otomatis untuk seluruh agenda diskusi tim.',
                'Penyusunan panduan sederhana alur kerja bersama anggota tim baru.'
            ],
            actionItems: [
                { task: 'Menyiapkan draft dokumen panduan tim', pic: 'Tim Produk', deadline: '12 Okt 2026' },
                { task: 'Membagikan catatan ringkasan ke seluruh peserta', pic: 'Tim Operasional', deadline: '14 Okt 2026' },
                { task: 'Uji coba alur kerja pada sesi evaluasi berikutnya', pic: 'Tim Pengembang', deadline: '19 Okt 2026' }
            ]
        },
        aiJsonOutput: {
            version: '2.4.0',
            engine: 'Audio Recognition + Smart Summary',
            confidence_score: 0.984,
            meeting_meta: {
                id: 'NOME-SESS-20261007-01',
                title: 'Rapat Sinkronisasi Rencana Kerja & Roadmap Fitur',
                letter_no: '085/NOT-TIM/2026',
                timestamp: '2026-10-07T09:00:00+08:00',
                duration_seconds: 9912,
                room: 'Ruang Rapat Utama'
            },
            speakers: [
                { id: 'SPK_01', name: 'Peserta 1', role: 'Koordinator' },
                { id: 'SPK_02', name: 'Peserta 2', role: 'Notulis' },
                { id: 'SPK_03', name: 'Peserta 3', role: 'Anggota' }
            ],
            summary_bullets: [
                'Persetujuan ringkasan rencana kerja dan target kuartal.',
                'Penyelarasan penanggung jawab masing-masing tugas prioritas.',
                'Penggunaan sistem pencatatan otomatis untuk diskusi berikutnya.'
            ]
        },
        transcriptSegments: [
            { time: '00:01:15', speaker: 'Peserta 1', role: 'Koordinator', badge: 'bg-gray-100 text-gray-700', text: 'Selamat pagi rekan-rekan sekalian. Terima kasih telah hadir tepat waktu pada sesi diskusi hari ini. Kita akan fokus pada sinkronisasi rencana kerja dan pembagian tugas utama.' },
            { time: '00:03:40', speaker: 'Peserta 2', role: 'Notulis', badge: 'bg-gray-100 text-gray-700', text: 'Dari tim produk, kami sudah merapikan daftar prioritas fitur dan timeline pengerjaan agar seluruh anggota tim memiliki acuan yang jelas.' },
            { time: '00:08:22', speaker: 'Peserta 1', role: 'Koordinator', badge: 'bg-gray-100 text-gray-700', text: 'Sangat baik. Bagaimana dengan alur pencatatan dan dokumentasi hasil diskusi kita?' },
            { time: '00:10:05', speaker: 'Peserta 2', role: 'Notulis', badge: 'bg-gray-100 text-gray-700', text: 'Sistem pencatatan otomatis langsung merekam poin penting, mengenali pembicara, dan merangkum kesimpulan dengan rapi.' },
            { time: '00:14:50', speaker: 'Peserta 3', role: 'Anggota', badge: 'bg-gray-100 text-gray-700', text: 'Catatan poin kesepakatan sudah dirangkum dan siap ditinjau oleh seluruh tim.' }
        ],

        exportPdf() {
            this.isExportingPdf = true;
            setTimeout(() => {
                this.isExportingPdf = false;
                this.triggerToast('Berkas PDF Resmi (085-UN4.6.1-PL-2026.pdf) berhasil diunduh!');
            }, 1000);
        },

        exportDocx() {
            this.isExportingDocx = true;
            setTimeout(() => {
                this.isExportingDocx = false;
                this.triggerToast('Berkas Microsoft Word (085-UN4.6.1-PL-2026.docx) berhasil diunduh!');
            }, 1000);
        },

        triggerToast(msg) {
            this.toastMessage = msg;
            this.showToast = true;
            setTimeout(() => { this.showToast = false; }, 3500);
        }
     }">

    <!-- Notification Toast (Zero Shadow, Minimalist Pill) -->
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-3"
         class="fixed bottom-8 right-8 z-50 bg-black text-white border border-[#d9d9d9]/40 rounded-full px-6 py-3 flex items-center space-x-3 text-[14px] font-medium">
        <svg class="w-4 h-4 text-[#ff5347]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
        <span x-text="toastMessage"></span>
    </div>

    <!-- 1. MACRO-TYPOGRAPHY HEADER (Strictly No Decorative Pill, Generous Whitespace) -->
    <div class="pt-6 border-b border-[#d9d9d9]/60 pb-8">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div>
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <h1 class="text-[44px] sm:text-[56px] lg:text-[68px] font-black tracking-tighter text-black leading-[1.05]">
                        Pratinjau Catatan.
                    </h1>
                    <span class="px-3.5 py-1 rounded-full text-[12px] font-medium bg-transparent text-gray-600 border border-[#d9d9d9] self-center">
                        Rangkuman Otomatis
                    </span>
                </div>
                <p class="text-[17px] text-black/55 max-w-2xl font-normal leading-relaxed">
                    Dokumen hasil pencatatan disajikan dalam format yang bersih dan rapi. Anda dapat langsung mengedit catatan sebelum mengunduh atau membagikannya.
                </p>
            </div>

            <!-- Action Pill Buttons -->
            <div class="flex flex-wrap items-center gap-3 shrink-0 self-start lg:self-auto">
                <button type="button" 
                        @click="window.print()" 
                        class="px-5 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>Cetak Lembar</span>
                </button>

                <button type="button" 
                        @click="exportDocx()" 
                        :disabled="isExportingDocx"
                        class="px-5 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm flex items-center space-x-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span x-text="isExportingDocx ? 'Membuat...' : 'Ekspor Docx'"></span>
                </button>

                <button type="button" 
                        @click="exportPdf()" 
                        :disabled="isExportingPdf"
                        class="px-6 py-2.5 rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white text-[13px] font-semibold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95 flex items-center space-x-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span x-text="isExportingPdf ? 'Menyiapkan...' : 'Ekspor PDF'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- 2. AIRY TAB SWITCHER -->
    <div class="flex items-center space-x-2">
        <button type="button" 
                @click="activeTab = 'document'" 
                :class="activeTab === 'document' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                class="px-5 py-2 rounded-full text-[13px] font-medium transition-colors flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span>Lembar Dokumen (WYSIWYG)</span>
        </button>

        <button type="button" 
                @click="activeTab = 'transcript'" 
                :class="activeTab === 'transcript' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                class="px-5 py-2 rounded-full text-[13px] font-medium transition-colors flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            <span>Transkrip Suara & Diarisasi</span>
        </button>

        <button type="button" 
                @click="activeTab = 'json'" 
                :class="activeTab === 'json' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                class="px-5 py-2 rounded-full text-[13px] font-medium transition-colors flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
            <span>Skema Data (JSON)</span>
        </button>
    </div>

    <!-- 3. TAB CONTENT -->

    <!-- TAB 1: THE EDITORIAL WHITE PAPER SHEET IN THE CENTER -->
    <div x-show="activeTab === 'document'" class="space-y-6">
        <!-- Floating Minimalist Text Editor Toolbar -->
        <div class="bg-white border border-[#d9d9d9]/70 rounded-full px-6 py-2.5 flex flex-wrap items-center justify-between gap-3 text-[13px] max-w-4xl mx-auto">
            <div class="flex items-center space-x-1.5">
                <button type="button" onclick="document.execCommand('bold', false, null)" class="w-8 h-8 rounded-full hover:bg-black/5 font-bold flex items-center justify-center transition-colors" title="Tebal (Ctrl+B)">B</button>
                <button type="button" onclick="document.execCommand('italic', false, null)" class="w-8 h-8 rounded-full hover:bg-black/5 italic font-serif flex items-center justify-center transition-colors" title="Miring (Ctrl+I)">I</button>
                <button type="button" onclick="document.execCommand('underline', false, null)" class="w-8 h-8 rounded-full hover:bg-black/5 underline flex items-center justify-center transition-colors" title="Garis Bawah (Ctrl+U)">U</button>
                <span class="w-px h-4 bg-[#d9d9d9] mx-2"></span>
                <button type="button" onclick="document.execCommand('insertUnorderedList', false, null)" class="px-3 py-1 rounded-full hover:bg-black/5 text-[12px] font-medium transition-colors" title="Daftar Poin">&bull; Bullet</button>
                <button type="button" onclick="document.execCommand('insertOrderedList', false, null)" class="px-3 py-1 rounded-full hover:bg-black/5 text-[12px] font-medium transition-colors" title="Daftar Nomor">1. Angka</button>
            </div>
            
            <div class="flex items-center space-x-2 text-[12px] text-black/45">
                <span class="w-2 h-2 rounded-full bg-[#ff5347]"></span>
                <span>Mode Sunting Aktif: Klik teks untuk merevisi</span>
            </div>
        </div>

        <!-- The Grand Paper Sheet (Maximized Whitespace, High Readability) -->
        <div class="bg-white border border-[#d9d9d9]/80 rounded-3xl p-10 sm:p-16 lg:p-20 max-w-4xl mx-auto space-y-12 font-sans text-black" contenteditable="true">
            <!-- Kop Catatan Resmi -->
            <div class="text-center border-b-2 border-black pb-6 space-y-1.5">
                <p class="text-[12px] uppercase tracking-widest font-semibold text-black/70">Dokumen Catatan Rapat</p>
                <p class="text-[20px] sm:text-[22px] uppercase tracking-wide font-black text-black">Ruang Kerja Notulensi</p>
                <p class="text-[14px] uppercase font-bold text-black/90">Laporan Diskusi Risalah</p>
            </div>

            <!-- Title of Memo -->
            <div class="text-center space-y-2">
                <h2 class="text-[22px] sm:text-[26px] font-extrabold tracking-tight uppercase underline text-black">
                    Notulensi Catatan Rapat
                </h2>
                <p class="text-[14px] font-mono text-black/75">
                    Nomor: <span x-text="memoData.letterNumber"></span>
                </p>
            </div>

            <!-- Bagian I: Keterangan Pelaksanaan Rapat -->
            <div class="space-y-4">
                <h3 class="text-[16px] font-bold tracking-tight uppercase border-b border-[#d9d9d9] pb-2 text-black">
                    I. Keterangan Pelaksanaan Rapat
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-y-3 gap-x-4 text-[15px] leading-relaxed">
                    <span class="text-black/55">Nama Rapat</span>
                    <span class="sm:col-span-3 font-bold text-black" x-text="memoData.title"></span>

                    <span class="text-black/55">Hari / Tanggal</span>
                    <span class="sm:col-span-3 text-black" x-text="memoData.date"></span>

                    <span class="text-black/55">Waktu</span>
                    <span class="sm:col-span-3 text-black" x-text="memoData.time"></span>

                    <span class="text-black/55">Tempat</span>
                    <span class="sm:col-span-3 text-black" x-text="memoData.location"></span>

                    <span class="text-black/55">Koordinator Rapat</span>
                    <span class="sm:col-span-3 font-semibold text-black" x-text="memoData.leader"></span>

                    <span class="text-black/55">Pencatat Notulensi</span>
                    <span class="sm:col-span-3 font-semibold text-black" x-text="memoData.notetaker"></span>
                </div>
            </div>

            <!-- Bagian II: Agenda Pembahasan -->
            <div class="space-y-3">
                <h3 class="text-[16px] font-bold tracking-tight uppercase border-b border-[#d9d9d9] pb-2 text-black">
                    II. Agenda Pembahasan
                </h3>
                <p class="text-[15px] leading-relaxed text-black/90" x-text="memoData.agenda"></p>
            </div>

            <!-- Bagian III: Kesimpulan -->
            <div class="space-y-4">
                <h3 class="text-[16px] font-bold tracking-tight uppercase border-b border-[#d9d9d9] pb-2 text-black">
                    III. Kesimpulan & Poin Kesepakatan
                </h3>
                <ul class="list-disc list-outside ml-6 space-y-2.5 text-[15px] leading-relaxed text-black/90">
                    <template x-for="(concl, i) in memoData.conclusions" :key="i">
                        <li x-text="concl"></li>
                    </template>
                </ul>
            </div>

            <!-- Bagian IV: Rencana Tindak Lanjut -->
            <div class="space-y-4">
                <h3 class="text-[16px] font-bold tracking-tight uppercase border-b border-[#d9d9d9] pb-2 text-black">
                    IV. Rencana Tindak Lanjut (Action Items)
                </h3>
                <div class="border border-[#d9d9d9] rounded-2xl overflow-hidden">
                    <table class="w-full text-left text-[14px]">
                        <thead class="bg-[#F8F7F3] border-b border-[#d9d9d9] font-semibold text-black/80">
                            <tr>
                                <th class="p-3.5 w-12 text-center">No</th>
                                <th class="p-3.5">Uraian Tugas</th>
                                <th class="p-3.5">Penanggung Jawab (PIC)</th>
                                <th class="p-3.5">Tenggat Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#d9d9d9] bg-white">
                            <template x-for="(item, idx) in memoData.actionItems" :key="idx">
                                <tr>
                                    <td class="p-3.5 text-center text-black/50" x-text="idx + 1"></td>
                                    <td class="p-3.5 font-semibold text-black" x-text="item.task"></td>
                                    <td class="p-3.5 text-black/80" x-text="item.pic"></td>
                                    <td class="p-3.5 font-mono text-[13px] text-black/70" x-text="item.deadline"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bagian V: Pengesahan Tanda Tangan -->
            <div class="pt-10 grid grid-cols-2 gap-8 text-[14px] text-center">
                <div class="space-y-20">
                    <p class="text-black/80">Mengetahui,<br><strong class="text-black">Koordinator Tim</strong></p>
                    <div>
                        <p class="font-bold underline text-black">Peserta 1</p>
                        <p class="text-[12px] text-black/60 font-mono mt-0.5">Penanggung Jawab</p>
                    </div>
                </div>

                <div class="space-y-20">
                    <p class="text-black/80">07 Oktober 2026<br><strong class="text-black">Pencatat Notulensi</strong></p>
                    <div>
                        <p class="font-bold underline text-black">Peserta 2</p>
                        <p class="text-[12px] text-black/60 font-mono mt-0.5">Notulis Sesi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: DIARIZED AUDIO TRANSCRIPT VIEW -->
    <div x-show="activeTab === 'transcript'" class="space-y-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between pb-2 border-b border-[#d9d9d9]/60">
            <div>
                <h2 class="text-[24px] font-bold tracking-tight text-black">Transkrip Lengkap Percakapan & Pembicara</h2>
                <p class="text-[14px] text-black/55">Pemisahan pembicara otomatis dengan penanda waktu yang akurat.</p>
            </div>
            <span class="px-4 py-1.5 rounded-full bg-white border border-[#d9d9d9] text-[12px] font-semibold text-black">
                5 Segmen Suara
            </span>
        </div>

        <div class="space-y-4">
            <template x-for="(seg, i) in transcriptSegments" :key="i">
                <div class="bg-white border border-[#d9d9d9]/70 rounded-3xl p-6 sm:p-8 space-y-3 hover:border-black/30 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-1 rounded-full text-[12px] font-semibold"
                                  :class="seg.badge" 
                                  x-text="seg.role"></span>
                            <span class="text-[15px] font-bold text-black" x-text="seg.speaker"></span>
                        </div>
                        <span class="font-mono text-[12px] text-black/50 bg-[#F8F7F3] border border-[#d9d9d9] px-3 py-1 rounded-full" x-text="seg.time"></span>
                    </div>
                    <p class="text-[15px] text-black/80 leading-relaxed pt-1" x-text="seg.text"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- TAB 3: RAW AI JSON SCHEMA VIEW -->
    <div x-show="activeTab === 'json'" class="space-y-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between pb-2 border-b border-[#d9d9d9]/60">
            <div>
                <h2 class="text-[24px] font-bold tracking-tight text-black">Data Hasil Rangkuman (JSON)</h2>
                <p class="text-[14px] text-black/55">Data hasil ringkasan dan transkrip otomatis.</p>
            </div>
            <button type="button" 
                    @click="navigator.clipboard.writeText(JSON.stringify(aiJsonOutput, null, 2)); triggerToast('JSON berhasil disalin ke clipboard!');"
                    class="px-5 py-2 rounded-full bg-black text-white text-[13px] font-medium hover:bg-black/85 transition-colors">
                Salin JSON
            </button>
        </div>

        <pre class="bg-black text-[#e5e5e5] p-8 rounded-3xl overflow-x-auto text-[13px] font-mono leading-relaxed border border-[#d9d9d9]/20" x-text="JSON.stringify(aiJsonOutput, null, 2)"></pre>
    </div>
</div>
@endsection
