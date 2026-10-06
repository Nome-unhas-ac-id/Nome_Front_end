@extends('layouts.app')

@section('content')
<div class="space-y-16 max-w-7xl mx-auto" x-data="{ activeFilter: 'all' }">
    <!-- 1. MACRO-TYPOGRAPHY GREETING & HERO (Airy Whitespace) -->
    <div class="space-y-4 pt-4">
        <div class="inline-flex items-center space-x-2.5 px-4 py-1.5 rounded-full bg-white border border-[#d9d9d9]/80 text-[12px] font-medium text-black/60">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <span>Ruang Kerja Notulensi Digital &bull; Rabu, 07 Okt 2026</span>
        </div>

        <h1 class="text-[44px] sm:text-[56px] lg:text-[68px] font-black tracking-tighter text-black leading-[1.05]">
            Ruang Kerja Notulensi.
        </h1>

        <p class="text-[17px] sm:text-[19px] text-black/55 max-w-3xl font-normal leading-relaxed">
            Fokus pada substansi rapat. Biarkan kecerdasan buatan menyusun risalah, mendeteksi nama pembicara, dan merapikan kesimpulan secara otomatis.
        </p>
    </div>

    <!-- 2. WORKSPACE FOLDERS (Soft Pastel Backgrounds, Large Rounded-3xl, Minimalist) -->
    <div class="space-y-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <h2 class="text-[20px] font-bold tracking-tight text-black">Folder Ruang Kerja</h2>
                <span class="text-[11px] font-mono text-black/40 bg-white border border-[#d9d9d9]/70 px-2 py-0.5 rounded-full">4 Kategori</span>
            </div>
            <a href="{{ url('/history') }}" class="text-[13px] font-medium text-black/60 hover:text-black transition-colors">
                Kelola Semua Folder &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Folder 1: Lavender Pastel -->
            <a href="{{ url('/history') }}" class="group block bg-[#F0EEFF] rounded-3xl p-6 transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-8">
                    <span class="w-10 h-10 rounded-2xl bg-white/80 flex items-center justify-center text-black">
                        <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </span>
                    <span class="text-[12px] font-mono font-medium text-black/50 bg-white/60 px-2.5 py-0.5 rounded-full">12 Risalah</span>
                </div>
                <h3 class="text-[18px] font-bold text-black tracking-tight group-hover:text-indigo-900 transition-colors">
                    Rapat Senat & Pimpinan
                </h3>
                <p class="text-[13px] text-black/50 mt-1">Kebijakan fakultas & rektorat</p>
                <div class="flex items-center space-x-1.5 mt-5 pt-4 border-t border-indigo-950/5 text-[11px] font-medium text-black/40">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                    <span>Diperbarui kemarin</span>
                </div>
            </a>

            <!-- Folder 2: Sky Blue Pastel -->
            <a href="{{ url('/history') }}" class="group block bg-[#EAF4FE] rounded-3xl p-6 transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-8">
                    <span class="w-10 h-10 rounded-2xl bg-white/80 flex items-center justify-center text-black">
                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </span>
                    <span class="text-[12px] font-mono font-medium text-black/50 bg-white/60 px-2.5 py-0.5 rounded-full">8 Risalah</span>
                </div>
                <h3 class="text-[18px] font-bold text-black tracking-tight group-hover:text-blue-900 transition-colors">
                    Kurikulum & MBKM
                </h3>
                <p class="text-[13px] text-black/50 mt-1">Akreditasi & kemitraan industri</p>
                <div class="flex items-center space-x-1.5 mt-5 pt-4 border-t border-blue-950/5 text-[11px] font-medium text-black/40">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                    <span>Diperbarui 3 hari lalu</span>
                </div>
            </a>

            <!-- Folder 3: Warm Peach / Cream Pastel -->
            <a href="{{ url('/history') }}" class="group block bg-[#FEF6EC] rounded-3xl p-6 transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-8">
                    <span class="w-10 h-10 rounded-2xl bg-white/80 flex items-center justify-center text-black">
                        <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </span>
                    <span class="text-[12px] font-mono font-medium text-black/50 bg-white/60 px-2.5 py-0.5 rounded-full">5 Risalah</span>
                </div>
                <h3 class="text-[18px] font-bold text-black tracking-tight group-hover:text-amber-900 transition-colors">
                    Anggaran & Sarana
                </h3>
                <p class="text-[13px] text-black/50 mt-1">Pengadaan lab & komputasi awan</p>
                <div class="flex items-center space-x-1.5 mt-5 pt-4 border-t border-amber-950/5 text-[11px] font-medium text-black/40">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                    <span>Diperbarui 1 minggu lalu</span>
                </div>
            </a>

            <!-- Folder 4: Soft Mint Pastel -->
            <a href="{{ url('/history') }}" class="group block bg-[#EDF7EE] rounded-3xl p-6 transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-8">
                    <span class="w-10 h-10 rounded-2xl bg-white/80 flex items-center justify-center text-black">
                        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </span>
                    <span class="text-[12px] font-mono font-medium text-black/50 bg-white/60 px-2.5 py-0.5 rounded-full">3 Risalah</span>
                </div>
                <h3 class="text-[18px] font-bold text-black tracking-tight group-hover:text-emerald-900 transition-colors">
                    Hibah & Pengabdian
                </h3>
                <p class="text-[13px] text-black/50 mt-1">KKN Tematik & publikasi ilmiah</p>
                <div class="flex items-center space-x-1.5 mt-5 pt-4 border-t border-emerald-950/5 text-[11px] font-medium text-black/40">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                    <span>Diperbarui 2 minggu lalu</span>
                </div>
            </a>
        </div>
    </div>

    <!-- 3. FEATURED WORKFLOW: HIGH-EMPHASIS BLACK CARD + HAND-DRAWN DOODLE CARD (Images 1 & 2 Style) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- High-Emphasis Solid Black Card -->
        <div class="lg:col-span-7 bg-black text-white rounded-3xl p-8 sm:p-10 flex flex-col justify-between space-y-8">
            <div class="space-y-3">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 text-white/80 text-[11px] font-mono uppercase tracking-wider">
                    <span>Whisper-Large-v3 Engine</span>
                </div>
                <h2 class="text-[32px] sm:text-[40px] font-extrabold tracking-tighter leading-tight">
                    Mulai Sesi Rapat Baru.
                </h2>
                <p class="text-white/65 text-[15px] max-w-lg leading-relaxed">
                    Buka rekaman audio langsung melalui browser atau unggah fail rekaman. AI secara cerdas akan memisahkan pembicara dan menyusun kesimpulan rapat dinas.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-4 pt-4 border-t border-white/10">
                <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-2 bg-white text-black font-semibold text-[14px] rounded-full px-6 py-3 hover:bg-white/90 transition-transform active:scale-95">
                    <span>Mulai Perekaman Sekarang</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="{{ url('/preview') }}" class="text-[14px] text-white/70 hover:text-white transition-colors underline underline-offset-4">
                    Buka Editor Dokumen
                </a>
            </div>
        </div>

        <!-- Monochromatic Line-Art Doodle Illustration Card -->
        <div class="lg:col-span-5 bg-white border border-[#d9d9d9]/80 rounded-3xl p-8 flex flex-col justify-between space-y-6">
            <div class="space-y-2">
                <span class="text-[12px] font-bold uppercase tracking-widest text-black/40">Diarisasi Otomatis</span>
                <h3 class="text-[20px] font-bold tracking-tight text-black">
                    Transkrip Tanpa Beban
                </h3>
                <p class="text-[13px] text-black/55 leading-relaxed">
                    Setiap ucapan terpetakan dengan tepat ke pimpinan dan peserta rapat secara instan.
                </p>
            </div>

            <!-- Hand-drawn style line art SVG illustration -->
            <div class="py-4 flex items-center justify-center">
                <svg class="w-48 h-32 text-black/85" viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Head & Body of Note Taker Doodle -->
                    <circle cx="65" cy="42" r="18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M56 38 C56 38, 62 36, 68 38" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="60" cy="42" r="2" fill="currentColor"/>
                    <circle cx="70" cy="42" r="2" fill="currentColor"/>
                    <path d="M64 47 C64 47, 65 50, 68 49" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <!-- Hair Doodle -->
                    <path d="M50 40 C48 30, 62 20, 80 26 C82 35, 78 45, 78 45" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                    <!-- Torso -->
                    <path d="M48 60 C40 85, 38 115, 38 115 L95 115 C95 115, 92 85, 82 60" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                    <!-- Arms holding notebook -->
                    <path d="M42 85 C55 90, 75 92, 90 85" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <!-- Warm Notebook Sheet -->
                    <rect x="100" y="30" width="65" height="85" rx="8" stroke="currentColor" stroke-width="2.5" fill="#F8F7F3"/>
                    <line x1="112" y1="48" x2="152" y2="48" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="112" y1="60" x2="148" y2="60" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="112" y1="72" x2="140" y2="72" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="112" y1="84" x2="155" y2="84" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="150" cy="98" r="3" fill="#ff5347"/>
                </svg>
            </div>

            <div class="text-[12px] text-black/50 border-t border-[#d9d9d9]/60 pt-3 flex items-center justify-between">
                <span>Model AI Lokal Unhas</span>
                <span class="font-mono text-black/70">Akurasi 98.4%</span>
            </div>
        </div>
    </div>

    <!-- 4. RECENT MEETINGS (Spacious, Airy Horizontal Rows with Macro-Typography) -->
    <div class="space-y-6 pt-4">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h2 class="text-[26px] sm:text-[30px] font-bold tracking-tight text-black">
                    Rapat Terbaru
                </h2>
                <p class="text-[14px] text-black/50 mt-0.5">
                    Fokus pada agenda dan status risalah yang sedang berlangsung atau siap dicetak.
                </p>
            </div>

            <div class="flex items-center space-x-2">
                <button class="px-3.5 py-1.5 rounded-full text-[13px] font-medium bg-black text-white">Semua</button>
                <button class="px-3.5 py-1.5 rounded-full text-[13px] font-medium bg-white border border-[#d9d9d9]/70 text-black/60 hover:text-black">Minggu Ini</button>
                <button class="px-3.5 py-1.5 rounded-full text-[13px] font-medium bg-white border border-[#d9d9d9]/70 text-black/60 hover:text-black">Bulan Ini</button>
            </div>
        </div>

        <!-- Clean Row Cards with Massive Whitespace & Rounded-3xl -->
        <div class="space-y-4">
            <!-- Row 1 -->
            <div class="bg-white border border-[#d9d9d9]/70 rounded-3xl p-7 lg:p-8 flex flex-col lg:flex-row lg:items-center justify-between gap-6 hover:border-black/40 transition-colors">
                <div class="space-y-2.5 max-w-2xl">
                    <div class="flex items-center space-x-3 text-[12px]">
                        <span class="font-mono text-black/45">085/UN4.6.1/PL/2026</span>
                        <span class="w-1 h-1 rounded-full bg-black/20"></span>
                        <span class="text-black/50">06 Okt 2026 &bull; 09:00 WITA</span>
                        <span class="w-1 h-1 rounded-full bg-black/20"></span>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-semibold border border-emerald-200/60">
                            Selesai &bull; Siap Ekspor
                        </span>
                    </div>

                    <h3 class="text-[22px] font-bold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                        Rapat Pleno Penyusunan Rencana Strategis Rekayasa Perangkat Lunak 2026
                    </h3>

                    <p class="text-[14px] text-black/60 line-clamp-1">
                        Pimpinan: Dr. Eng. Ir. Arman, M.T. &bull; 18 Peserta Hadir &bull; Ruang Senat Lt. 2
                    </p>
                </div>

                <div class="flex items-center space-x-3 shrink-0">
                    <a href="{{ url('/preview') }}" class="px-4 py-2 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-colors">
                        Buka Risalah
                    </a>
                    <a href="{{ url('/preview') }}" class="px-5 py-2 rounded-full bg-black text-white text-[13px] font-medium hover:bg-black/85 transition-colors">
                        Ekspor PDF
                    </a>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="bg-white border border-[#d9d9d9]/70 rounded-3xl p-7 lg:p-8 flex flex-col lg:flex-row lg:items-center justify-between gap-6 hover:border-black/40 transition-colors">
                <div class="space-y-2.5 max-w-2xl">
                    <div class="flex items-center space-x-3 text-[12px]">
                        <span class="font-mono text-black/45">079/UN4.6.1/TU/2026</span>
                        <span class="w-1 h-1 rounded-full bg-black/20"></span>
                        <span class="text-black/50">03 Okt 2026 &bull; 13:30 WITA</span>
                        <span class="w-1 h-1 rounded-full bg-black/20"></span>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-semibold border border-emerald-200/60">
                            Selesai &bull; Siap Ekspor
                        </span>
                    </div>

                    <h3 class="text-[22px] font-bold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                        Sinkronisasi Kurikulum MBKM & Kemitraan Industri Digital
                    </h3>

                    <p class="text-[14px] text-black/60 line-clamp-1">
                        Pimpinan: Ketua Departemen Informatika &bull; 12 Peserta Hadir &bull; Lab RPL
                    </p>
                </div>

                <div class="flex items-center space-x-3 shrink-0">
                    <a href="{{ url('/preview') }}" class="px-4 py-2 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-colors">
                        Buka Risalah
                    </a>
                    <a href="{{ url('/preview') }}" class="px-5 py-2 rounded-full bg-black text-white text-[13px] font-medium hover:bg-black/85 transition-colors">
                        Ekspor PDF
                    </a>
                </div>
            </div>

            <!-- Row 3 -->
            <div class="bg-white border border-[#d9d9d9]/70 rounded-3xl p-7 lg:p-8 flex flex-col lg:flex-row lg:items-center justify-between gap-6 hover:border-black/40 transition-colors">
                <div class="space-y-2.5 max-w-2xl">
                    <div class="flex items-center space-x-3 text-[12px]">
                        <span class="font-mono text-black/45">075/UN4.6.1/KEU/2026</span>
                        <span class="w-1 h-1 rounded-full bg-black/20"></span>
                        <span class="text-black/50">28 Sep 2026 &bull; 10:00 WITA</span>
                        <span class="w-1 h-1 rounded-full bg-black/20"></span>
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 text-[11px] font-semibold border border-amber-200/60">
                            Menunggu Validasi Notulis
                        </span>
                    </div>

                    <h3 class="text-[22px] font-bold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                        Rapat Alokasi Anggaran Belanja Operasional Laboratorium 2027
                    </h3>

                    <p class="text-[14px] text-black/60 line-clamp-1">
                        Pimpinan: Wakil Dekan Bidang Keuangan &bull; 9 Peserta Hadir &bull; Dekanat Lt. 1
                    </p>
                </div>

                <div class="flex items-center space-x-3 shrink-0">
                    <a href="{{ url('/preview') }}" class="px-4 py-2 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-colors">
                        Tinjau Draf
                    </a>
                    <a href="{{ url('/preview') }}" class="px-5 py-2 rounded-full bg-[#ff5347] text-white text-[13px] font-medium hover:bg-[#e0453a] transition-colors">
                        Validasi & Simpan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
