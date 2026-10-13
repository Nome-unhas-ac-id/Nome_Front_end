@extends('layouts.app')

@section('content')
<!-- ======================================================== -->
<!-- 1. LOCKED STATE (UNAUTHENTICATED): x-show="!isLoggedIn" -->
<!-- ======================================================== -->
<div x-show="!isLoggedIn" x-cloak class="max-w-xl mx-auto py-16 sm:py-24 text-center">
    <div class="bg-white border border-[#d9d9d9] rounded-3xl p-10 sm:p-14 space-y-6 shadow-none">
        <div class="w-16 h-16 rounded-2xl bg-[#ff5347]/10 border border-[#ff5347]/20 flex items-center justify-center mx-auto text-[#ff5347]">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>

        <div class="space-y-2">
            <span class="inline-block px-3 py-1 rounded-full bg-[#ff5347]/10 text-[#ff5347] text-[11px] font-bold tracking-wider uppercase">
                Akses Terproteksi
            </span>
            <h2 class="text-[32px] sm:text-[38px] font-black tracking-tighter text-black leading-tight">
                Arsip Memo Terkunci.
            </h2>
            <p class="text-[15px] font-semibold text-black/85">
                Harap masuk untuk mulai mencatat rapat
            </p>
            <p class="text-[13px] text-black/55 max-w-md mx-auto leading-relaxed">
                Seluruh arsip notulensi dan transkripsi suara diamankan dengan enkripsi tim. Silakan masuk untuk mengakses rekaman rapat Anda.
            </p>
        </div>

        <div class="space-y-3 pt-2">
            <button type="button" 
                    @click="showLoginModal = true" 
                    class="w-full bg-[#ff5347] hover:bg-[#e0453a] text-white font-bold text-[14px] rounded-full py-3.5 transition-all duration-300 ease-out hover:-translate-y-0.5 active:scale-95 shadow-none cursor-pointer">
                Buka Pintu Masuk
            </button>
            <div class="flex items-center justify-center gap-3">
                <a href="{{ url('/login') }}" 
                   class="flex-1 bg-white hover:bg-black/[0.04] text-black border border-[#d9d9d9] font-semibold text-[13px] rounded-full py-2.5 transition-all text-center">
                    Masuk ke Akun
                </a>
                <a href="{{ url('/signup') }}" 
                   class="flex-1 bg-white hover:bg-black/[0.04] text-black border border-[#d9d9d9] font-semibold text-[13px] rounded-full py-2.5 transition-all text-center">
                    Daftar Baru
                </a>
            </div>
            <button type="button" 
                    @click="setLoggedIn(true)" 
                    class="text-[12px] font-semibold text-[#ff5347] hover:underline pt-2 cursor-pointer">
                &bull; Simulasi Masuk Instan (Demo Mode) &bull;
            </button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- 2. AUTHENTICATED STATE: x-show="isLoggedIn" -->
