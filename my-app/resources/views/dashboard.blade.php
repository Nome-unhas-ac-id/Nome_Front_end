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
                <div class="space-y-2 sm:space-y-2.5">
                    <!-- Very large, bold headline with thick yellow underline accent -->
                    <h1 class="text-[44px] sm:text-[56px] lg:text-[64px] font-black tracking-tighter text-black leading-[1.05] animate-fade-in-up">
                        1,090 Rapat Dirangkum <span class="relative inline-block text-black">Tanpa Ribet.<span class="absolute left-0 bottom-1 sm:bottom-2 w-full h-3 sm:h-3.5 bg-[#FFD027] -z-10 rounded-xs"></span></span>
                    </h1>

                    <!-- Subheadline in muted gray (text-gray-500) -->
                    <p class="text-[17px] sm:text-[19px] text-gray-500 font-normal leading-relaxed max-w-lg animate-fade-in-up-delay">
                        Rekam obrolan, biarkan sistem yang menulis catatan dan kesimpulannya untukmu.
                    </p>
                </div>

                <!-- CTA Button (Secondary Color #ff5347, rounded-full, white text) -->
                <div class="animate-fade-in-up-delay flex flex-wrap items-center gap-3.5">
                    <button type="button" 
                            @click="isLoggedIn ? window.location.href='{{ url('/add-memo') }}' : showLoginModal = true"
                            class="inline-flex items-center space-x-2.5 bg-[#ff5347] hover:bg-[#e0453a] text-white rounded-full px-8 py-4 text-[15px] font-bold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95 shadow-none cursor-pointer">
                        <span x-text="isLoggedIn ? 'Mulai Rapat Sekarang' : 'Coba Sekarang Gratis'">Mulai Rapat Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>

                    <!-- Unauthenticated secondary: Scroll to Cara Kerja -->
                    <a x-show="!isLoggedIn" href="#cara-kerja" 
                       class="inline-flex items-center space-x-2 bg-white hover:bg-black/[0.04] text-black border border-[#d9d9d9] rounded-full px-6 py-4 text-[15px] font-semibold transition-all">
                        <span>Pelajari Cara Kerja</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    </a>

                    <!-- Authenticated secondary: Buka Arsip Memo -->
                    <a x-show="isLoggedIn" href="{{ url('/memo') }}" 
                       class="inline-flex items-center space-x-2 bg-white hover:bg-black/[0.04] text-black border border-[#d9d9d9] rounded-full px-6 py-4 text-[15px] font-semibold transition-all">
                        <span>Buka Arsip Memo</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Launch Checklist / Feature Highlight (Matches Reference Image) -->
                <div class="pt-8 border-t border-[#d9d9d9]/60 flex items-center gap-5 hover:scale-[1.02] transition-transform duration-300">
                    <!-- Universal Icon Placeholder -->
                    <div id="hero-illustration-bottom-left" class="w-12 h-12 rounded-full bg-[#ff5347]/10 border border-[#ff5347]/30 flex items-center justify-center p-2 shrink-0">
                        <img src="/images/soundwave_blob.svg" alt="Audio Wave" class="w-full h-full object-contain">
                    </div>

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
                    <!-- [HERO SVG SLOT 1: TOP-LEFT FLOATING CARD] -->
                    <!-- ID: #hero-illustration-top-card -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-top-card" 
                         class="absolute -top-3 sm:top-1 left-2 sm:left-4 z-20 w-44 sm:w-52 bg-white border border-black rounded-2xl p-3 shadow-none hover:-rotate-1 transition-transform">
                        <div class="text-[10px] text-black/40 border-b border-[#d9d9d9]/60 pb-1 mb-2 flex items-center justify-between">
                            <span>#hero-illustration-top-card</span>
                            <span class="w-2 h-2 rounded-full bg-[#ff5347]"></span>
                        </div>
                        <img src="/images/snake_bot.svg" alt="Snake Bot" class="w-full h-24 sm:h-28 object-contain mx-auto">
                    </div>

                    <!-- ======================================================== -->
                    <!-- [HERO SVG SLOT 2: RIGHT COLLABORATION CARD] -->
                    <!-- ID: #hero-illustration-right-card -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-right-card" 
                         class="absolute top-8 sm:top-10 -right-2 sm:right-2 z-20 w-48 sm:w-56 bg-white border border-black rounded-2xl p-3 shadow-none hover:rotate-1 transition-transform">
                        <div class="text-[10px] text-black/40 border-b border-[#d9d9d9]/60 pb-1 mb-2 flex items-center justify-between">
                            <span>#hero-illustration-right-card</span>
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        </div>
                        <img src="/images/recording_bot.svg" alt="Recording Bot" class="w-full h-28 sm:h-32 object-contain mx-auto">
                    </div>

                    <!-- ======================================================== -->
                    <!-- [HERO SVG SLOT 3: MAIN CENTRAL SOUNDWAVE CHARACTER] -->
                    <!-- ID: #hero-illustration-main -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-main" 
                         class="relative z-30 w-72 sm:w-88 bg-white border border-black rounded-3xl p-5 shadow-none mt-20 sm:mt-24">
                        <div class="text-[10px] text-black/40 border-b border-[#d9d9d9]/60 pb-1.5 mb-3 flex items-center justify-between">
                            <span>#hero-illustration-main (Pusat Ilustrasi)</span>
                            <span class="w-2 h-2 rounded-full bg-black"></span>
                        </div>
                        <img src="/images/soundwave_bot.svg" alt="Soundwave Bot" class="w-full h-44 sm:h-52 object-contain mx-auto">
                    </div>

                    <!-- ======================================================== -->
                    <!-- [HERO SVG SLOT 5: FLOATING AI ACCENTS] -->
                    <!-- ID: #hero-illustration-floating -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-floating" class="absolute -top-3 right-16 sm:right-24 z-40 w-16 h-16 sm:w-20 sm:h-20 pointer-events-none opacity-90">
                        <img src="/images/ai-bubble.svg" alt="AI Bubble Accent" class="w-full h-full object-contain">
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- ======================================================== -->
    <!-- 3. AUTHENTICATED LOWER DASHBOARD UI (WARM CANVAS #F8F7F3) -->
    <!-- Displayed when isLoggedIn === true -->
    <!-- ======================================================== -->
    <div x-show="isLoggedIn" x-cloak class="bg-[#F8F7F3] px-6 sm:px-10 lg:px-16 py-14 sm:py-20 space-y-16">
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
                        <span class="text-sm text-gray-500 font-medium">4 Kategori</span>
                    </div>
                    <a href="{{ url('/memo') }}" class="text-[13px] font-medium text-black/60 hover:text-[#ff5347] transition-colors">
                        Kelola Semua Folder &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- Folder 1: Lavender Pastel -->
                    <a href="{{ url('/memo') }}" class="group flex flex-col items-center text-center justify-between bg-[#F0EEFF] rounded-3xl p-6 sm:p-8 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-0.5">
                        <div class="w-full flex flex-col items-center text-center">
                            <div class="w-32 h-24 mx-auto mb-6 flex items-center justify-center">
                                <img src="/images/note_bot.svg" alt="Diskusi Tim Mingguan" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-black transition-colors">
                                Diskusi Tim Mingguan
                            </h4>
                            <p class="text-[13px] text-black/55 mt-1.5 leading-relaxed">
                                Update progres dan koordinasi kerja
                            </p>
                        </div>
                        <div class="w-full pt-4 mt-6 border-t border-indigo-950/5 flex items-center justify-between text-[12px] text-black/50">
                            <span>12 Catatan</span>
                            <span>Diperbarui kemarin</span>
                        </div>
                    </a>

                    <!-- Folder 2: Sky Blue Pastel -->
                    <a href="{{ url('/memo') }}" class="group flex flex-col items-center text-center justify-between bg-[#EAF4FE] rounded-3xl p-6 sm:p-8 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-0.5">
                        <div class="w-full flex flex-col items-center text-center">
                            <div class="w-32 h-24 mx-auto mb-6 flex items-center justify-center">
                                <img src="/images/equalizer_bot.svg" alt="Rencana & Desain Produk" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-black transition-colors">
                                Rencana & Desain Produk
                            </h4>
                            <p class="text-[13px] text-black/55 mt-1.5 leading-relaxed">
                                Roadmap fitur dan riset pengguna
                            </p>
                        </div>
                        <div class="w-full pt-4 mt-6 border-t border-blue-950/5 flex items-center justify-between text-[12px] text-black/50">
                            <span>8 Catatan</span>
                            <span>Diperbarui 3 hari lalu</span>
                        </div>
                    </a>

                    <!-- Folder 3: Warm Peach / Cream Pastel -->
                    <a href="{{ url('/memo') }}" class="group flex flex-col items-center text-center justify-between bg-[#FEF6EC] rounded-3xl p-6 sm:p-8 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-0.5">
                        <div class="w-full flex flex-col items-center text-center">
                            <div class="w-32 h-24 mx-auto mb-6 flex items-center justify-center">
                                <img src="/images/whisper_bot.svg" alt="Evaluasi & Laporan" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-black transition-colors">
                                Evaluasi & Laporan
                            </h4>
                            <p class="text-[13px] text-black/55 mt-1.5 leading-relaxed">
                                Review capaian dan kendala tim
                            </p>
                        </div>
                        <div class="w-full pt-4 mt-6 border-t border-amber-950/5 flex items-center justify-between text-[12px] text-black/50">
                            <span>5 Catatan</span>
                            <span>Diperbarui 1 minggu lalu</span>
                        </div>
                    </a>

                    <!-- Folder 4: Minimal Neutral Gray -->
                    <a href="{{ url('/memo') }}" class="group flex flex-col items-center text-center justify-between bg-[#F4F4F3] rounded-3xl p-6 sm:p-8 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-0.5">
                        <div class="w-full flex flex-col items-center text-center">
                            <div class="w-32 h-24 mx-auto mb-6 flex items-center justify-center">
                                <img src="/images/sonic-orb.svg" alt="Eksplorasi Ide Baru" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <h4 class="text-[18px] font-bold text-black tracking-tight group-hover:text-black transition-colors">
                                Eksplorasi Ide Baru
                            </h4>
                            <p class="text-[13px] text-black/55 mt-1.5 leading-relaxed">
                                Brainstorming gagasan dan eksperimen
                            </p>
                        </div>
                        <div class="w-full pt-4 mt-6 border-t border-black/5 flex items-center justify-between text-[12px] text-black/50">
                            <span>3 Catatan</span>
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
                        <div class="text-[11px] font-semibold uppercase tracking-wider text-white/70">
                            Pencatatan Cepat
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
                        <img src="/images/spirit_wave.svg" alt="Transkrip Otomatis" class="w-48 h-32 object-contain mx-auto group-hover:scale-105 transition-transform duration-300">
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
                                <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 border-none">
                                    Selesai
                                </span>
                            </div>

                            <h4 class="text-[20px] font-extrabold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                                Sinkronisasi Target & Roadmap Proyek
                            </h4>

                            <p class="text-[14px] text-black/60 line-clamp-1">
                                Penyelenggara: Tim Kolaborasi &bull; Ruang Diskusi &bull; 8 Orang Hadir
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
                                <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 border-none">
                                    Selesai
                                </span>
                            </div>

                            <h4 class="text-[20px] font-extrabold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                                Diskusi Alur Pengguna & Uji Coba Tampilan Baru
                            </h4>

                            <p class="text-[14px] text-black/60 line-clamp-1">
                                Penyelenggara: Tim Kreatif &bull; Google Meet &bull; 5 Orang Hadir
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
                                <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-amber-100 text-amber-800 border-none">
                                    Perlu Cek
                                </span>
                            </div>

                            <h4 class="text-[20px] font-extrabold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug">
                                Review Mingguan & Sesi Brainstorming
                            </h4>

                            <p class="text-[14px] text-black/60 line-clamp-1">
                                Penyelenggara: Komunitas & Freelancer &bull; Ruang Diskusi &bull; 6 Orang Hadir
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

    <!-- ======================================================== -->
    <!-- 4. UNAUTHENTICATED PUBLIC LANDING PAGE SECTIONS -->
    <!-- Displayed when isLoggedIn === false -->
    <!-- ======================================================== -->
    <div x-show="!isLoggedIn" x-cloak class="bg-[#F8F7F3] px-6 sm:px-10 lg:px-16 py-14 sm:py-24 space-y-24 sm:space-y-32">
        <div class="max-w-7xl mx-auto space-y-24 sm:space-y-32">

            <!-- ======================================================== -->
            <!-- SECTION 1: HOW IT WORKS (CARA KERJA) -->
            <!-- Minimalist 3-step grid with SVG placeholders and short text -->
            <!-- ======================================================== -->
            <section id="cara-kerja" class="space-y-12 sm:space-y-16 scroll-mt-28">
                <!-- Section Header -->
                <div class="space-y-4 max-w-3xl">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-white border border-[#d9d9d9] text-[12px] font-semibold text-black tracking-wide uppercase">
                        <span class="w-2 h-2 rounded-full bg-[#ff5347]"></span>
                        <span>Cara Kerja</span>
                    </div>

                    <h2 class="text-[38px] sm:text-[50px] lg:text-[58px] font-black tracking-tighter text-black leading-[1.05]">
                        Notulensi Rapi dalam Tiga Langkah Ringkas.
                    </h2>

                    <p class="text-[17px] text-black/60 font-normal leading-relaxed">
                        Tanpa repot mencatat cepat saat rapat berlangsung. Nome mendengar, membedakan setiap pembicara, dan merangkum poin krusial secara otomatis.
                    </p>
                </div>

                <!-- 3-Step Minimalist Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 items-stretch">
                    <!-- Step 01 -->
                    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-7 sm:p-8 flex flex-col justify-between space-y-6 hover:-translate-y-1 transition-all duration-300">
                        <div class="space-y-5">
                            <div class="flex items-center justify-between border-b border-[#d9d9d9]/60 pb-3">
                                <span class="text-xs font-mono font-bold text-black/40">LANGKAH 01</span>
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-[#F0EEFF] text-[#5b45d9]">Input Suara</span>
                            </div>

                            <!-- SVG Placeholder Card -->
                            <div class="w-full h-40 bg-[#F8F7F3] border border-[#d9d9d9]/70 rounded-2xl flex items-center justify-center p-4 relative overflow-hidden group">
                                <div class="absolute inset-0 border border-dashed border-black/10 rounded-2xl m-2 pointer-events-none"></div>
                                <img src="/images/recording_bot.svg" alt="Rekam Suara" class="h-28 w-auto object-contain transition-transform group-hover:scale-105 duration-300">
                            </div>

                            <h3 class="text-[20px] font-extrabold tracking-tight text-black">
                                1. Rekam atau Unggah Audio
                            </h3>
                            <p class="text-[14px] text-black/60 leading-relaxed">
                                Mulai rekaman langsung lewat mikrofon perangkat Anda atau unggah file rekaman format MP3, WAV, atau M4A tanpa konfigurasi rumit.
                            </p>
                        </div>

                        <div class="pt-4 border-t border-[#d9d9d9]/50 flex items-center text-[12px] font-medium text-black/50">
                            <span>Mendukung hingga durasi 3 jam / sesi</span>
                        </div>
                    </div>

                    <!-- Step 02 -->
                    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-7 sm:p-8 flex flex-col justify-between space-y-6 hover:-translate-y-1 transition-all duration-300">
                        <div class="space-y-5">
                            <div class="flex items-center justify-between border-b border-[#d9d9d9]/60 pb-3">
                                <span class="text-xs font-mono font-bold text-black/40">LANGKAH 02</span>
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-[#E5F7FF] text-[#0072b2]">AI Diarisasi</span>
                            </div>

                            <!-- SVG Placeholder Card -->
                            <div class="w-full h-40 bg-[#F8F7F3] border border-[#d9d9d9]/70 rounded-2xl flex items-center justify-center p-4 relative overflow-hidden group">
                                <div class="absolute inset-0 border border-dashed border-black/10 rounded-2xl m-2 pointer-events-none"></div>
                                <img src="/images/equalizer_bot.svg" alt="Diarisasi AI" class="h-28 w-auto object-contain transition-transform group-hover:scale-105 duration-300">
                            </div>

                            <h3 class="text-[20px] font-extrabold tracking-tight text-black">
                                2. AI Bedakan Tiap Pembicara
                            </h3>
                            <p class="text-[14px] text-black/60 leading-relaxed">
                                Model kecerdasan buatan mengenali frekuensi suara dan otomatis memisahkan siapa yang berbicara dengan penanda waktu presisi.
                            </p>
                        </div>

                        <div class="pt-4 border-t border-[#d9d9d9]/50 flex items-center text-[12px] font-medium text-black/50">
                            <span>Akurasi diarisasi hingga 15 peserta</span>
                        </div>
                    </div>

                    <!-- Step 03 -->
                    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-7 sm:p-8 flex flex-col justify-between space-y-6 hover:-translate-y-1 transition-all duration-300">
                        <div class="space-y-5">
                            <div class="flex items-center justify-between border-b border-[#d9d9d9]/60 pb-3">
                                <span class="text-xs font-mono font-bold text-black/40">LANGKAH 03</span>
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-[#E8F8EE] text-[#1b7a42]">Hasil Notulensi</span>
                            </div>

                            <!-- SVG Placeholder Card -->
                            <div class="w-full h-40 bg-[#F8F7F3] border border-[#d9d9d9]/70 rounded-2xl flex items-center justify-center p-4 relative overflow-hidden group">
                                <div class="absolute inset-0 border border-dashed border-black/10 rounded-2xl m-2 pointer-events-none"></div>
                                <img src="/images/note_bot.svg" alt="Rangkuman Notulensi" class="h-28 w-auto object-contain transition-transform group-hover:scale-105 duration-300">
                            </div>

                            <h3 class="text-[20px] font-extrabold tracking-tight text-black">
                                3. Rangkuman & Action Items Rapi
                            </h3>
                            <p class="text-[14px] text-black/60 leading-relaxed">
                                Dapatkan ringkasan eksekutif, butir keputusan mufakat, serta daftar penanggung jawab tugas yang siap diekspor ke PDF kop resmi.
                            </p>
                        </div>

                        <div class="pt-4 border-t border-[#d9d9d9]/50 flex items-center text-[12px] font-medium text-black/50">
                            <span>Format ekspor PDF, Word, & Markdown</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======================================================== -->
            <!-- SECTION 2: FEATURE HIGHLIGHTS (FITUR) -->
            <!-- ======================================================== -->
            <section id="fitur" class="space-y-12 sm:space-y-16 scroll-mt-28">
                <!-- Section Header -->
                <div class="space-y-4 max-w-3xl">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-white border border-[#d9d9d9] text-[12px] font-semibold text-black tracking-wide uppercase">
                        <span class="w-2 h-2 rounded-full bg-[#ff5347]"></span>
                        <span>Fitur Unggulan</span>
                    </div>

                    <h2 class="text-[38px] sm:text-[50px] lg:text-[58px] font-black tracking-tighter text-black leading-[1.05]">
                        Kecerdasan Buatan untuk Diskusi Serius.
                    </h2>

                    <p class="text-[17px] text-black/60 font-normal leading-relaxed">
                        Dirancang khusus untuk mendukung ritme kerja akademis dan organisasi yang memerlukan kepastian arsip dan kecepatan tindak lanjut.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-8 space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#ff5347]/10 flex items-center justify-center text-[#ff5347]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path></svg>
                        </div>
                        <h3 class="text-[19px] font-extrabold text-black tracking-tight">Konteks Bahasa Indonesia Alami</h3>
                        <p class="text-[14px] text-black/60 leading-relaxed">
                            Model AI dilatih mengenali istilah teknis, singkatan kampus, dan percampuran istilah lokal dalam suasana rapat formal maupun diskusi santai.
                        </p>
                    </div>

                    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-8 space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#ff5347]/10 flex items-center justify-center text-[#ff5347]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-[19px] font-extrabold text-black tracking-tight">Diarisasi Multi-Speaker Akurat</h3>
                        <p class="text-[14px] text-black/60 leading-relaxed">
                            Secara otomatis memberi label pembicara secara mandiri, memungkinkan Anda melacak siapa yang menyampaikan usulan tanpa ragu.
                        </p>
                    </div>

                    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-8 space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#ff5347]/10 flex items-center justify-center text-[#ff5347]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-[19px] font-extrabold text-black tracking-tight">Format Kop Surat Resmi Instan</h3>
                        <p class="text-[14px] text-black/60 leading-relaxed">
                            Ekspor langsung dengan format standar institusi, dilengkapi tanggal, nomor berkas, daftar peserta hadir, dan butir keputusan mufakat.
                        </p>
                    </div>
                </div>
            </section>

            <!-- ======================================================== -->
            <!-- SECTION 3: PRICING (PAKET) -->
            <!-- Two minimalist pricing cards (Gratis vs. Pro) with hairline borders, no shadows -->
            <!-- ======================================================== -->
            <section id="harga" class="space-y-12 sm:space-y-16 scroll-mt-28">
                <!-- Section Header -->
                <div class="text-center space-y-4 max-w-2xl mx-auto">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-white border border-[#d9d9d9] text-[12px] font-semibold text-black tracking-wide uppercase">
                        <span class="w-2 h-2 rounded-full bg-[#ff5347]"></span>
                        <span>Pilihan Paket</span>
                    </div>

                    <h2 class="text-[38px] sm:text-[50px] lg:text-[58px] font-black tracking-tighter text-black leading-[1.05]">
                        Sederhana & Transparan.
                    </h2>

                    <p class="text-[17px] text-black/60 font-normal leading-relaxed">
                        Mulai gratis tanpa kartu kredit. Tingkatkan kapasitas saat tim Anda membutuhkan frekuensi rapat tak terbatas.
                    </p>
                </div>

                <!-- Two Minimalist Pricing Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto items-stretch">
                    <!-- Card 1: Gratis (Starter) -->
                    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-8 sm:p-10 flex flex-col justify-between space-y-8 relative hover:-translate-y-0.5 transition-all">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <h3 class="text-[24px] font-black text-black tracking-tight">Gratis</h3>
                                <p class="text-[14px] text-black/55 leading-relaxed">
                                    Cocok untuk mahasiswa, individu, atau rapat tim kecil berkala.
                                </p>
                            </div>

                            <div class="flex items-baseline space-x-1.5 py-4 border-y border-[#d9d9d9]/60">
                                <span class="text-[44px] font-black tracking-tight text-black leading-none">Rp 0</span>
                                <span class="text-sm text-black/50 font-medium">/ selamanya</span>
                            </div>

                            <!-- Feature List -->
                            <ul class="space-y-3.5 text-[14px] text-black/75">
                                <li class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-black shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span><strong>5 sesi rapat</strong> per bulan (maks. 45 menit/sesi)</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-black shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Diarisasi dasar (hingga 2 pembicara)</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-black shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Rangkuman intisari & butir kesimpulan AI</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-black shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Ekspor format Teks (.txt) & Markdown</span>
                                </li>
                                <li class="flex items-start space-x-3 text-black/45">
                                    <svg class="w-5 h-5 text-black/35 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Penyimpanan arsip 30 hari</span>
                                </li>
                            </ul>
                        </div>

                        <div class="pt-4">
                            <button type="button" 
                                    @click="showLoginModal = true" 
                                    class="w-full bg-[#F8F7F3] hover:bg-black hover:text-white text-black border border-black rounded-full py-4 text-[14px] font-bold transition-all duration-300 ease-out hover:-translate-y-0.5 active:scale-95 cursor-pointer">
                                Mulai Sekarang Gratis
                            </button>
                        </div>
                    </div>

                    <!-- Card 2: Pro (Unlimited) -->
                    <div class="bg-white border-2 border-black rounded-3xl p-8 sm:p-10 flex flex-col justify-between space-y-8 relative hover:-translate-y-0.5 transition-all">
                        <!-- Populer Badge -->
                        <div class="absolute -top-3.5 right-8 bg-[#ff5347] text-white text-[11px] font-extrabold px-3.5 py-1 rounded-full uppercase tracking-wider">
                            Paling Populer
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <h3 class="text-[24px] font-black text-black tracking-tight">Pro Unlimited</h3>
                                <p class="text-[14px] text-black/55 leading-relaxed">
                                    Untuk pimpinan tim, dosen, sekretariat, dan divisi profesional.
                                </p>
                            </div>

                            <div class="flex items-baseline space-x-1.5 py-4 border-y border-[#d9d9d9]/60">
                                <span class="text-[44px] font-black tracking-tight text-black leading-none">Rp 49.000</span>
                                <span class="text-sm text-black/50 font-medium">/ bulan</span>
                            </div>

                            <!-- Feature List -->
                            <ul class="space-y-3.5 text-[14px] text-black/85">
                                <li class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-[#ff5347] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span><strong>Sesi rapat tanpa batas</strong> (tanpa limit durasi)</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-[#ff5347] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Diarisasi cerdas hingga <strong>15 pembicara</strong></span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-[#ff5347] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Ekspor resmi kop surat (PDF, Word, Markdown)</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-[#ff5347] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Penyimpanan arsip permanen & pencarian semantik</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-[#ff5347] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Prioritas pemrosesan server kilat</span>
                                </li>
                            </ul>
                        </div>

                        <div class="pt-4">
                            <button type="button" 
                                    @click="showLoginModal = true" 
                                    class="w-full bg-[#ff5347] hover:bg-[#e0453a] text-white rounded-full py-4 text-[14px] font-bold transition-all duration-300 ease-out hover:-translate-y-0.5 active:scale-95 cursor-pointer">
                                Coba Pro 14 Hari Gratis
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======================================================== -->
            <!-- SECTION 4: TESTIMONIALS (TESTIMONI) -->
            <!-- ======================================================== -->
            <section id="testimoni" class="space-y-12 sm:space-y-16 scroll-mt-28">
                <div class="space-y-4 max-w-3xl">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-white border border-[#d9d9d9] text-[12px] font-semibold text-black tracking-wide uppercase">
                        <span class="w-2 h-2 rounded-full bg-[#ff5347]"></span>
                        <span>Testimoni Pengguna</span>
                    </div>

                    <h2 class="text-[38px] sm:text-[50px] lg:text-[58px] font-black tracking-tighter text-black leading-[1.05]">
                        Dipercaya untuk Diskusi yang Menghasilkan Keputusan.
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-8 space-y-6 flex flex-col justify-between">
                        <p class="text-[15px] text-black/75 leading-relaxed italic">
                            &ldquo;Rapat koordinasi kurikulum fakultas selama 2 jam selesai terangkum rapi hanya dalam 3 menit. Sangat menghemat waktu tim sekretariat kami.&rdquo;
                        </p>
                        <div class="pt-4 border-t border-[#d9d9d9]/60 flex items-center space-x-3.5">
                            <div class="w-10 h-10 rounded-full bg-[#ff5347]/10 flex items-center justify-center font-bold text-sm text-[#ff5347]">
                                DR
                            </div>
                            <div>
                                <h4 class="text-[14px] font-bold text-black">Dr. Ir. Fachruddin, M.T.</h4>
                                <p class="text-[12px] text-black/50">Dosen & Tim Penjaminan Mutu</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-8 space-y-6 flex flex-col justify-between">
                        <p class="text-[15px] text-black/75 leading-relaxed italic">
                            &ldquo;Diarisasi suaranya luar biasa akurat. Siapa yang mengusulkan fitur dan siapa yang menyetujui langsung tercatat jelas tanpa ada yang terlewat.&rdquo;
                        </p>
                        <div class="pt-4 border-t border-[#d9d9d9]/60 flex items-center space-x-3.5">
                            <div class="w-10 h-10 rounded-full bg-[#ff5347]/10 flex items-center justify-center font-bold text-sm text-[#ff5347]">
                                AL
                            </div>
                            <div>
                                <h4 class="text-[14px] font-bold text-black">Annisa Larasati</h4>
                                <p class="text-[12px] text-black/50">Product Lead & Researcher</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-8 space-y-6 flex flex-col justify-between">
                        <p class="text-[15px] text-black/75 leading-relaxed italic">
                            &ldquo;Format ekspor notulensinya bersih dan siap dikirim ke dekanat langsung tanpa perlu proses pengetikan ulang berjam-jam.&rdquo;
                        </p>
                        <div class="pt-4 border-t border-[#d9d9d9]/60 flex items-center space-x-3.5">
                            <div class="w-10 h-10 rounded-full bg-[#ff5347]/10 flex items-center justify-center font-bold text-sm text-[#ff5347]">
                                DP
                            </div>
                            <div>
                                <h4 class="text-[14px] font-bold text-black">Dimas Pratama</h4>
                                <p class="text-[12px] text-black/50">Koordinator Notulensi Organisasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======================================================== -->
            <!-- SECTION 5: PUBLIC BOTTOM CTA -->
            <!-- ======================================================== -->
            <section class="bg-white border border-[#d9d9d9] rounded-3xl p-10 sm:p-16 text-center max-w-4xl mx-auto space-y-6">
                <div class="w-12 h-12 rounded-full bg-[#ff5347]/10 border border-[#ff5347]/30 flex items-center justify-center mx-auto text-[#ff5347]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <h3 class="text-[34px] sm:text-[46px] font-black tracking-tighter text-black leading-tight">
                    Mulai Catat Rapat Pertama Anda Sekarang.
                </h3>
                <p class="text-[16px] text-black/60 max-w-lg mx-auto font-normal leading-relaxed">
                    Bergabung bersama ribuan akademisi dan profesional yang menghemat waktu rapat dengan dokumentasi cerdas Nome.
                </p>
                <div class="pt-3 flex flex-col sm:flex-row items-center justify-center gap-3.5">
                    <button type="button" 
                            @click="showLoginModal = true" 
                            class="w-full sm:w-auto bg-[#ff5347] hover:bg-[#e0453a] text-white px-8 py-4 rounded-full font-bold text-[15px] transition-all duration-300 ease-out hover:-translate-y-0.5 active:scale-95 cursor-pointer">
                        Daftar Akun Baru
                    </button>
                    <a href="{{ url('/login') }}" 
                       class="w-full sm:w-auto text-black/75 hover:text-black font-semibold text-[15px] px-6 py-4 transition-colors">
                        Sudah punya akun? Masuk &rarr;
                    </a>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
