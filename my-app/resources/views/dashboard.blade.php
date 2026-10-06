@extends('layouts.app')

@section('content')
<div class="space-y-8" x-data="{ filterCategory: 'all' }">
    <!-- Header & Hero Overview -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-2 border-b border-[#d9d9d9]">
        <div>
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full border border-[#d9d9d9] bg-white text-[12px] font-medium text-black/70 mb-3">
                <span class="w-2 h-2 rounded-full bg-[#ff5347]"></span>
                <span>Ruang Kerja Notulensi Digital</span>
            </div>
            <h1 class="text-[32px] md:text-[38px] font-bold tracking-tight text-black leading-tight">
                Ringkasan Transkripsi & Memo
            </h1>
            <p class="text-[15px] text-black/60 mt-1 max-w-2xl">
                Pantau proses transkripsi otomatis berbasis AI, rangkuman eksekutif, serta arsip notulensi rapat dinas Anda.
            </p>
        </div>

        <!-- Quick Primary CTA -->
        <div class="flex items-center space-x-3">
            <a href="{{ url('/history') }}" class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[14px] rounded-[8px] px-4 py-2 hover:bg-black/5 transition-colors">
                Buka Semua Arsip
            </a>
            <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-2 bg-[#ff5347] text-white font-medium text-[14px] rounded-[8px] px-5 py-2 hover:bg-[#e0453a] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Mulai Rapat Baru</span>
            </a>
        </div>
    </div>

    <!-- Stat Feature Cards (No Shadows, Flat Tactile 1px Border) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-5">
            <span class="text-[12px] font-semibold uppercase tracking-wider text-black/60">Total Memo Tercatat</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-[32px] font-bold tracking-tight text-black">28</span>
                <span class="text-[12px] font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">+4 minggu ini</span>
            </div>
            <p class="text-[13px] text-black/50 mt-1">Seluruh notulensi tervalidasi</p>
        </div>

        <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-5">
            <span class="text-[12px] font-semibold uppercase tracking-wider text-black/60">Durasi Suara Diproses</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-[32px] font-bold tracking-tight text-black">42.5<span class="text-[18px] font-normal text-black/60"> jam</span></span>
                <span class="text-[12px] font-medium text-[#ff5347] bg-[#ff5347]/10 px-2 py-0.5 rounded-full border border-[#ff5347]/30">Whisper v3</span>
            </div>
            <p class="text-[13px] text-black/50 mt-1">Tingkat akurasi transkrip 98.2%</p>
        </div>

        <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-5">
            <span class="text-[12px] font-semibold uppercase tracking-wider text-black/60">Diarisasi Pembicara</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-[32px] font-bold tracking-tight text-black">94<span class="text-[18px] font-normal text-black/60"> orang</span></span>
                <span class="text-[12px] font-medium text-black/70 bg-black/5 px-2 py-0.5 rounded-full border border-[#d9d9d9]">Teridentifikasi</span>
            </div>
            <p class="text-[13px] text-black/50 mt-1">Pemisahan suara otomatis</p>
        </div>

        <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-5">
            <span class="text-[12px] font-semibold uppercase tracking-wider text-black/60">Status Mesin AI</span>
            <div class="flex items-center space-x-2 mt-3">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[18px] font-bold tracking-tight text-black">Normal & Aktif</span>
            </div>
            <p class="text-[13px] text-black/50 mt-2">Latency: 120ms &bull; GPU Cloud OK</p>
        </div>
    </div>

    <!-- Active In-Progress / Live Meeting Banner Card -->
    <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="space-y-2">
                <div class="flex items-center space-x-2.5">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#ff5347] text-white">
                        BERLANGSUNG
                    </span>
                    <span class="text-[13px] text-black/60 font-mono">ID: NOME-SESS-20261007-01</span>
                </div>
                <h2 class="text-[22px] font-bold tracking-tight text-black">
                    Rapat Koordinasi Evaluasi Pembelajaran Semester Gasal 2026/2027
                </h2>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-[13px] text-black/70">
                    <span class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-black/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Hari ini, 07 Okt 2026 &bull; 08:30 WITA</span>
                    </span>
                    <span>&bull;</span>
                    <span>Ruang Rapat Senat Lt. 2</span>
                    <span>&bull;</span>
                    <span>Pimpinan: Dekan Fakultas Teknik</span>
                </div>
            </div>

            <!-- Live Action Buttons -->
            <div class="flex items-center space-x-3">
                <a href="{{ url('/add-memo') }}" class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[14px] rounded-[8px] px-3.5 py-2 hover:bg-black/5 transition-colors">
                    Lihat Perekaman
                </a>
                <a href="{{ url('/preview') }}" class="bg-[#ff5347] text-white font-medium text-[14px] rounded-[8px] px-4 py-2 hover:bg-[#e0453a] transition-colors flex items-center space-x-1.5">
                    <span>Lihat Preview AI</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Simulated Live Waveform / Transcription Snippet -->
        <div class="mt-5 pt-4 border-t border-[#d9d9d9] bg-[#F8F7F3] rounded-[8px] p-3.5 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="w-2.5 h-2.5 rounded-full bg-[#ff5347] animate-ping"></span>
                <p class="text-[13px] text-black/80 font-mono italic truncate max-w-xl">
                    "...kami menyepakati implementasi kurikulum berbasis proyek terintegrasi pada pertemuan ketiga nanti..."
                </p>
            </div>
            <span class="text-[12px] font-semibold text-black/60 whitespace-nowrap pl-2">Pembicara 1 (Dekan) &bull; 00:41:12</span>
        </div>
    </div>

    <!-- Main Grid: Recent Memos List & System Diagnostics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Meeting Memos List (2 Columns) -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-[22px] font-bold tracking-tight text-black">Memo Rapat Terbaru</h2>
                    <p class="text-[13px] text-black/60">Daftar risalah hasil rumusan rapat yang telah selesai diproses.</p>
                </div>
                <a href="{{ url('/history') }}" class="text-[13px] font-medium text-[#ff5347] hover:underline flex items-center space-x-1">
                    <span>Lihat Semua (28)</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <!-- Memo Item Card 1 -->
            <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 space-y-4 hover:border-black/40 transition-colors">
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-semibold">
                                SELESAI &bull; SIAP CETAK
                            </span>
                            <span class="text-[12px] text-black/60 font-mono">No. 082/UN4.6.1/PL/2026</span>
                        </div>
                        <h3 class="text-[18px] font-bold tracking-tight text-black hover:text-[#ff5347] transition-colors cursor-pointer">
                            Rapat Pleno Penyusunan Rencana Strategis Rekayasa Perangkat Lunak 2026
                        </h3>
                    </div>
                    <span class="text-[12px] text-black/60 whitespace-nowrap">06 Okt 2026</span>
                </div>

                <p class="text-[14px] text-black/75 line-clamp-2 leading-relaxed">
                    Membahas penetapan target publikasi internasional dosen, integrasi modul AI meeting transcription untuk tata kelola notulensi kampus, serta alokasi sarana laboratorium komputasi awan.
                </p>

                <div class="flex flex-wrap items-center justify-between pt-3 border-t border-[#d9d9d9] text-[13px] text-black/60 gap-3">
                    <div class="flex items-center space-x-4">
                        <span>Pimpinan: <strong class="text-black font-medium">Dr. Eng. Ir. Arman, M.T.</strong></span>
                        <span>Peserta: <strong class="text-black font-medium">18 Hadir</strong></span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ url('/preview') }}" class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[13px] rounded-[6px] px-3 py-1.5 hover:bg-black/5 transition-colors">
                            Editor & Hasil
                        </a>
                        <button class="bg-[#ff5347] text-white font-medium text-[13px] rounded-[6px] px-3 py-1.5 hover:bg-[#e0453a] transition-colors">
                            Ekspor Dokumen
                        </button>
                    </div>
                </div>
            </div>

            <!-- Memo Item Card 2 -->
            <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 space-y-4 hover:border-black/40 transition-colors">
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-semibold">
                                SELESAI &bull; SIAP CETAK
                            </span>
                            <span class="text-[12px] text-black/60 font-mono">No. 079/UN4.6.1/TU/2026</span>
                        </div>
                        <h3 class="text-[18px] font-bold tracking-tight text-black hover:text-[#ff5347] transition-colors cursor-pointer">
                            Sinkronisasi Kurikulum MBKM & Kemitraan Industri Digital
                        </h3>
                    </div>
                    <span class="text-[12px] text-black/60 whitespace-nowrap">03 Okt 2026</span>
                </div>

                <p class="text-[14px] text-black/75 line-clamp-2 leading-relaxed">
                    Persetujuan kurikulum magang mandiri dengan 5 mitra industri software nasional. Kesepakatan penyetaraan 20 SKS mata kuliah vokasi dan penunjukan dosen pembimbing lapangan.
                </p>

                <div class="flex flex-wrap items-center justify-between pt-3 border-t border-[#d9d9d9] text-[13px] text-black/60 gap-3">
                    <div class="flex items-center space-x-4">
                        <span>Pimpinan: <strong class="text-black font-medium">Ketua Departemen Informatika</strong></span>
                        <span>Peserta: <strong class="text-black font-medium">12 Hadir</strong></span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ url('/preview') }}" class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[13px] rounded-[6px] px-3 py-1.5 hover:bg-black/5 transition-colors">
                            Editor & Hasil
                        </a>
                        <button class="bg-[#ff5347] text-white font-medium text-[13px] rounded-[6px] px-3 py-1.5 hover:bg-[#e0453a] transition-colors">
                            Ekspor Dokumen
                        </button>
                    </div>
                </div>
            </div>

            <!-- Memo Item Card 3 -->
            <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 space-y-4 hover:border-black/40 transition-colors">
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-semibold">
                                PERLU VERIFIKASI NOTULIS
                            </span>
                            <span class="text-[12px] text-black/60 font-mono">No. 075/UN4.6.1/KEU/2026</span>
                        </div>
                        <h3 class="text-[18px] font-bold tracking-tight text-black hover:text-[#ff5347] transition-colors cursor-pointer">
                            Rapat Alokasi Anggaran Belanja Operasional Laboratorium 2027
                        </h3>
                    </div>
                    <span class="text-[12px] text-black/60 whitespace-nowrap">28 Sep 2026</span>
                </div>

                <p class="text-[14px] text-black/75 line-clamp-2 leading-relaxed">
                    Pemaparan rincian kebutuhan pengadaan server GPU AI, lisensi software pengembangan aplikasi, dan renovasi infrastruktur pendingin ruangan data center.
                </p>

                <div class="flex flex-wrap items-center justify-between pt-3 border-t border-[#d9d9d9] text-[13px] text-black/60 gap-3">
                    <div class="flex items-center space-x-4">
                        <span>Pimpinan: <strong class="text-black font-medium">Wakil Dekan Bidang Keuangan</strong></span>
                        <span>Peserta: <strong class="text-black font-medium">9 Hadir</strong></span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ url('/preview') }}" class="bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[13px] rounded-[6px] px-3 py-1.5 hover:bg-black/5 transition-colors">
                            Tinjau Transkrip
                        </a>
                        <button class="bg-[#ff5347] text-white font-medium text-[13px] rounded-[6px] px-3 py-1.5 hover:bg-[#e0453a] transition-colors">
                            Validasi & Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Feature Cards: System Status & Quick Tips -->
        <div class="space-y-5">
            <!-- System Health Card -->
            <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 space-y-4">
                <h2 class="text-[20px] font-bold tracking-tight text-black flex items-center justify-between">
                    <span>Status Sistem AI</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                </h2>
                
                <div class="space-y-3 text-[13px]">
                    <div class="flex items-center justify-between py-1.5 border-b border-[#d9d9d9]">
                        <span class="text-black/60">OpenAI Whisper Engine</span>
                        <span class="font-semibold text-emerald-600">Online & Ready</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-[#d9d9d9]">
                        <span class="text-black/60">PyAnnote Diarization</span>
                        <span class="font-semibold text-emerald-600">v3.1 Aktif</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-[#d9d9d9]">
                        <span class="text-black/60">Ekspor PDF & Docx</span>
                        <span class="font-semibold text-black">Format Standar Dinas</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-black/60">Penyimpanan Transkrip</span>
                        <span class="font-semibold text-black">Aman & Terenkripsi</span>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ url('/add-memo') }}" class="w-full block text-center bg-black/5 border border-[#d9d9d9] text-black font-medium text-[13px] rounded-[8px] py-2 hover:bg-black/10 transition-colors">
                        Uji Mikrofon & Perekam
                    </a>
                </div>
            </div>

            <!-- Quick Template Card -->
            <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 space-y-3">
                <h3 class="text-[16px] font-bold tracking-tight text-black">Panduan Notulensi Cepat</h3>
                <ol class="list-decimal list-inside space-y-2 text-[13px] text-black/70 leading-relaxed">
                    <li>Isi <strong>Informasi Rapat & Surat</strong> sebelum acara dimulai.</li>
                    <li>Aktifkan <strong>Perekam Audio</strong> atau unggah rekaman `.m4a / .wav`.</li>
                    <li>AI secara instan mengidentifikasi nama pembicara dan butir kesimpulan.</li>
                    <li>Koreksi hasil di <strong>Preview Editor</strong> lalu unduh berkas resmi.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
