@extends('layouts.app')

@section('content')
<div class="space-y-12 max-w-7xl mx-auto" 
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

    <!-- 1. MACRO-TYPOGRAPHY HEADER -->
    <div class="space-y-4 pt-4 border-b border-[#d9d9d9]/60 pb-8">
        <div class="inline-flex items-center space-x-2.5 px-4 py-1.5 rounded-full bg-white border border-[#d9d9d9]/80 text-[12px] font-medium text-black/60">
            <span>Arsip Catatan Rapat</span>
            <span>&bull;</span>
            <span class="text-black font-semibold" x-text="filteredMemos.length + ' Catatan Tersimpan'"></span>
        </div>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-[44px] sm:text-[56px] lg:text-[68px] font-black tracking-tighter text-black leading-[1.05]">
                    Arsip Catatan Rapat.
                </h1>
                <p class="text-[17px] text-black/55 mt-2 max-w-2xl font-normal leading-relaxed">
                    Koleksi lengkap seluruh catatan rapat, transkrip obrolan, dan rangkuman tugas tim yang tersimpan secara terstruktur.
                </p>
            </div>

            <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-2 bg-[#ff5347] hover:bg-[#e0453a] text-white rounded-full px-6 py-3 text-[14px] font-semibold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95 shrink-0 self-start md:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Mulai Rapat Baru</span>
            </a>
        </div>
    </div>

    <!-- 2. AIRY FILTER & SEARCH TOOLBAR (Clean, Minimalist, Rounded-full) -->
    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
        <!-- Minimalist Search Input -->
        <div class="relative w-full lg:w-96">
            <input type="text" 
                   x-model="searchQuery"
                   placeholder="Cari agenda, nomor surat, pimpinan..." 
                   class="w-full bg-white border border-[#d9d9d9] rounded-full pl-11 pr-4 py-3 text-[14px] text-black placeholder-black/40 focus:outline-none focus:border-black transition-colors">
            <svg class="w-4 h-4 text-black/40 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <!-- Category Pill Filters & View Switcher -->
        <div class="flex flex-wrap items-center justify-between lg:justify-end gap-3">
            <div class="flex flex-wrap items-center gap-1.5">
                <button @click="selectedCategory = 'all'" 
                        :class="selectedCategory === 'all' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-4 py-2 rounded-full text-[13px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                    Semua
                </button>
                <button @click="selectedCategory = 'produk'" 
                        :class="selectedCategory === 'produk' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-4 py-2 rounded-full text-[13px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                    Produk
                </button>
                <button @click="selectedCategory = 'desain'" 
                        :class="selectedCategory === 'desain' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-4 py-2 rounded-full text-[13px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                    Desain
                </button>
                <button @click="selectedCategory = 'teknis'" 
                        :class="selectedCategory === 'teknis' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-4 py-2 rounded-full text-[13px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                    Teknis
                </button>
                <button @click="selectedCategory = 'eksplorasi'" 
                        :class="selectedCategory === 'eksplorasi' ? 'bg-black text-white' : 'bg-white text-black/60 border border-[#d9d9d9]/70 hover:text-black'"
                        class="px-4 py-2 rounded-full text-[13px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                    Eksplorasi
                </button>
            </div>

            <!-- View Mode Switcher -->
            <div class="flex items-center p-1 bg-white border border-[#d9d9d9] rounded-full">
                <button @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-black text-white' : 'text-black/50 hover:text-black'"
                        class="p-2 rounded-full transition-colors" title="Galeri Kartu">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </button>
                <button @click="viewMode = 'list'" 
                        :class="viewMode === 'list' ? 'bg-black text-white' : 'text-black/50 hover:text-black'"
                        class="p-2 rounded-full transition-colors" title="Daftar Baris">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- 3. GALLERY VIEW (Wide Cards with Dominant Whitespace & Rounded-3xl) -->
    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <template x-for="memo in filteredMemos" :key="memo.id">
            <div class="bg-white border border-[#d9d9d9]/70 rounded-3xl p-8 flex flex-col justify-between hover:border-black/40 hover:scale-[1.02] transition-all duration-300 space-y-6">
                <div class="space-y-4">
                    <!-- Top metadata row -->
                    <div class="flex items-center justify-between text-[12px]">
                        <span class="font-mono text-black/45" x-text="memo.letterNo"></span>
                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold border"
                              :class="{
                                  'bg-emerald-50 text-emerald-800 border-emerald-200/60': memo.status === 'completed',
                                  'bg-amber-50 text-amber-800 border-amber-200/60': memo.status === 'review',
                                  'bg-gray-100 text-gray-700 border-gray-300/60': memo.status === 'draft'
                              }" 
                              x-text="memo.statusLabel"></span>
                    </div>

                    <!-- Macro Title -->
                    <h2 class="text-[22px] font-extrabold tracking-tight text-black line-clamp-2 leading-snug hover:text-[#ff5347] transition-colors cursor-pointer"
                        @click="window.location.href = '{{ url('/preview') }}'"
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

                    <div class="flex items-center space-x-2 pt-1">
                        <a href="{{ url('/preview') }}" class="flex-1 text-center rounded-full border border-[#d9d9d9] font-medium text-[13px] py-2 text-black/80 hover:bg-black hover:text-white transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                            Buka Catatan
                        </a>
                        <a href="{{ url('/preview') }}" class="flex-1 text-center rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white font-medium text-[13px] py-2 transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                            Ekspor PDF
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- 4. AIRY LIST VIEW (Clean Rows, Rounded-2xl) -->
    <div x-show="viewMode === 'list'" class="space-y-4">
        <template x-for="memo in filteredMemos" :key="memo.id">
            <div class="bg-white border border-[#d9d9d9]/70 rounded-2xl p-6 lg:p-7 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-black/40 transition-colors">
                <div class="space-y-1.5 max-w-3xl">
                    <div class="flex items-center space-x-3 text-[12px]">
                        <span class="font-mono text-black/45" x-text="memo.letterNo"></span>
                        <span class="w-1 h-1 rounded-full bg-black/20"></span>
                        <span class="text-black/50" x-html="memo.date"></span>
                        <span class="w-1 h-1 rounded-full bg-black/20"></span>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold border"
                              :class="{
                                  'bg-emerald-50 text-emerald-800 border-emerald-200/60': memo.status === 'completed',
                                  'bg-amber-50 text-amber-800 border-amber-200/60': memo.status === 'review',
                                  'bg-gray-100 text-gray-700 border-gray-300/60': memo.status === 'draft'
                              }" 
                              x-text="memo.statusLabel"></span>
                    </div>
                    <h2 class="text-[20px] font-bold tracking-tight text-black hover:text-[#ff5347] transition-colors leading-snug cursor-pointer"
                        @click="window.location.href = '{{ url('/preview') }}'"
                        x-text="memo.title"></h2>
                    <p class="text-[13px] text-black/60 truncate" x-text="memo.summary"></p>
                </div>

                <div class="flex items-center space-x-3 shrink-0">
                    <a href="{{ url('/preview') }}" class="px-5 py-2 rounded-full border border-[#d9d9d9] text-[13px] font-medium text-black/80 hover:bg-black hover:text-white transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                        Buka
                    </a>
                    <a href="{{ url('/preview') }}" class="px-5 py-2 rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white text-[13px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
                        Ekspor
                    </a>
                </div>
            </div>
        </template>
    </div>

    <!-- 5. EMPTY STATE WITH HAND-DRAWN DOODLE -->
    <div x-show="filteredMemos.length === 0" class="text-center py-20 bg-white border border-[#d9d9d9]/70 rounded-3xl p-12 space-y-4 max-w-lg mx-auto">
        <svg class="w-32 h-32 text-black/40 mx-auto" viewBox="0 0 100 100" fill="none" stroke="currentColor">
            <circle cx="50" cy="50" r="35" stroke-width="2" stroke-dasharray="4 4"/>
            <path d="M40 45 Q50 35 60 45" stroke-width="2"/>
            <circle cx="42" cy="48" r="2" fill="currentColor"/>
            <circle cx="58" cy="48" r="2" fill="currentColor"/>
            <path d="M43 65 Q50 58 57 65" stroke-width="2"/>
        </svg>
        <h3 class="text-[22px] font-bold tracking-tight text-black">Tidak Ada Catatan Ditemukan</h3>
        <p class="text-[14px] text-black/55">Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.</p>
        <button @click="searchQuery = ''; selectedCategory = 'all'" class="mt-2 px-5 py-2 rounded-full bg-black text-white text-[13px] font-medium transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm">
            Reset Filter
        </button>
    </div>
</div>
@endsection
