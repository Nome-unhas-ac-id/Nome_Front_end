@extends('layouts.app')

@section('content')
<div class="space-y-6" 
     x-data="{
        activeTab: 'document', // 'document', 'transcript', 'json'
        isExportingPdf: false,
        isExportingDocx: false,
        showToast: false,
        toastMessage: '',
        memoData: {
            letterNumber: '085/UN4.6.1/PL/2026',
            title: 'Rapat Koordinasi Evaluasi Pembelajaran & Transkripsi Digital',
            date: 'Rabu, 07 Oktober 2026',
            time: '09:00 - 11:45 WITA',
            location: 'Ruang Senat Lt. 2 Rektorat Unhas / Hybrid Zoom',
            leader: 'Dr. Eng. Ir. Arman, M.T. (Wakil Dekan Bidang Akademik)',
            notetaker: 'Andi Muhammad Abigail (Notulis Resmi)',
            agenda: 'Penyelarasan kurikulum vokasi, adopsi modul AI meeting transcription Nome, dan penetapan jadwal magang mandiri MBKM.',
            conclusions: [
                'Menyetujui adopsi platform Nome untuk pencatatan risalah seluruh rapat dinas di lingkungan Fakultas Teknik.',
                'Pembagian akun resmi untuk 14 program studi dan departemen paling lambat 15 Oktober 2026.',
                'Integrasi server GPU lokal untuk memproses data audio sensitif secara on-premise.',
                'Penyusunan format buku pedoman notulensi digital terstandarisasi untuk mahasiswa magang.'
            ],
            actionItems: [
                { task: 'Konfigurasi server backend dan instalasi PyAnnote', pic: 'Laboratorium Komputasi Awan', deadline: '12 Okt 2026' },
                { task: 'Sosialisasi pengisian formulir rapat ke seluruh ketua departemen', pic: 'Subbagian Tata Usaha', deadline: '14 Okt 2026' },
                { task: 'Uji coba transkripsi live rapat pimpinan dekanat', pic: 'Tim Notulis Nome', deadline: '19 Okt 2026' }
            ]
        },
        aiJsonOutput: {
            version: '2.4.0',
            engine: 'Whisper-Large-v3 + PyAnnote-3.1',
            confidence_score: 0.984,
            meeting_meta: {
                id: 'NOME-SESS-20261007-01',
                title: 'Rapat Koordinasi Evaluasi Pembelajaran & Transkripsi Digital',
                letter_no: '085/UN4.6.1/PL/2026',
                timestamp: '2026-10-07T09:00:00+08:00',
                duration_seconds: 9912,
                room: 'Ruang Senat Lt. 2 Rektorat'
            },
            speakers: [
                { id: 'SPK_01', name: 'Dr. Eng. Ir. Arman, M.T.', role: 'Pimpinan Rapat' },
                { id: 'SPK_02', name: 'Prof. Dr. Ir. Indrabayu, S.T., M.T.', role: 'Ketua Departemen Informatika' },
                { id: 'SPK_03', name: 'Andi Muhammad Abigail', role: 'Notulis' }
            ],
            summary_bullets: [
                'Persetujuan resmi adopsi sistem notulensi cerdas Nome.',
                'Pengadaan server GPU lokal untuk menjamin kerahasiaan data rapat.',
                'Penetapan batas akhir pembagian akun dan sosialisasi unit pada 15 Oktober 2026.'
            ]
        },
        transcriptSegments: [
            { time: '00:01:15', speaker: 'Dr. Eng. Ir. Arman, M.T.', text: 'Selamat pagi bapak ibu sekalian. Terima kasih telah hadir tepat waktu pada rapat koordinasi teknis pagi hari ini. Kita akan fokus pada dua hal: evaluasi kurikulum dan peresmian sistem notulensi rapat otomatis Nome.' },
            { time: '00:03:40', speaker: 'Prof. Dr. Ir. Indrabayu, S.T., M.T.', text: 'Terima kasih Pak Wadek. Dari pihak Departemen Informatika, kami telah menyiapkan infrastruktur dasar dan model audio transkripsi dengan akurasi 98% untuk istilah teknis bahasa Indonesia.' },
            { time: '00:08:22', speaker: 'Dr. Eng. Ir. Arman, M.T.', text: 'Sangat baik. Bagaimana dengan aspek kerahasiaan pembicaraan rapat? Apakah data audio dikirimkan ke cloud pihak ketiga atau berjalan lokal?' },
            { time: '00:10:05', speaker: 'Prof. Dr. Ir. Indrabayu, S.T., M.T.', text: 'Sistem dirancang on-premise. Seluruh rekaman suara dan transkrip dienkripsi secara lokal di server universitas tanpa ketergantungan pihak eksternal.' },
            { time: '00:14:50', speaker: 'Andi Muhammad Abigail', text: 'Notulis mencatat kesepakatan bahwa integrasi server GPU akan diselesaikan paling lambat 12 Oktober 2026 sebelum disosialisasikan ke unit lain.' }
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

    <!-- Notification Toast (Zero Shadow, 1px Border) -->
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-3"
         class="fixed bottom-6 right-6 z-50 bg-black text-white border border-[#d9d9d9] rounded-[8px] px-4 py-3 flex items-center space-x-3 text-[14px]">
        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <span x-text="toastMessage"></span>
    </div>

    <!-- Header & Action Bar -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 pb-4 border-b border-[#d9d9d9]">
        <div>
            <div class="inline-flex items-center space-x-2 text-[12px] text-black/60 font-medium mb-2">
                <a href="{{ url('/dashboard') }}" class="hover:text-black">Dashboard</a>
                <span>/</span>
                <a href="{{ url('/history') }}" class="hover:text-black">Riwayat</a>
                <span>/</span>
                <span class="text-black font-semibold">Preview & Editor Memo</span>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-[30px] md:text-[36px] font-bold tracking-tight text-black leading-tight">
                    Pratinjau Hasil & Ekspor Dokumen
                </h1>
                <span class="px-3 py-1 rounded-full text-[12px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Selesai Diproses AI (98.4%)
                </span>
            </div>
            <p class="text-[14px] text-black/60 mt-1">
                Periksa risalah notulensi yang telah dirumuskan secara otomatis. Anda dapat menyunting langsung teks di bawah sebelum mencetak.
            </p>
        </div>

        <!-- Action Export Buttons -->
        <div class="flex flex-wrap items-center gap-2.5 self-start lg:self-auto">
            <button @click="window.print()" class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[13px] rounded-[6px] px-3.5 py-2 hover:bg-black/5 transition-colors flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-black/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak</span>
            </button>

            <button @click="exportDocx()" 
                    :disabled="isExportingDocx"
                    class="bg-white text-black/90 border border-[#d9d9d9] font-medium text-[13px] rounded-[6px] px-3.5 py-2 hover:bg-black/5 transition-colors flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span x-text="isExportingDocx ? 'Membuat Docx...' : 'Ekspor Docx'"></span>
            </button>

            <button @click="exportPdf()" 
                    :disabled="isExportingPdf"
                    class="bg-[#ff5347] text-white font-medium text-[13px] rounded-[8px] px-4 py-2 hover:bg-[#e0453a] transition-colors flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span x-text="isExportingPdf ? 'Menyiapkan PDF...' : 'Ekspor PDF Resmi'"></span>
            </button>
        </div>
    </div>

    <!-- View Mode Selector Tabs -->
    <div class="flex items-center space-x-2 border-b border-[#d9d9d9] pb-3">
        <button @click="activeTab = 'document'" 
                :class="activeTab === 'document' ? 'bg-[#ff5347] text-white font-semibold' : 'bg-white border border-[#d9d9d9] text-black/70 hover:text-black'"
                class="px-4 py-2 rounded-[8px] text-[13px] font-medium transition-colors flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span>Format Dokumen Notulensi (WYSIWYG)</span>
        </button>

        <button @click="activeTab = 'transcript'" 
                :class="activeTab === 'transcript' ? 'bg-[#ff5347] text-white font-semibold' : 'bg-white border border-[#d9d9d9] text-black/70 hover:text-black'"
                class="px-4 py-2 rounded-[8px] text-[13px] font-medium transition-colors flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            <span>Transkrip Suara & Diarisasi</span>
        </button>

        <button @click="activeTab = 'json'" 
                :class="activeTab === 'json' ? 'bg-[#ff5347] text-white font-semibold' : 'bg-white border border-[#d9d9d9] text-black/70 hover:text-black'"
                class="px-4 py-2 rounded-[8px] text-[13px] font-medium transition-colors flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
            <span>Output Mentah AI (JSON)</span>
        </button>
    </div>

    <!-- TAB 1: WYSIWYG Document Preview Card (Warm Paper Notebook / Official Dinas Style) -->
    <div x-show="activeTab === 'document'" class="space-y-4">
        <!-- Editor Toolbar (Simple WYSIWYG Actions) -->
        <div class="bg-white border border-[#d9d9d9] rounded-[8px] p-2 flex flex-wrap items-center justify-between gap-2 text-[13px]">
            <div class="flex items-center space-x-1">
                <button type="button" onclick="document.execCommand('bold', false, null)" class="p-1.5 rounded hover:bg-black/5 font-bold" title="Tebal (Ctrl+B)">B</button>
                <button type="button" onclick="document.execCommand('italic', false, null)" class="p-1.5 rounded hover:bg-black/5 italic" title="Miring (Ctrl+I)">I</button>
                <button type="button" onclick="document.execCommand('underline', false, null)" class="p-1.5 rounded hover:bg-black/5 underline" title="Garis Bawah (Ctrl+U)">U</button>
                <span class="w-px h-4 bg-[#d9d9d9] mx-1"></span>
                <button type="button" onclick="document.execCommand('insertUnorderedList', false, null)" class="p-1.5 rounded hover:bg-black/5" title="Daftar Poin">&bull; List</button>
                <button type="button" onclick="document.execCommand('insertOrderedList', false, null)" class="p-1.5 rounded hover:bg-black/5" title="Daftar Angka">1. List</button>
            </div>
            <div class="flex items-center space-x-2 text-[12px] text-black/50">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Mode Sunting Aktif &bull; Klik teks untuk mengedit</span>
            </div>
        </div>

        <!-- The Official Paper Document (ContentEditable) -->
        <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-8 sm:p-14 max-w-4xl mx-auto space-y-8 font-sans text-black" contenteditable="true">
            <!-- Kop Surat Resmi -->
            <div class="text-center border-b-2 border-black pb-4 space-y-1">
                <p class="text-[13px] uppercase tracking-widest font-semibold text-black/80">Kementerian Pendidikan Tinggi, Sains, dan Teknologi</p>
                <p class="text-[18px] uppercase tracking-wide font-extrabold text-black">Universitas Hasanuddin</p>
                <p class="text-[14px] uppercase font-bold text-black/90">Fakultas Teknik &bull; Departemen Teknik Informatika</p>
                <p class="text-[11px] text-black/60">Jl. Poros Malino Km. 6, Bontomarannu, Gowa, Sulawesi Selatan 92171 | laman: unhas.ac.id</p>
            </div>

            <!-- Title of Memo -->
            <div class="text-center space-y-1">
                <h2 class="text-[20px] font-bold tracking-tight uppercase underline text-black">Notulensi & Risalah Rapat Dinas</h2>
                <p class="text-[13px] font-mono text-black/80">Nomor: <span x-text="memoData.letterNumber"></span></p>
            </div>

            <!-- Bagian I: Rincian Rapat -->
            <div class="space-y-3">
                <h3 class="text-[15px] font-bold tracking-tight uppercase border-b border-[#d9d9d9] pb-1">I. Keterangan Pelaksanaan Rapat</h3>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 text-[14px]">
                    <span class="text-black/60">Nama Rapat</span>
                    <span class="sm:col-span-3 font-semibold text-black" x-text="memoData.title"></span>

                    <span class="text-black/60">Hari / Tanggal</span>
                    <span class="sm:col-span-3 text-black" x-text="memoData.date"></span>

                    <span class="text-black/60">Waktu</span>
                    <span class="sm:col-span-3 text-black" x-text="memoData.time"></span>

                    <span class="text-black/60">Tempat</span>
                    <span class="sm:col-span-3 text-black" x-text="memoData.location"></span>

                    <span class="text-black/60">Pimpinan Rapat</span>
                    <span class="sm:col-span-3 font-medium text-black" x-text="memoData.leader"></span>

                    <span class="text-black/60">Notulis Risalah</span>
                    <span class="sm:col-span-3 font-medium text-black" x-text="memoData.notetaker"></span>
                </div>
            </div>

            <!-- Bagian II: Agenda & Pokok Bahasan -->
            <div class="space-y-2">
                <h3 class="text-[15px] font-bold tracking-tight uppercase border-b border-[#d9d9d9] pb-1">II. Agenda Pembahasan</h3>
                <p class="text-[14px] leading-relaxed text-black/90" x-text="memoData.agenda"></p>
            </div>

            <!-- Bagian III: Kesimpulan & Hasil Keputusan -->
            <div class="space-y-3">
                <h3 class="text-[15px] font-bold tracking-tight uppercase border-b border-[#d9d9d9] pb-1">III. Kesimpulan & Rumusan Keputusan AI</h3>
                <ul class="list-disc list-outside ml-5 space-y-1.5 text-[14px] leading-relaxed text-black/90">
                    <template x-for="(concl, i) in memoData.conclusions" :key="i">
                        <li x-text="concl"></li>
                    </template>
                </ul>
            </div>

            <!-- Bagian IV: Tindak Lanjut (Action Items) -->
            <div class="space-y-3">
                <h3 class="text-[15px] font-bold tracking-tight uppercase border-b border-[#d9d9d9] pb-1">IV. Rencana Tindak Lanjut (Action Items)</h3>
                <table class="w-full text-left text-[13px] border border-[#d9d9d9]">
                    <thead class="bg-[#F8F7F3] border-b border-[#d9d9d9] font-semibold text-black/80">
                        <tr>
                            <th class="p-2.5 w-10 text-center">No</th>
                            <th class="p-2.5">Uraian Tugas / Rencana Kerja</th>
                            <th class="p-2.5">Penanggung Jawab (PIC)</th>
                            <th class="p-2.5">Tenggat Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#d9d9d9]">
                        <template x-for="(item, idx) in memoData.actionItems" :key="idx">
                            <tr>
                                <td class="p-2.5 text-center text-black/60" x-text="idx + 1"></td>
                                <td class="p-2.5 font-medium text-black" x-text="item.task"></td>
                                <td class="p-2.5 text-black/80" x-text="item.pic"></td>
                                <td class="p-2.5 font-mono text-black/70" x-text="item.deadline"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Bagian V: Kolom Pengesahan Tanda Tangan -->
            <div class="pt-8 grid grid-cols-2 gap-8 text-[14px] text-center">
                <div class="space-y-16">
                    <p class="text-black/80">Mengetahui,<br><strong class="text-black">Pimpinan Rapat</strong></p>
                    <div>
                        <p class="font-bold underline text-black">Dr. Eng. Ir. Arman, M.T.</p>
                        <p class="text-[12px] text-black/60 font-mono">NIP. 197405102000031001</p>
                    </div>
                </div>

                <div class="space-y-16">
                    <p class="text-black/80">Makassar, 07 Oktober 2026<br><strong class="text-black">Notulis Resmi</strong></p>
                    <div>
                        <p class="font-bold underline text-black">Andi Muhammad Abigail</p>
                        <p class="text-[12px] text-black/60 font-mono">NIM / ID. D121211018</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: Diarized Audio Transcript View -->
    <div x-show="activeTab === 'transcript'" class="space-y-4">
        <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 space-y-4">
            <div class="border-b border-[#d9d9d9] pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-[20px] font-bold tracking-tight text-black">Transkrip Lengkap Percakapan & Diarisasi</h2>
                    <p class="text-[13px] text-black/60">Pemisahan ucapan berdasarkan rekaman suara dan penanda waktu (timestamps).</p>
                </div>
                <span class="text-[12px] font-mono text-black/60">Total: 5 Segmen Utama</span>
            </div>

            <div class="space-y-4">
                <template x-for="(seg, i) in transcriptSegments" :key="i">
                    <div class="border border-[#d9d9d9] rounded-[8px] p-4 bg-[#F8F7F3] space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-6 h-6 rounded-full bg-black text-white text-[11px] font-bold flex items-center justify-center" x-text="seg.speaker.charAt(0)"></span>
                                <span class="text-[14px] font-bold text-black" x-text="seg.speaker"></span>
                            </div>
                            <span class="font-mono text-[12px] text-black/60 bg-white border border-[#d9d9d9] px-2 py-0.5 rounded-[4px]" x-text="seg.time"></span>
                        </div>
                        <p class="text-[14px] text-black/85 leading-relaxed pl-8" x-text="seg.text"></p>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- TAB 3: Raw AI JSON View -->
    <div x-show="activeTab === 'json'" class="space-y-4">
        <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 space-y-3">
            <div class="border-b border-[#d9d9d9] pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-[20px] font-bold tracking-tight text-black">AI Output Schema (JSON)</h2>
                    <p class="text-[13px] text-black/60">Data mentah hasil analisis model transkripsi dan rumusan kesimpulan.</p>
                </div>
                <button type="button" 
                        @click="navigator.clipboard.writeText(JSON.stringify(aiJsonOutput, null, 2)); triggerToast('JSON berhasil disalin ke clipboard!');"
                        class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[12px] rounded-[4px] px-3 py-1 hover:bg-black/5">
                    Salin JSON
                </button>
            </div>

            <pre class="bg-[#1e1e1e] text-[#d4d4d4] p-5 rounded-[8px] overflow-x-auto text-[13px] font-mono leading-relaxed max-h-[500px]" x-text="JSON.stringify(aiJsonOutput, null, 2)"></pre>
        </div>
    </div>
</div>
@endsection
