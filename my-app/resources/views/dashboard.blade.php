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
                    <!-- Very large, bold headline with thick yellow underline accent -->
                    <h1 class="text-[44px] sm:text-[56px] lg:text-[64px] font-black tracking-tighter text-black leading-[1.05] animate-fade-in-up">
                        1,090 Rapat Dirangkum <span class="relative inline-block text-black">Tanpa Ribet.<span class="absolute left-0 bottom-1 sm:bottom-2 w-full h-3 sm:h-3.5 bg-[#FFD027] -z-10 rounded-xs"></span></span>
                    </h1>

                    <!-- Subheadline in muted gray (text-gray-500) -->
                    <p class="text-[17px] sm:text-[19px] text-gray-500 font-normal leading-relaxed max-w-lg animate-fade-in-up-delay">
                        Rekam obrolan, biarkan sistem yang menulis catatan dan kesimpulannya untukmu.
                    </p>
                </div>

                <!-- CTA Button (Secondary Color #ff5347, rounded-xl, white text) -->
                <div class="animate-fade-in-up-delay">
                    <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-2.5 bg-[#ff5347] hover:bg-[#e0453a] text-white rounded-xl px-8 py-4 text-[15px] font-bold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95 shadow-none">
                        <span>Mulai Rapat Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Launch Checklist / Feature Highlight (Matches Reference Image) -->
                <div class="pt-8 border-t border-[#d9d9d9]/60 flex items-center gap-5 hover:scale-[1.02] transition-transform duration-300">
                    <!-- Universal Icon Placeholder -->
                    <div id="hero-illustration-bottom-left" class="w-12 h-12 rounded-full bg-[#ff5347]/20 border border-[#ff5347] shrink-0"></div>

                    <div class="space-y-1">
                        <h4 class="text-[16px] font-bold text-black tracking-tight">Kerja Lebih Cepat</h4>
                        <p class="text-[13px] text-gray-500 leading-relaxed max-w-sm">
                            Otomatis kenali siapa yang bicara dan ubah suara jadi teks dalam hitungan menit.
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
                            <span class="w-2 h-2 rounded-full bg-[#ff5347]"></span>
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
                <h2 class="text-[40px] sm:text-[52px] lg:text-[60px] font-black tracking-tighter text-black leading-[1.05]">
                    Ruang Kerja Notulensi.
                </h2>

                <p class="text-[17px] text-black/55 max-w-3xl font-normal leading-relaxed">
                    Fokus pada obrolan rapat. Biarkan sistem mencatat poin penting, mengenali pembicara, dan merapikan kesimpulan secara otomatis.
                </p>
            </div>

            <!-- B. WORKSPACE FOLDERS (Soft Pastel Backgrounds, Large Rounded-3xl, Hover Scale) -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <h3 class="text-[20px] font-bold tracking-tight text-black">Folder Ruang Kerja</h3>
                        <span class="text-[11px] font-mono text-black/40 bg-white border border-[#d9d9d9]/70 px-2 py-0.5 rounded-full">4 Kategori</span>
                    </div>
                    <a href="{{ url('/memo') }}" class="text-[13px] font-medium text-black/60 hover:text-[#ff5347] transition-colors">
                        Kelola Semua Folder &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- Folder 1: Lavender Pastel -->
                    <a href="{{ url('/memo') }}" class="group block bg-[#F0EEFF] rounded-3xl p-6 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-8">
                            <span class="w-10 h-10 rounded-2xl bg-white/80 flex items-center justify-center text-black">
                                <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </span>
                            <span class="text-[12px] font-mono font-medium text-black/50 bg-white/60 px-2.5 py-0.5 rounded-full">12 Catatan</span>
                        </div>
                        <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-indigo-900 transition-colors">
                            Diskusi Tim Mingguan
                        </h4>
                        <p class="text-[13px] text-black/50 mt-1">Update progres dan koordinasi kerja</p>
                        <div class="flex items-center space-x-1.5 mt-5 pt-4 border-t border-indigo-950/5 text-[11px] font-medium text-black/40">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                            <span>Diperbarui kemarin</span>
                        </div>
                    </a>

                    <!-- Folder 2: Sky Blue Pastel -->
                    <a href="{{ url('/memo') }}" class="group block bg-[#EAF4FE] rounded-3xl p-6 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-8">
                            <span class="w-10 h-10 rounded-2xl bg-white/80 flex items-center justify-center text-black">
                                <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </span>
                            <span class="text-[12px] font-mono font-medium text-black/50 bg-white/60 px-2.5 py-0.5 rounded-full">8 Catatan</span>
                        </div>
                        <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-blue-900 transition-colors">
                            Rencana & Desain Produk
                        </h4>
                        <p class="text-[13px] text-black/50 mt-1">Roadmap fitur dan riset pengguna</p>
                        <div class="flex items-center space-x-1.5 mt-5 pt-4 border-t border-blue-950/5 text-[11px] font-medium text-black/40">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                            <span>Diperbarui 3 hari lalu</span>
                        </div>
                    </a>

                    <!-- Folder 3: Warm Peach / Cream Pastel -->
                    <a href="{{ url('/memo') }}" class="group block bg-[#FEF6EC] rounded-3xl p-6 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-8">
                            <span class="w-10 h-10 rounded-2xl bg-white/80 flex items-center justify-center text-black">
                                <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </span>
                            <span class="text-[12px] font-mono font-medium text-black/50 bg-white/60 px-2.5 py-0.5 rounded-full">5 Catatan</span>
                        </div>
                        <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-amber-900 transition-colors">
                            Evaluasi & Laporan
                        </h4>
                        <p class="text-[13px] text-black/50 mt-1">Review capaian dan kendala tim</p>
                        <div class="flex items-center space-x-1.5 mt-5 pt-4 border-t border-amber-950/5 text-[11px] font-medium text-black/40">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                            <span>Diperbarui 1 minggu lalu</span>
                        </div>
                    </a>

                    <!-- Folder 4: Minimal Neutral Gray -->
                    <a href="{{ url('/memo') }}" class="group block bg-[#F4F4F3] rounded-3xl p-6 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-0.5">
                        <div class="flex items-center justify-between mb-8">
                            <span class="w-10 h-10 rounded-2xl bg-white/80 flex items-center justify-center text-black">
                                <svg class="w-5 h-5 text-black/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </span>
                            <span class="text-[12px] font-mono font-medium text-black/50 bg-white/60 px-2.5 py-0.5 rounded-full">3 Catatan</span>
                        </div>
                        <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-black transition-colors">
                            Eksplorasi Ide Baru
                        </h4>
                        <p class="text-[13px] text-black/50 mt-1">Brainstorming gagasan dan eksperimen</p>
                        <div class="flex items-center space-x-1.5 mt-5 pt-4 border-t border-black/5 text-[11px] font-medium text-black/40">
                            <span class="w-1.5 h-1.5 rounded-full bg-black/40"></span>
                            <span>Diperbarui 2 minggu lalu</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- C. FEATURED WORKFLOW: HIGH-EMPHASIS BLACK CARD + HAND-DRAWN DOODLE CARD -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- High-Emphasis Solid Black Card -->
                <div class="lg:col-span-7 bg-black text-white rounded-3xl p-8 sm:p-10 flex flex-col justify-between space-y-8 hover:scale-[1.02] transition-transform duration-300">
                    <div class="space-y-3">
                        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 text-white/80 text-[11px] font-mono uppercase tracking-wider">
                            <span>Pencatatan Cepat</span>
                        </div>
                        <h3 class="text-[32px] sm:text-[40px] font-extrabold tracking-tighter leading-tight">
                            Mulai Rapat Baru.
                        </h3>
                        <p class="text-white/65 text-[15px] max-w-lg leading-relaxed">
                            Mulai obrolan langsung lewat browser atau unggah rekaman audio. Sistem otomatis merangkum poin penting dan pembagian tugas untuk timmu.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 pt-4 border-t border-white/10">
                        <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-2 bg-[#ff5347] hover:bg-[#e0453a] text-white font-semibold text-[14px] rounded-full px-6 py-3 transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95">
                            <span>Coba Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="{{ url('/preview') }}" class="text-[14px] text-white/70 hover:text-white transition-colors underline underline-offset-4">
                            Buka Editor Catatan
                        </a>
                    </div>
                </div>

                <!-- Monochromatic Line-Art Doodle Illustration Card -->
                <div class="lg:col-span-5 bg-white border border-[#d9d9d9]/80 rounded-3xl p-8 flex flex-col justify-between space-y-6 hover:scale-[1.02] transition-transform duration-300">
                    <div class="space-y-2">
                        <span class="text-[12px] font-bold uppercase tracking-widest text-black/40">Transkrip Otomatis</span>
                        <h4 class="text-[20px] font-bold tracking-tight text-black">
                            Catatan Rapi Seketika
                        </h4>
                        <p class="text-[13px] text-black/55 leading-relaxed">
                            Setiap percakapan langsung tercatat dengan rapi dan siap dibagikan ke seluruh tim tanpa repot mengetik ulang.
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
                        <span>Proses Cepat & Praktis</span>
                        <a href="{{ url('/preview') }}" class="font-medium text-[#ff5347] hover:underline">Lihat Contoh &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- D. RECENT MEETINGS LIST (Airy Gap, Zero Drop-Shadows) -->
            <div class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-black">Rapat Terbaru</h3>
                        <p class="text-[13px] text-black/50 mt-0.5">Daftar catatan rapat tim yang tersimpan dan siap dibagikan.</p>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button @click="activeFilter = 'all'" 
                                :class="activeFilter === 'all' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                                class="px-3.5 py-1.5 rounded-full text-[12px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                            Semua
                        </button>
                        <button @click="activeFilter = 'completed'" 
                                :class="activeFilter === 'completed' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                                class="px-3.5 py-1.5 rounded-full text-[12px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                            Selesai
                        </button>
                        <button @click="activeFilter = 'review'" 
                                :class="activeFilter === 'review' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                                class="px-3.5 py-1.5 rounded-full text-[12px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                            Perlu Cek
                        </button>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Meeting Row 1 -->
                    <div class="bg-white border border-[#d9d9d9]/70 rounded-2xl p-6 lg:p-7 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-black/40 transition-colors cursor-pointer"
                         @click="window.location.href='{{ url('/preview') }}'">
                        <div class="space-y-2 max-w-3xl">
                            <div class="flex flex-wrap items-center gap-2 text-[12px]">
                                <span class="font-mono text-black/45">RPT-2026-003</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="text-black/55 font-medium">06 Okt 2026 &bull; 09:00 WIB</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-transparent text-gray-600 border border-[#d9d9d9]">
                                    Selesai
                                </span>
                            </div>

                            <h4 class="text-[20px] font-extrabold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                                Sinkronisasi Target Kuartal & Roadmap Fitur
                            </h4>

                            <p class="text-[14px] text-black/60 line-clamp-1">
                                Penyelenggara: Tim Produk &bull; Ruang Rapat Tim &bull; 8 Orang Hadir
                            </p>
                        </div>

                        <div class="flex items-center space-x-3 shrink-0">
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                                Pratinjau
                            </a>
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white text-[13px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                                Ekspor PDF
                            </a>
                        </div>
                    </div>

                    <!-- Meeting Row 2 -->
                    <div class="bg-white border border-[#d9d9d9]/70 rounded-2xl p-6 lg:p-7 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-black/40 transition-colors cursor-pointer"
                         @click="window.location.href='{{ url('/preview') }}'">
                        <div class="space-y-2 max-w-3xl">
                            <div class="flex flex-wrap items-center gap-2 text-[12px]">
                                <span class="font-mono text-black/45">RPT-2026-002</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="text-black/55 font-medium">03 Okt 2026 &bull; 13:30 WIB</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-transparent text-gray-600 border border-[#d9d9d9]">
                                    Selesai
                                </span>
                            </div>

                            <h4 class="text-[20px] font-extrabold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                                Diskusi Alur Pengguna & Uji Coba Tampilan Baru
                            </h4>

                            <p class="text-[14px] text-black/60 line-clamp-1">
                                Penyelenggara: Tim Desain &bull; Google Meet &bull; 5 Orang Hadir
                            </p>
                        </div>

                        <div class="flex items-center space-x-3 shrink-0">
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                                Pratinjau
                            </a>
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white text-[13px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                                Ekspor PDF
                            </a>
                        </div>
                    </div>

                    <!-- Meeting Row 3 -->
                    <div class="bg-white border border-[#d9d9d9]/70 rounded-2xl p-6 lg:p-7 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-black/40 transition-colors cursor-pointer"
                         @click="window.location.href='{{ url('/preview') }}'">
                        <div class="space-y-2 max-w-3xl">
                            <div class="flex flex-wrap items-center gap-2 text-[12px]">
                                <span class="font-mono text-black/45">RPT-2026-001</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="text-black/55 font-medium">28 Sep 2026 &bull; 10:00 WIB</span>
                                <span class="text-black/30">&bull;</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/60">
                                    Perlu Cek
                                </span>
                            </div>

                            <h4 class="text-[20px] font-extrabold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                                Review Mingguan & Pembagian Prioritas Tugas
                            </h4>

                            <p class="text-[14px] text-black/60 line-clamp-1">
                                Penyelenggara: Tim Pengembang &bull; Ruang Diskusi &bull; 6 Orang Hadir
                            </p>
                        </div>

                        <div class="flex items-center space-x-3 shrink-0">
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                                Pratinjau
                            </a>
                            <a href="{{ url('/preview') }}" class="px-5 py-2.5 rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white text-[13px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
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
