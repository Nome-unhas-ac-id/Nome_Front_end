@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{
    searchQuery: '',
    selectedStatus: 'all',
    viewMode: 'grid',
    memos: [
        {
            id: 'NOME-MEMO-001',
            letterNo: '082/UN4.6.1/PL/2026',
            title: 'Rapat Pleno Penyusunan Rencana Strategis Rekayasa Perangkat Lunak 2026',
            date: '06 Okt 2026',
            time: '09:00 - 12:00 WITA',
            location: 'Ruang Senat Rektorat Lt. 2',
            leader: 'Dr. Eng. Ir. Arman, M.T.',
            notetaker: 'Andi Ghalib (Notulis Resmi)',
            attendeesCount: 18,
            duration: '02:45:10',
            status: 'completed',
            statusLabel: 'Selesai &bull; Siap Ekspor',
            summary: 'Penetapan target publikasi internasional dosen, integrasi modul AI meeting transcription, dan pengadaan workstation GPU server.',
            tags: ['Rencana Strategis', 'Kurikulum', 'Infrastruktur']
        },
        {
            id: 'NOME-MEMO-002',
            letterNo: '079/UN4.6.1/TU/2026',
            title: 'Sinkronisasi Kurikulum MBKM & Kemitraan Industri Digital',
            date: '03 Okt 2026',
            time: '13:30 - 15:45 WITA',
            location: 'Lab Rekayasa Perangkat Lunak',
            leader: 'Ketua Departemen Informatika',
            notetaker: 'Andi Ghalib',
            attendeesCount: 12,
            duration: '01:58:30',
            status: 'completed',
            statusLabel: 'Selesai &bull; Siap Ekspor',
            summary: 'Persetujuan kurikulum magang mandiri dengan 5 mitra industri software nasional. Kesepakatan penyetaraan 20 SKS.',
            tags: ['MBKM', 'Kemitraan', 'Industri']
        },
        {
            id: 'NOME-MEMO-003',
            letterNo: '075/UN4.6.1/KEU/2026',
            title: 'Rapat Alokasi Anggaran Belanja Operasional Laboratorium 2027',
            date: '28 Sep 2026',
            time: '10:00 - 11:30 WITA',
            location: 'Ruang Rapat Dekanat Lt. 1',
            leader: 'Wakil Dekan Bidang Keuangan',
            notetaker: 'Siti Rahma, S.Kom.',
            attendeesCount: 9,
            duration: '01:22:05',
            status: 'review',
            statusLabel: 'Perlu Verifikasi Notulis',
            summary: 'Pemaparan rincian kebutuhan pengadaan server GPU AI, lisensi software pengembangan aplikasi, dan pendingin server.',
            tags: ['Keuangan', 'Pengadaan', 'Lab']
        },
        {
            id: 'NOME-MEMO-004',
            letterNo: '071/UN4.6.1/AKD/2026',
            title: 'Sidang Yudisium & Penentuan Lulusan Terbaik Periode Wisuda I',
            date: '20 Sep 2026',
            time: '08:30 - 12:30 WITA',
            location: 'Aula Prof. Fachruddin',
            leader: 'Dekan Fakultas Teknik',
            notetaker: 'Andi Ghalib',
            attendeesCount: 35,
            duration: '03:40:12',
            status: 'completed',
            statusLabel: 'Selesai &bull; Siap Ekspor',
            summary: 'Penetapan 48 lulusan sarjana teknik informatika dengan predikat Cum Laude dan pembacaan berita acara kelulusan resmi.',
            tags: ['Yudisium', 'Wisuda', 'Akademik']
        },
        {
            id: 'NOME-MEMO-005',
            letterNo: '068/UN4.6.1/PPM/2026',
            title: 'Rapat Persiapan Hibah Pengabdian Masyarakat KKN Tematik Digital',
            date: '14 Sep 2026',
            time: '14:00 - 16:30 WITA',
            location: 'Ruang Seminar Departemen',
            leader: 'Koordinator Pengabdian Masyarakat',
            notetaker: 'Budi Santoso, S.T.',
            attendeesCount: 15,
            duration: '02:15:00',
            status: 'draft',
            statusLabel: 'Draf Mentah',
            summary: 'Sosialisasi program kerja digitalisasi kelurahan dan pembuatan prototipe sistem administrasi persuratan warga.',
            tags: ['Pengabdian', 'KKN', 'Masyarakat']
        },
        {
            id: 'NOME-MEMO-006',
            letterNo: '062/UN4.6.1/PEN/2026',
            title: 'FGD Evaluasi Capaian Publikasi Jurnal Terindeks Scopus Q1/Q2',
            date: '05 Sep 2026',
            time: '09:00 - 11:30 WITA',
            location: 'Ruang Rapat Senat Lt. 2',
            leader: 'Ketua LP2M',
            notetaker: 'Andi Ghalib',
            attendeesCount: 22,
            duration: '02:08:45',
            status: 'completed',
            statusLabel: 'Selesai &bull; Siap Ekspor',
            summary: 'Pemberian insentif penulisan jurnal internasional bereputasi dan pembentukan tim pendampingan penulisan manuskrip.',
            tags: ['Riset', 'Scopus', 'Publikasi']
        }
    ],
    get filteredMemos() {
        return this.memos.filter(memo => {
            const matchesSearch = memo.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                  memo.letterNo.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                  memo.leader.toLowerCase().includes(this.searchQuery.toLowerCase());
            const matchesStatus = this.selectedStatus === 'all' || memo.status === this.selectedStatus;
            return matchesSearch && matchesStatus;
        });
    }
}">

    <!-- Breadcrumb & Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 border-b border-[#d9d9d9]">
        <div>
            <div class="inline-flex items-center space-x-2 text-[12px] text-black/60 font-medium mb-2">
                <a href="{{ url('/dashboard') }}" class="hover:text-black">Dashboard</a>
                <span>/</span>
                <span class="text-black">Riwayat Arsip Memo</span>
            </div>
            <h1 class="text-[32px] md:text-[38px] font-bold tracking-tight text-black leading-tight">
                Riwayat & Arsip Notulensi
            </h1>
            <p class="text-[15px] text-black/60 mt-1">
                Koleksi lengkap seluruh notulensi rapat, transkrip audio AI, dan dokumen resmi yang tersimpan di sistem Nome.
            </p>
        </div>

        <!-- Action CTA -->
        <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-2 bg-[#ff5347] text-white font-medium text-[14px] rounded-[8px] px-5 py-2 hover:bg-[#e0453a] transition-colors self-start md:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>+ Buat Memo Rapat Baru</span>
        </a>
    </div>

    <!-- Filter & Toolbar Card (Zero Shadow, 1px Border) -->
    <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-4 flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Search Input -->
        <div class="w-full md:w-96 relative">
            <input type="text" 
                   x-model="searchQuery"
                   placeholder="Cari agenda, nomor surat, atau pimpinan..." 
                   class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] pl-10 pr-4 py-2 text-[14px] text-black placeholder-black/40 focus:outline-none focus:border-[#ff5347] transition-colors">
            <svg class="w-4 h-4 text-black/40 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <!-- Filter Controls -->
        <div class="flex items-center space-x-3 w-full md:w-auto justify-between md:justify-end">
            <!-- Status Dropdown -->
            <select x-model="selectedStatus" class="bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3 py-2 text-[13px] font-medium text-black/80 focus:outline-none focus:border-[#ff5347]">
                <option value="all">Semua Status (6)</option>
                <option value="completed">Selesai & Siap Ekspor</option>
                <option value="review">Perlu Verifikasi</option>
                <option value="draft">Draf Mentah</option>
            </select>

            <!-- View Toggle Buttons -->
            <div class="flex items-center border border-[#d9d9d9] rounded-[8px] p-0.5 bg-[#F8F7F3]">
                <button @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white text-black font-medium border border-[#d9d9d9]' : 'text-black/60 hover:text-black'"
                        class="p-1.5 rounded-[6px] transition-colors" title="Grid View">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </button>
                <button @click="viewMode = 'list'" 
                        :class="viewMode === 'list' ? 'bg-white text-black font-medium border border-[#d9d9d9]' : 'text-black/60 hover:text-black'"
                        class="p-1.5 rounded-[6px] transition-colors" title="List View">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Grid View Mode -->
    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="memo in filteredMemos" :key="memo.id">
            <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 flex flex-col justify-between hover:border-black/40 transition-colors space-y-4">
                <div class="space-y-3">
                    <!-- Top Status & Letter No -->
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="font-mono text-black/60" x-text="memo.letterNo"></span>
                        <span class="px-2.5 py-0.5 rounded-full font-semibold border"
                              :class="{
                                  'bg-emerald-50 text-emerald-700 border-emerald-200': memo.status === 'completed',
                                  'bg-amber-50 text-amber-700 border-amber-200': memo.status === 'review',
                                  'bg-gray-100 text-gray-700 border-gray-300': memo.status === 'draft'
                              }" 
                              x-html="memo.statusLabel"></span>
                    </div>

                    <!-- Title -->
                    <h2 class="text-[18px] font-bold tracking-tight text-black line-clamp-2 leading-snug" x-text="memo.title"></h2>

                    <!-- Summary snippet -->
                    <p class="text-[13px] text-black/70 line-clamp-3 leading-relaxed" x-text="memo.summary"></p>

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        <template x-for="tag in memo.tags" :key="tag">
                            <span class="text-[11px] font-medium bg-[#F8F7F3] border border-[#d9d9d9] rounded-full px-2.5 py-0.5 text-black/70" x-text="tag"></span>
                        </template>
                    </div>
                </div>

                <!-- Footer details & actions -->
                <div class="pt-4 border-t border-[#d9d9d9] space-y-3">
                    <div class="text-[12px] text-black/60 space-y-1">
                        <div class="flex items-center justify-between">
                            <span>Waktu & Tanggal:</span>
                            <span class="font-medium text-black" x-text="memo.date"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Pimpinan:</span>
                            <span class="font-medium text-black truncate max-w-[170px]" x-text="memo.leader"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Peserta Hadir:</span>
                            <span class="font-medium text-black" x-text="memo.attendeesCount + ' Orang'"></span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 pt-1">
                        <a href="{{ url('/preview') }}" class="flex-1 text-center bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[13px] rounded-[6px] py-1.5 hover:bg-black/5 transition-colors">
                            Buka Preview
                        </a>
                        <a href="{{ url('/preview') }}" class="flex-1 text-center bg-[#ff5347] text-white font-medium text-[13px] rounded-[6px] py-1.5 hover:bg-[#e0453a] transition-colors">
                            Ekspor PDF
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- List View Mode -->
    <div x-show="viewMode === 'list'" class="bg-white border border-[#d9d9d9] rounded-[12px] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-[14px]">
                <thead class="bg-[#F8F7F3] border-b border-[#d9d9d9] text-[12px] uppercase tracking-wider text-black/60 font-semibold">
                    <tr>
                        <th class="px-5 py-3.5">Nomor & Agenda Rapat</th>
                        <th class="px-4 py-3.5">Tanggal</th>
                        <th class="px-4 py-3.5">Pimpinan</th>
                        <th class="px-4 py-3.5">Hadir</th>
                        <th class="px-4 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#d9d9d9]">
                    <template x-for="memo in filteredMemos" :key="memo.id">
                        <tr class="hover:bg-[#F8F7F3]/50 transition-colors">
                            <td class="px-5 py-4">
                                <p class="text-[12px] font-mono text-black/50" x-text="memo.letterNo"></p>
                                <p class="text-[15px] font-bold text-black" x-text="memo.title"></p>
                                <p class="text-[12px] text-black/60 truncate max-w-md mt-0.5" x-text="memo.summary"></p>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-[13px] text-black/80" x-text="memo.date"></td>
                            <td class="px-4 py-4 whitespace-nowrap text-[13px] font-medium text-black" x-text="memo.leader"></td>
                            <td class="px-4 py-4 whitespace-nowrap text-[13px] text-black/80" x-text="memo.attendeesCount + ' Peserta'"></td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold border"
                                      :class="{
                                          'bg-emerald-50 text-emerald-700 border-emerald-200': memo.status === 'completed',
                                          'bg-amber-50 text-amber-700 border-amber-200': memo.status === 'review',
                                          'bg-gray-100 text-gray-700 border-gray-300': memo.status === 'draft'
                                      }"
                                      x-html="memo.statusLabel"></span>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-right space-x-1.5">
                                <a href="{{ url('/preview') }}" class="inline-block bg-transparent text-black/90 border border-[#d9d9d9] font-medium text-[12px] rounded-[4px] px-2.5 py-1 hover:bg-black/5 transition-colors">
                                    Editor
                                </a>
                                <a href="{{ url('/preview') }}" class="inline-block bg-[#ff5347] text-white font-medium text-[12px] rounded-[4px] px-2.5 py-1 hover:bg-[#e0453a] transition-colors">
                                    Ekspor
                                </a>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
