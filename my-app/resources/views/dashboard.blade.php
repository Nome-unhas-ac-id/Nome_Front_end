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
                <div class="animate-fade-in-up-delay">
                    <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-2.5 bg-[#ff5347] hover:bg-[#e0453a] text-white rounded-full px-8 py-4 text-[15px] font-bold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95 shadow-none">
                        <span>Mulai Rapat Sekarang</span>
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
                    <!-- [HERO SVG SLOT 1: TOP FLOATING CARD] -->
                    <!-- ID: #hero-illustration-top-card -->
                    <!-- Paste your exported SVG directly here or replace with <img> -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-top-card" 
                         class="absolute top-2 right-6 sm:right-16 z-20 w-44 sm:w-52 bg-white border border-black rounded-2xl p-3 shadow-none hover:rotate-1 transition-transform">
                        <div class="text-[10px] text-black/40 border-b border-[#d9d9d9]/60 pb-1 mb-2 flex items-center justify-between">
                            <span>#hero-illustration-top-card</span>
                            <span class="w-2 h-2 rounded-full bg-[#ff5347]"></span>
                        </div>
                        <img src="/images/avatar_note.png" alt="Notion Character" class="w-full h-28 sm:h-32 object-contain mx-auto">
                    </div>

                    <!-- ======================================================== -->
                    <!-- [HERO SVG SLOT 2: RIGHT COLLABORATION CARD] -->
                    <!-- ID: #hero-illustration-right-card -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-right-card" 
                         class="absolute top-24 sm:top-24 -right-2 sm:right-2 z-30 w-52 sm:w-60 bg-white border border-black rounded-2xl p-3 shadow-none hover:-rotate-1 transition-transform">
                        <div class="text-[10px] text-black/40 border-b border-[#d9d9d9]/60 pb-1 mb-2 flex items-center justify-between">
                            <span>#hero-illustration-right-card</span>
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        </div>
                        <img src="/images/recording_bot.svg" alt="Recording Bot" class="w-full h-32 sm:h-36 object-contain mx-auto">
                    </div>

                    <!-- ======================================================== -->
                    <!-- [HERO SVG SLOT 3: MAIN CENTRAL SOUNDWAVE CHARACTER] -->
                    <!-- ID: #hero-illustration-main -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-main" 
                         class="relative z-20 w-72 sm:w-96 bg-white border border-black rounded-3xl p-5 shadow-none mt-16 sm:mt-20">
                        <div class="text-[10px] text-black/40 border-b border-[#d9d9d9]/60 pb-1.5 mb-3 flex items-center justify-between">
                            <span>#hero-illustration-main (Pusat Ilustrasi)</span>
                            <span class="w-2 h-2 rounded-full bg-black"></span>
                        </div>
                        <img src="/images/soundwave_bot.svg" alt="Soundwave Bot" class="w-full h-48 sm:h-56 object-contain mx-auto">
                    </div>

                    <!-- ======================================================== -->
                    <!-- [HERO SVG SLOT 5: FLOATING AI ACCENTS] -->
                    <!-- ID: #hero-illustration-floating -->
                    <!-- ======================================================== -->
                    <div id="hero-illustration-floating" class="absolute top-4 left-6 z-10 w-24 h-24 pointer-events-none opacity-85">
                        <img src="/images/ai-bubble.svg" alt="AI Bubble Accent" class="w-full h-full object-contain">
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
</div>
@endsection