<!-- ======================================================== -->
<div x-show="isLoggedIn" x-cloak class="space-y-12 max-w-7xl mx-auto pb-24" 
     x-data="{
        searchQuery: '',
        selectedCategory: 'all',
        viewMode: 'grid',
        memos: [
            {
                id: 'NOME-MEMO-001',
                letterNo: '085/NOT-TIM/2026',
                title: 'Sinkronisasi Target Kuartal & Roadmap Fitur',
                category: 'produk',
                categoryLabel: 'Produk & Rencana',
                date: '06 Okt 2026 &bull; 09:00 WIB',
                location: 'Ruang Rapat Tim',
                leader: 'Pengguna Utama',
                attendeesCount: 8,
                status: 'completed',
                statusLabel: 'Selesai',
                summary: 'Penyelarasan target kuartal dan pembagian prioritas pengerjaan fitur baru untuk seluruh tim.'
            },
            {
                id: 'NOME-MEMO-002',
                letterNo: '079/NOT-TIM/2026',
                title: 'Diskusi Alur Pengguna & Uji Coba Tampilan Baru',
                category: 'desain',
                categoryLabel: 'Desain & Riset',
                date: '03 Okt 2026 &bull; 13:30 WIB',
                location: 'Google Meet',
                leader: 'Tim Desain',
                attendeesCount: 5,
                status: 'completed',
                statusLabel: 'Selesai',
                summary: 'Evaluasi alur pengguna pada dashboard baru dan peningkatan keterbacaan tipografi antarmuka.'
            },
            {
                id: 'NOME-MEMO-003',
                letterNo: '075/NOT-TIM/2026',
                title: 'Review Mingguan & Pembagian Prioritas Tugas',
                category: 'teknis',
                categoryLabel: 'Teknis & Operasional',
                date: '28 Sep 2026 &bull; 10:00 WIB',
                location: 'Ruang Diskusi',
                leader: 'Tim Pengembang',
                attendeesCount: 6,
                status: 'review',
                statusLabel: 'Perlu Cek',
                summary: 'Pemaparan progres mingguan serta alokasi tugas pengembangan untuk integrasi sistem otomatis.'
            },
            {
                id: 'NOME-MEMO-004',
                letterNo: '071/NOT-TIM/2026',
                title: 'Sesi Evaluasi Akhir Sprint & Perayaan Capaian Tim',
                category: 'produk',
                categoryLabel: 'Produk & Rencana',
                date: '20 Sep 2026 &bull; 14:00 WIB',
                location: 'Ruang Serbaguna',
                leader: 'Pengguna Utama',
                attendeesCount: 14,
                status: 'completed',
                statusLabel: 'Selesai',
                summary: 'Penetapan rilis versi terbaru dan apresiasi kinerja tim atas pencapaian target sprint tepat waktu.'
            },
            {
                id: 'NOME-MEMO-005',
                letterNo: '068/NOT-TIM/2026',
                title: 'Brainstorming Ide Fitur & Eksplorasi Desain Interaksi',
                category: 'eksplorasi',
                categoryLabel: 'Eksplorasi Ide',
                date: '14 Sep 2026 &bull; 11:00 WIB',
                location: 'Online Call',
                leader: 'Tim Produk',
                attendeesCount: 7,
                status: 'draft',
                statusLabel: 'Draf',
                summary: 'Pengumpulan ide inovatif untuk meningkatkan kenyamanan pengguna saat merekam percakapan rapat.'
            },
            {
                id: 'NOME-MEMO-006',
                letterNo: '062/NOT-TIM/2026',
                title: 'Rapat Sinkronisasi Layanan Pengguna & Dukungan Teknis',
                category: 'teknis',
                categoryLabel: 'Teknis & Operasional',
                date: '05 Sep 2026 &bull; 09:30 WIB',
                location: 'Ruang Diskusi',
                leader: 'Tim Operasional',
                attendeesCount: 9,
                status: 'completed',
                statusLabel: 'Selesai',
                summary: 'Peningkatan kecepatan respon bantuan pengguna dan pemeliharaan performa sistem.'
            }
        ],
        get filteredMemos() {
            return this.memos.filter(memo => {
                const matchesSearch = memo.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                      memo.letterNo.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                      memo.leader.toLowerCase().includes(this.searchQuery.toLowerCase());
                const matchesCategory = this.selectedCategory === 'all' || memo.category === this.selectedCategory;
                return matchesSearch && matchesCategory;
            });
        }
     }">

    <!-- 1. MACRO-TYPOGRAPHY HEADER (Strictly No Decorative Pill, Generous Whitespace) -->
    <div class="pt-6 border-b border-[#d9d9d9]/60 pb-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-[44px] sm:text-[56px] lg:text-[68px] font-black tracking-tighter text-black leading-tight">
                    Memo.
                </h1>
                <p class="text-[17px] text-black/55 mt-2 max-w-2xl font-normal leading-relaxed">
                    Riwayat seluruh catatan rapat, transkrip diskusi, dan rangkuman tugas kolaborasi yang tersimpan secara terstruktur.
                </p>
            </div>

            <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-2 bg-[#ff5347] hover:bg-[#e0453a] text-white rounded-full px-6 py-3 text-[14px] font-semibold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95 shrink-0 self-start md:self-auto">
                <span>Buat Catatan Baru</span>
            </a>
        </div>
    </div>

    <!-- 2. AIRY FILTER & SEARCH TOOLBAR -->
    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
        <!-- Minimalist Search Input -->
        <div class="relative w-full lg:w-96">
            <input type="text" 
                   x-model="searchQuery"
                   placeholder="Cari agenda, topik bahasan, atau nama pemandu..." 
                   class="w-full bg-white border border-[#d9d9d9] rounded-full px-5 py-3 text-[14px] text-black placeholder-black/40 focus:outline-none focus:border-black transition-colors">
        </div>

        <!-- Category Filters & View Switcher -->
        <div class="flex flex-wrap items-center justify-between lg:justify-end gap-3">
            <div class="flex flex-wrap items-center gap-1.5">
                <button @click="selectedCategory = 'all'" 
                        :class="selectedCategory === 'all' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-4 py-2 rounded-full text-[13px] font-medium transition-all">
                    Semua
                </button>
                <button @click="selectedCategory = 'produk'" 
                        :class="selectedCategory === 'produk' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-4 py-2 rounded-full text-[13px] font-medium transition-all">
                    Produk
                </button>
                <button @click="selectedCategory = 'desain'" 
                        :class="selectedCategory === 'desain' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-4 py-2 rounded-full text-[13px] font-medium transition-all">
                    Desain
                </button>
                <button @click="selectedCategory = 'teknis'" 
                        :class="selectedCategory === 'teknis' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-4 py-2 rounded-full text-[13px] font-medium transition-all">
                    Teknis
                </button>
                <button @click="selectedCategory = 'eksplorasi'" 
                        :class="selectedCategory === 'eksplorasi' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-4 py-2 rounded-full text-[13px] font-medium transition-all">
                    Eksplorasi
                </button>
            </div>

            <!-- View Mode Switcher -->
            <div class="flex items-center p-1 bg-white border border-[#d9d9d9] rounded-full text-[12px] font-medium">
                <button @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-black text-white' : 'text-black/50 hover:text-black'"
                        class="px-3.5 py-1.5 rounded-full transition-colors">
                    Galeri
                </button>
                <button @click="viewMode = 'list'" 
                        :class="viewMode === 'list' ? 'bg-black text-white' : 'text-black/50 hover:text-black'"
                        class="px-3.5 py-1.5 rounded-full transition-colors">
                    Daftar
                </button>
            </div>
        </div>
    </div>

    <!-- 3. GALLERY VIEW (Clean Cards, Clicking Opens Transcript) -->
    <div x-show="viewMode === 'grid' && filteredMemos.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <template x-for="memo in filteredMemos" :key="memo.id">
            <div class="bg-white border border-[#d9d9d9]/70 rounded-3xl p-8 flex flex-col justify-between hover:border-black/40 hover:scale-[1.01] transition-all duration-300 space-y-6 cursor-pointer"
                 @click="window.location.href = '{{ url('/preview') }}'">
                <div class="space-y-4">
                    <!-- Top metadata row -->
                    <div class="flex items-center justify-between text-[12px]">
                        <span class="font-mono text-black/45" x-text="memo.letterNo"></span>
                        <span class="px-2.5 py-1 rounded-md text-xs font-medium border-none"
                              :class="{
                                  'bg-green-100 text-green-800': memo.status === 'completed',
                                  'bg-amber-100 text-amber-800': memo.status === 'review',
                                  'bg-gray-100 text-gray-700': memo.status === 'draft'
                              }" 
                              x-text="memo.statusLabel"></span>
                    </div>

                    <!-- Macro Title -->
                    <h2 class="text-[22px] font-extrabold tracking-tight text-black line-clamp-2 leading-snug hover:text-[#ff5347] transition-colors"
                        x-text="memo.title"></h2>

                    <!-- Narrative summary -->
                    <p class="text-[14px] text-black/60 line-clamp-3 leading-relaxed" x-text="memo.summary"></p>
                </div>

                <!-- Card footer details -->
                <div class="pt-6 border-t border-[#d9d9d9]/60 space-y-4">
                    <div class="flex items-center justify-between text-[12px] text-black/55">
                        <span x-html="memo.date"></span>
                        <span class="font-medium text-black" x-text="memo.attendeesCount + ' Hadir'"></span>
                    </div>

                    <div class="flex items-center space-x-2 pt-1" @click.stop>
                        <a href="{{ url('/preview') }}" class="flex-1 text-center rounded-full border border-[#d9d9d9] font-medium text-[13px] py-2 text-black/80 hover:bg-black hover:text-white transition-all">
                            Buka Transkrip
                        </a>
                        <a href="{{ url('/preview') }}" class="flex-1 text-center rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white font-medium text-[13px] py-2 transition-all">
                            Ekspor PDF
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- 4. AIRY LIST VIEW (Clean Rows, Clicking Opens Transcript) -->
    <div x-show="viewMode === 'list' && filteredMemos.length > 0" class="space-y-4">
        <template x-for="memo in filteredMemos" :key="memo.id">
            <div class="bg-white border border-[#d9d9d9]/70 rounded-2xl p-6 lg:p-7 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-black/40 transition-colors cursor-pointer"
                 @click="window.location.href = '{{ url('/preview') }}'">
                <div class="space-y-1.5 max-w-3xl">
                    <div class="flex items-center space-x-3 text-[12px]">
                        <span class="font-mono text-black/45" x-text="memo.letterNo"></span>
                        <span class="w-1 h-1 rounded-full bg-black/20"></span>
                        <span class="text-black/50" x-html="memo.date"></span>
                        <span class="w-1 h-1 rounded-full bg-black/20"></span>
                        <span class="px-2.5 py-1 rounded-md text-xs font-medium border-none"
                              :class="{
                                  'bg-green-100 text-green-800': memo.status === 'completed',
                                  'bg-amber-100 text-amber-800': memo.status === 'review',
                                  'bg-gray-100 text-gray-700': memo.status === 'draft'
                              }" 
                              x-text="memo.statusLabel"></span>
                    </div>
                    <h2 class="text-[20px] font-bold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug"
                        x-text="memo.title"></h2>
                    <p class="text-[13px] text-black/60 truncate" x-text="memo.summary"></p>
                </div>

                <div class="flex items-center space-x-3 shrink-0" @click.stop>
                    <a href="{{ url('/preview') }}" class="px-5 py-2 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-all">
                        Transkrip
                    </a>
                    <a href="{{ url('/preview') }}" class="px-5 py-2 rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white text-[13px] font-medium transition-all">
                        Ekspor
                    </a>
                </div>
            </div>
        </template>
    </div>

    <!-- 5. ELEGANT EMPTY STATE: BRIEF TEXT & PRIMARY #ff5347 BUTTON "Buat Catatan Baru" (Strict Placeholder Rule) -->
    <div x-show="filteredMemos.length === 0" class="text-center py-24 bg-white border border-[#d9d9d9]/70 rounded-3xl p-12 space-y-5 max-w-lg mx-auto">
        <!-- Hand-drawn illustration for empty state -->
        <div class="w-28 h-24 mx-auto flex items-center justify-center">
            <img src="/images/whisper_bot.svg" alt="Belum Ada Catatan" class="w-full h-full object-contain">
        </div>
        <div class="space-y-1">
            <h3 class="text-[20px] font-bold tracking-tight text-black">Belum Ada Catatan Rapat</h3>
            <p class="text-[14px] text-black/55 max-w-sm mx-auto">Mulai rapat baru untuk merekam pembicaraan dan menghasilkan notulensi otomatis.</p>
        </div>
        <div class="pt-2">
            <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-2 px-6 py-3 rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white text-[14px] font-semibold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95">
                <span>Buat Catatan Baru</span>
            </a>
        </div>
    </div>
</div>
@endsection
