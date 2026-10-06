@extends('layouts.app')

@section('main_class', 'flex-1 w-full p-0')

@section('content')
<div class="w-full">
    <!-- ======================================================== -->
    <!-- 2. HERO SECTION LAYOUT (TWO COLUMNS, FULL WIDTH, BG-WHITE) -->
    <!-- ======================================================== -->
    <section class="w-full bg-white border-b border-[#d9d9d9]/70 pt-28 sm:pt-36 pb-16 sm:pb-24 px-6 sm:px-10 lg:px-16">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- LEFT COLUMN (Typography, Subtle Yellow Accent, & CTA) -->
            <div class="lg:col-span-6 space-y-8">
                <div class="space-y-4">
                    <!-- Eyebrow label -->
                    <div class="inline-flex items-center space-x-2 text-[12px] font-semibold tracking-wider uppercase text-black/50">
                        <span>Platform Transkripsi & Risalah AI</span>
                    </div>

                    <!-- Very large, bold headline with thick yellow underline accent -->
                    <h1 class="text-[44px] sm:text-[56px] lg:text-[64px] font-black tracking-tighter text-black leading-[1.05]">
                        1,090 Risalah dibuat untuk <span class="relative inline-block text-black">Notulensi<span class="absolute left-0 bottom-1 sm:bottom-2 w-full h-3 sm:h-3.5 bg-[#FFD027] -z-10 rounded-xs"></span></span> otomatis
                    </h1>

                    <!-- Subheadline in muted gray (text-gray-500) -->
                    <p class="text-[17px] sm:text-[19px] text-gray-500 font-normal leading-relaxed max-w-lg">
                        Masuki era baru perumusan risalah sidang dinas menggunakan transkripsi suara monokromatik dan ringkasan berbasis AI.
                    </p>
                </div>

                <!-- CTA Button (Solid black, rounded-xl, white text) -->
                <div>
                    <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-2.5 bg-black text-white hover:bg-black/85 rounded-xl px-8 py-4 text-[15px] font-bold transition-transform active:scale-95 shadow-none">
                        <span>Mulai Notulensi Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Launch Checklist / Feature Highlight (Matches Reference Image) -->
                <div class="pt-8 border-t border-[#d9d9d9]/60 flex flex-col sm:flex-row sm:items-center gap-6">
                    <!-- ======================================================== -->
                    <!-- [HERO SVG SLOT 4: BOTTOM-LEFT CHECKLIST WORKER] -->
                    <!-- ID: #hero-illustration-bottom-left -->
                    <!-- Paste your exported SVG directly here or replace with <img> -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-bottom-left" class="w-24 h-24 sm:w-28 sm:h-28 shrink-0 bg-[#F8F7F3] rounded-2xl border border-[#d9d9d9]/70 flex items-center justify-center p-2 relative group overflow-hidden">
                        <!-- Default Monochrome Hand-Drawn SVG Placeholder -->
                        <svg class="w-full h-full text-black" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="50" cy="50" r="38" stroke-dasharray="2 2" stroke-width="1"/>
                            <rect x="28" y="24" width="40" height="52" rx="4" fill="white"/>
                            <path d="M36 36h14M36 46h24M36 56h18" stroke-linecap="round"/>
                            <path d="M60 34l4 4 10-10" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                            <!-- Tiny pencil doodle -->
                            <path d="M64 68 L78 54 L82 58 L68 72 Z" fill="black"/>
                        </svg>
                    </div>

                    <div class="space-y-1.5">
                        <h4 class="text-[15px] font-bold text-black tracking-tight">Alur Kerja Terintegrasi</h4>
                        <p class="text-[13px] text-gray-500 leading-relaxed max-w-sm">
                            Diarisasi multi-pembicara PyAnnote, format berita acara resmi, dan ekspor instan tanpa perlu merangkum manual.
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN (Flexible CSS Grid / Absolute Overlapping SVG Layout) -->
            <div class="lg:col-span-6 relative flex items-center justify-center">
                <!-- Outer Relative Container to Hold Multiple SVG Illustrations -->
                <div class="relative w-full h-[460px] sm:h-[520px] flex items-center justify-center select-none">
                    
                    <!-- Decorative subtle canvas frame -->
                    <div class="absolute inset-0 border border-dashed border-[#d9d9d9]/60 rounded-3xl -z-10 bg-[#fafafa]/50"></div>

                    <!-- ======================================================== -->
                    <!-- [HERO SVG SLOT 1: TOP FLOATING CARD] -->
                    <!-- ID: #hero-illustration-top-card -->
                    <!-- Paste your exported SVG directly here or replace with <img> -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-top-card" 
                         class="absolute top-2 right-6 sm:right-16 z-20 w-44 sm:w-52 bg-white border border-black rounded-2xl p-3 shadow-none hover:rotate-1 transition-transform">
                        <div class="text-[10px] font-mono text-black/40 border-b border-[#d9d9d9]/60 pb-1 mb-2 flex items-center justify-between">
                            <span>#hero-illustration-top-card</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        </div>
                        <!-- Default SVG: Waving character -->
                        <svg class="w-full h-28 sm:h-32 text-black" viewBox="0 0 160 100" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <!-- Head and Hair -->
                            <path d="M60 40 Q80 20 100 40 Q110 60 90 70 Q70 75 60 40 Z" fill="white"/>
                            <path d="M55 35 Q80 15 105 35 Q105 50 95 50 Q75 40 55 35 Z" fill="black"/>
                            <!-- Eyes & Smile -->
                            <circle cx="75" cy="45" r="2" fill="black"/>
                            <circle cx="88" cy="45" r="2" fill="black"/>
                            <path d="M78 55 Q82 60 86 55"/>
                            <!-- Body / Collar -->
                            <path d="M65 72 L50 98 M90 72 L105 98 M77 72 L77 98"/>
                            <!-- Waving Hand -->
                            <path d="M110 50 Q125 35 130 45 Q125 55 115 60" stroke-width="2.2"/>
                        </svg>
                    </div>

                    <!-- ======================================================== -->
                    <!-- [HERO SVG SLOT 2: RIGHT COLLABORATION CARD] -->
                    <!-- ID: #hero-illustration-right-card -->
                    <!-- Paste your exported SVG directly here or replace with <img> -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-right-card" 
                         class="absolute top-24 sm:top-24 -right-2 sm:right-2 z-30 w-52 sm:w-60 bg-white border border-black rounded-2xl p-3 shadow-none hover:-rotate-1 transition-transform">
                        <div class="text-[10px] font-mono text-black/40 border-b border-[#d9d9d9]/60 pb-1 mb-2 flex items-center justify-between">
                            <span>#hero-illustration-right-card</span>
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        </div>
                        <!-- Default SVG: Collaborative Duo -->
                        <svg class="w-full h-32 sm:h-36 text-black" viewBox="0 0 180 120" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <!-- Monitor Frame -->
                            <rect x="25" y="25" width="65" height="55" rx="6" fill="white"/>
                            <!-- Face in screen with heart -->
                            <circle cx="58" cy="48" r="14" fill="white"/>
                            <path d="M53 46h2M62 46h2M54 54 Q58 58 62 54"/>
                            <path d="M42 42 Q40 36 45 36 Q49 36 49 40 Q49 36 53 36 Q58 36 56 42 Q52 48 49 51 Q46 48 42 42 Z" fill="#ff5347" stroke="#ff5347" stroke-width="1"/>
                            <!-- Colleague Pointing -->
                            <path d="M125 35 Q140 20 155 35 Q160 55 145 65" fill="white"/>
                            <path d="M120 30 Q140 10 160 30 Q150 45 135 40 Z" fill="black"/>
                            <path d="M135 70 L115 85 L95 72" stroke-width="2.5"/>
                            <circle cx="95" cy="72" r="3" fill="black"/>
                        </svg>
                    </div>

                    <!-- ======================================================== -->
                    <!-- [HERO SVG SLOT 3: MAIN CENTRAL NOTION-STYLE CHARACTER] -->
                    <!-- ID: #hero-illustration-main -->
                    <!-- Paste your exported SVG directly here or replace with <img> -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-main" 
                         class="relative z-20 w-72 sm:w-96 bg-white border border-black rounded-3xl p-5 shadow-none mt-16 sm:mt-20">
                        <div class="text-[10px] font-mono text-black/40 border-b border-[#d9d9d9]/60 pb-1.5 mb-3 flex items-center justify-between">
                            <span>#hero-illustration-main (Pusat Ilustrasi)</span>
                            <span class="w-2 h-2 rounded-full bg-black"></span>
                        </div>
                        <!-- Default SVG: Person with Laptop & Papers -->
                        <svg class="w-full h-48 sm:h-56 text-black" viewBox="0 0 240 160" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <!-- Person with Glasses -->
                            <path d="M90 60 Q110 30 130 60 Q135 85 115 95 Q95 90 90 60 Z" fill="white"/>
                            <!-- Hair -->
                            <path d="M85 55 Q105 30 135 50 Q130 65 120 60 Q100 50 85 55 Z" fill="black"/>
                            <!-- Glasses & Nose -->
                            <circle cx="105" cy="65" r="7" stroke-width="1.8"/>
                            <circle cx="122" cy="65" r="7" stroke-width="1.8"/>
                            <line x1="112" y1="65" x2="115" y2="65"/>
                            <path d="M110 75 Q115 80 118 76"/>
                            <!-- Tie and Collar -->
                            <path d="M108 95 L114 135 L120 95 Z" fill="black"/>
                            <path d="M95 95 L108 95 M120 95 L133 95"/>
                            <!-- Laptop with Diamond Icon -->
                            <rect x="145" y="85" width="75" height="50" rx="6" fill="black"/>
                            <polygon points="182,100 188,106 182,114 176,106" fill="white"/>
                            <line x1="135" y1="135" x2="225" y2="135" stroke-width="3"/>
                            <!-- Hands on Keyboard -->
                            <path d="M130 110 Q145 115 155 125"/>
                            <!-- Papers on Desk -->
                            <path d="M40 115 L75 110 L85 145 L50 150 Z" fill="white"/>
                            <line x1="50" y1="122" x2="70" y2="120" stroke-width="1.5"/>
                            <line x1="52" y1="130" x2="75" y2="128" stroke-width="1.5"/>
                            <line x1="55" y1="138" x2="78" y2="136" stroke-width="1.5"/>
                        </svg>
                    </div>

                    <!-- ======================================================== -->
                    <!-- [HERO SVG SLOT 5: FLOATING DOODLE ACCENTS] -->
                    <!-- ID: #hero-illustration-floating -->
                    <!-- Paste your exported SVG directly here or replace with <img> -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-floating" class="absolute top-4 left-6 z-10 w-24 h-24 pointer-events-none opacity-80">
                        <svg class="w-full h-full text-black" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 50 Q35 48 50 35 Q52 50 65 52 Q50 54 48 68 Q46 52 20 50 Z" fill="white"/>
                            <circle cx="75" cy="25" r="3" fill="black"/>
                            <circle cx="85" cy="35" r="2" fill="black"/>
                        </svg>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- ======================================================== -->
    <!-- 3. LOWER DASHBOARD UI (WARM CANVAS #F8F7F3, FULL CONTENT) -->
    <!-- ======================================================== -->
    <div class="bg-[#F8F7F3] px-6 sm:px-10 lg:px-16 py-14 sm:py-20 space-y-16">
        <div class="max-w-7xl mx-auto space-y-16" x-data="{ activeFilter: 'all' }">
            
            <!-- A. MACRO-TYPOGRAPHY GREETING & STATUS -->
            <div class="space-y-4">
                <div class="inline-flex items-center space-x-2.5 px-4 py-1.5 rounded-full bg-white border border-[#d9d9d9]/80 text-[12px] font-medium text-black/60">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Ruang Kerja Notulensi Digital &bull; Rabu, 07 Okt 2026</span>
                </div>

                <h2 class="text-[40px] sm:text-[52px] lg:text-[60px] font-black tracking-tighter text-black leading-[1.05]">
                    Ruang Kerja Notulensi.
                </h2>

                <p class="text-[17px] text-black/55 max-w-3xl font-normal leading-relaxed">
                    Fokus pada substansi rapat. Biarkan kecerdasan buatan menyusun risalah, mendeteksi nama pembicara, dan merapikan kesimpulan secara otomatis.
                </p>
            </div>

            <!-- B. WORKSPACE FOLDERS (Soft Pastel Backgrounds, Large Rounded-3xl) -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <h3 class="text-[20px] font-bold tracking-tight text-black">Folder Ruang Kerja</h3>
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
                        <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-indigo-900 transition-colors">
                            Rapat Senat & Pimpinan
                        </h4>
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
                        <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-blue-900 transition-colors">
                            Kurikulum & MBKM
                        </h4>
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
                        <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-amber-900 transition-colors">
                            Anggaran & Sarana
                        </h4>
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
                        <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-emerald-900 transition-colors">
                            Hibah & Pengabdian
                        </h4>
                        <p class="text-[13px] text-black/50 mt-1">KKN Tematik & publikasi ilmiah</p>
                        <div class="flex items-center space-x-1.5 mt-5 pt-4 border-t border-emerald-950/5 text-[11px] font-medium text-black/40">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            <span>Diperbarui 2 minggu lalu</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- C. FEATURED WORKFLOW: HIGH-EMPHASIS BLACK CARD + HAND-DRAWN DOODLE CARD -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- High-Emphasis Solid Black Card -->
                <div class="lg:col-span-7 bg-black text-white rounded-3xl p-8 sm:p-10 flex flex-col justify-between space-y-8">
                    <div class="space-y-3">
                        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 text-white/80 text-[11px] font-mono uppercase tracking-wider">
                            <span>Whisper-Large-v3 Engine</span>
                        </div>
                        <h3 class="text-[32px] sm:text-[40px] font-extrabold tracking-tighter leading-tight">
                            Mulai Sesi Rapat Baru.
                        </h3>
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
                        <h4 class="text-[20px] font-bold tracking-tight text-black">
                            Transkrip Tanpa Beban
                        </h4>
                        <p class="text-[13px] text-black/55 leading-relaxed">
                            Setiap ucapan terpetakan dengan tepat ke pimpinan dan peserta rapat secara instan.
                        </p>
                    </div>

                    <!-- Hand-drawn style line art SVG illustration -->
                    <div class="py-4 flex items-center justify-center">
                        <svg class="w-48 h-32 text-black/85" viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="100" cy="50" rx="30" ry="24" stroke="currentColor" stroke-width="2" fill="white"/>
                            <path d="M85 35 Q100 20 115 35 Q118 45 105 45 Q90 40 85 35 Z" fill="black"/>
                            <circle cx="94" cy="50" r="2.5" fill="black"/>
                            <circle cx="106" cy="50" r="2.5" fill="black"/>
                            <path d="M96 60 Q100 64 104 60" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M78 74 Q60 85 55 125 L145 125 Q140 85 122 74" stroke="currentColor" stroke-width="2" fill="white"/>
                            <path d="M85 100 L115 100 L115 125 L85 125 Z" stroke="currentColor" stroke-width="1.8" fill="#F8F7F3"/>
                            <path d="M90 108 H110 M90 115 H105" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M125 105 L140 85" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div class="pt-2 border-t border-[#d9d9d9]/60 flex items-center justify-between text-[12px] text-black/50">
                        <span>Akurasi Model: 98.4%</span>
                        <a href="{{ url('/preview') }}" class="font-medium text-black hover:underline">Lihat Diarisasi &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- D. RECENT MEETINGS LIST (Airy Gap, Zero Drop-Shadows) -->
            <div class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-black">Rapat Terbaru</h3>
                        <p class="text-[13px] text-black/50 mt-0.5">Daftar agenda notulensi yang tersimpan dan siap diproses.</p>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button @click="activeFilter = 'all'" 
                                :class="activeFilter === 'all' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                                class="px-3.5 py-1.5 rounded-full text-[12px] font-medium transition-colors">
                            Semua
                        </button>
                        <button @click="activeFilter = 'completed'" 
                                :class="activeFilter === 'completed' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                                class="px-3.5 py-1.5 rounded-full text-[12px] font-medium transition-colors">
                            Siap Ekspor
                        </button>
                        <button @click="activeFilter = 'review'" 
                                :class="activeFilter === 'review' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                                class="px-3.5 py-1.5 rounded-full text-[12px] font-medium transition-colors">
                            Verifikasi
                        </button>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Meeting Row 1 -->
                    <div class="bg-white border border-[#d9d9d9]/70 rounded-2xl p-6 lg:p-7 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-black/40 transition-colors cursor-pointer"
                         @click="window.location.href='{{ url('/preview') }}'">
                        <div class="space-y-2 max-w-3xl">
                            <div class="flex flex-wrap items-center gap-2 text-[12px]">
                                <span class="font-mono text-black/45">085/UN4.6.1/PL/2026</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="text-black/55 font-medium">06 Okt 2026 &bull; 09:00 WITA</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                                    Siap Ekspor
                                </span>
                            </div>

                            <h4 class="text-[20px] font-extrabold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                                Rapat Pleno Penyusunan Rencana Strategis Rekayasa Perangkat Lunak 2026
                            </h4>

                            <p class="text-[14px] text-black/60 line-clamp-1">
                                Pimpinan: Dr. Eng. Ir. Arman, M.T. &bull; Ruang Senat Rektorat Lt. 2 &bull; 18 Peserta Hadir
                            </p>
                        </div>

                        <div class="flex items-center space-x-3 shrink-0">
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-colors">
                                Pratinjau
                            </a>
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full bg-black text-white text-[13px] font-medium hover:bg-black/85 transition-colors">
                                Ekspor PDF
                            </a>
                        </div>
                    </div>

                    <!-- Meeting Row 2 -->
                    <div class="bg-white border border-[#d9d9d9]/70 rounded-2xl p-6 lg:p-7 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-black/40 transition-colors cursor-pointer"
                         @click="window.location.href='{{ url('/preview') }}'">
                        <div class="space-y-2 max-w-3xl">
                            <div class="flex flex-wrap items-center gap-2 text-[12px]">
                                <span class="font-mono text-black/45">079/UN4.6.1/TU/2026</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="text-black/55 font-medium">03 Okt 2026 &bull; 13:30 WITA</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                                    Siap Ekspor
                                </span>
                            </div>

                            <h4 class="text-[20px] font-extrabold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                                Sinkronisasi Kurikulum MBKM & Kemitraan Industri Digital
                            </h4>

                            <p class="text-[14px] text-black/60 line-clamp-1">
                                Pimpinan: Ketua Departemen Informatika &bull; Lab Rekayasa Perangkat Lunak &bull; 12 Peserta Hadir
                            </p>
                        </div>

                        <div class="flex items-center space-x-3 shrink-0">
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-colors">
                                Pratinjau
                            </a>
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full bg-black text-white text-[13px] font-medium hover:bg-black/85 transition-colors">
                                Ekspor PDF
                            </a>
                        </div>
                    </div>

                    <!-- Meeting Row 3 -->
                    <div class="bg-white border border-[#d9d9d9]/70 rounded-2xl p-6 lg:p-7 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-black/40 transition-colors cursor-pointer"
                         @click="window.location.href='{{ url('/preview') }}'">
                        <div class="space-y-2 max-w-3xl">
                            <div class="flex flex-wrap items-center gap-2 text-[12px]">
                                <span class="font-mono text-black/45">075/UN4.6.1/KEU/2026</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="text-black/55 font-medium">28 Sep 2026 &bull; 10:00 WITA</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/60">
                                    Verifikasi Notulis
                                </span>
                            </div>

                            <h4 class="text-[20px] font-extrabold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                                Rapat Alokasi Anggaran Belanja Operasional Laboratorium 2027
                            </h4>

                            <p class="text-[14px] text-black/60 line-clamp-1">
                                Pimpinan: Wakil Dekan Bidang Keuangan &bull; Ruang Dekanat Lt. 1 &bull; 9 Peserta Hadir
                            </p>
                        </div>

                        <div class="flex items-center space-x-3 shrink-0">
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-colors">
                                Pratinjau
                            </a>
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full bg-black text-white text-[13px] font-medium hover:bg-black/85 transition-colors">
                                Ekspor PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
