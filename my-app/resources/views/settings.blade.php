@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-12 pb-24"
     x-data="{
        activeTab: 'profil',
        showToast: false,
        toastMessage: '',
        profile: {
            name: 'Andi Abi',
            email: 'andiabi@unhas.ac.id',
            role: 'Koordinator Tim Riset & Inovasi',
            department: 'Fakultas Teknik, Universitas Hasanuddin',
            bio: 'Pengembang dan koordinator riset terapan di bidang rekayasa perangkat lunak.'
        },
        preferences: {
            language: 'id',
            exportFormat: 'pdf',
            autoDiarization: true,
            smartSummary: true,
            notificationEmail: true
        },
        saveSettings() {
            this.toastMessage = 'Pengaturan berhasil diperbarui.';
            this.showToast = true;
            setTimeout(() => { this.showToast = false; }, 3000);
        }
     }">

    <!-- Notification Toast -->
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-3"
         class="fixed bottom-8 right-8 z-50 bg-black text-white border border-[#d9d9d9]/40 rounded-full px-6 py-3 flex items-center space-x-3 text-[14px] font-medium"
         style="display: none;">
        <div class="w-2.5 h-2.5 rounded-full bg-[#ff5347]"></div>
        <span x-text="toastMessage"></span>
    </div>

    <!-- 1. MACRO-TYPOGRAPHY HEADER (Strictly No Decorative Pill, Generous Whitespace) -->
    <div class="pt-6 border-b border-[#d9d9d9]/60 pb-8">
        <h1 class="text-[44px] sm:text-[56px] font-black tracking-tighter text-black leading-tight">
            Pengaturan.
        </h1>
        <p class="text-[17px] text-black/55 mt-2 max-w-2xl font-normal leading-relaxed">
            Kelola profil pengguna, preferensi transkripsi rapat, kuota AI, serta integrasi kalender dan dokumen.
        </p>
    </div>

    <!-- 2. TWO-COLUMN MINIMALIST SETTINGS LAYOUT -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-14 items-start">
        
        <!-- Narrow Left Sidebar (Navigation Only) -->
        <aside class="md:col-span-3 space-y-1">
            <button type="button" 
                    @click="activeTab = 'profil'"
                    :class="activeTab === 'profil' ? 'font-bold text-black bg-black/[0.04]' : 'text-black/60 hover:text-black hover:bg-black/[0.02]'"
                    class="w-full text-left px-4 py-3 rounded-xl text-[14px] transition-colors flex items-center justify-between">
                <span>Profil</span>
                <span x-show="activeTab === 'profil'" class="w-1.5 h-1.5 rounded-full bg-[#ff5347]"></span>
            </button>

            <button type="button" 
                    @click="activeTab = 'preferensi'"
                    :class="activeTab === 'preferensi' ? 'font-bold text-black bg-black/[0.04]' : 'text-black/60 hover:text-black hover:bg-black/[0.02]'"
                    class="w-full text-left px-4 py-3 rounded-xl text-[14px] transition-colors flex items-center justify-between">
                <span>Preferensi</span>
                <span x-show="activeTab === 'preferensi'" class="w-1.5 h-1.5 rounded-full bg-[#ff5347]"></span>
            </button>

            <button type="button" 
                    @click="activeTab = 'kuota'"
                    :class="activeTab === 'kuota' ? 'font-bold text-black bg-black/[0.04]' : 'text-black/60 hover:text-black hover:bg-black/[0.02]'"
                    class="w-full text-left px-4 py-3 rounded-xl text-[14px] transition-colors flex items-center justify-between">
                <span>Kuota AI</span>
                <span x-show="activeTab === 'kuota'" class="w-1.5 h-1.5 rounded-full bg-[#ff5347]"></span>
            </button>

            <button type="button" 
                    @click="activeTab = 'integrasi'"
                    :class="activeTab === 'integrasi' ? 'font-bold text-black bg-black/[0.04]' : 'text-black/60 hover:text-black hover:bg-black/[0.02]'"
                    class="w-full text-left px-4 py-3 rounded-xl text-[14px] transition-colors flex items-center justify-between">
                <span>Integrasi</span>
                <span x-show="activeTab === 'integrasi'" class="w-1.5 h-1.5 rounded-full bg-[#ff5347]"></span>
            </button>
        </aside>

        <!-- Wider Right Area (Form Content) -->
        <main class="md:col-span-9">

            <!-- TAB 1: PROFIL -->
            <div x-show="activeTab === 'profil'" class="space-y-10">
                <div class="border-b border-[#d9d9d9]/60 pb-4">
                    <h2 class="text-[24px] font-bold tracking-tight text-black">Profil Pengguna</h2>
                    <p class="text-[14px] text-black/50 mt-0.5">Informasi akun dan identitas default pada lembar notulensi rapat.</p>
                </div>

                <!-- Avatar Section (Simple colored div placeholder) -->
                <div class="flex items-center space-x-5">
                    <div class="w-16 h-16 rounded-full bg-[#ff5347] flex items-center justify-center text-white font-extrabold text-2xl shrink-0">
                        A
                    </div>
                    <div class="space-y-1">
                        <p class="text-[15px] font-bold text-black">Foto Profil</p>
                        <p class="text-[13px] text-black/50">Mendukung file JPG, PNG, atau GIF hingga 2 MB.</p>
                        <div class="pt-1 flex items-center space-x-3">
                            <button type="button" class="text-[13px] font-medium text-black hover:text-[#ff5347] underline underline-offset-4 transition-colors">
                                Ubah Foto
                            </button>
                            <span class="text-black/30">&bull;</span>
                            <button type="button" class="text-[13px] font-medium text-black/45 hover:text-black transition-colors">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Fields with Minimal Bottom Border (border-b) -->
                <div class="space-y-8 max-w-xl">
                    <div class="space-y-2">
                        <label class="block text-[12px] font-bold text-black/50 uppercase tracking-wider">
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               x-model="profile.name"
                               placeholder="Nama lengkap beserta gelar..."
                               class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[16px] text-black font-medium transition-colors">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[12px] font-bold text-black/50 uppercase tracking-wider">
                            Alamat Email
                        </label>
                        <input type="email" 
                               x-model="profile.email"
                               placeholder="nama@institusi.ac.id"
                               class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[16px] text-black font-medium transition-colors">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[12px] font-bold text-black/50 uppercase tracking-wider">
                            Jabatan / Peran
                        </label>
                        <input type="text" 
                               x-model="profile.role"
                               placeholder="Jabatan atau fungsi utama..."
                               class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[16px] text-black font-medium transition-colors">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[12px] font-bold text-black/50 uppercase tracking-wider">
                            Institusi / Organisasi
                        </label>
                        <input type="text" 
                               x-model="profile.department"
                               placeholder="Nama unit kerja atau universitas..."
                               class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[16px] text-black font-medium transition-colors">
                    </div>

                    <div class="pt-4">
                        <button type="button" 
                                @click="saveSettings()"
                                class="px-7 py-3 rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white text-[14px] font-semibold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>

            <!-- TAB 2: PREFERENSI -->
            <div x-show="activeTab === 'preferensi'" class="space-y-10" style="display: none;">
                <div class="border-b border-[#d9d9d9]/60 pb-4">
                    <h2 class="text-[24px] font-bold tracking-tight text-black">Preferensi Notulensi</h2>
                    <p class="text-[14px] text-black/50 mt-0.5">Konfigurasi bahasa default, format rangkuman, dan pemrosesan otomatis.</p>
                </div>

                <div class="space-y-8 max-w-xl">
                    <div class="space-y-2">
                        <label class="block text-[12px] font-bold text-black/50 uppercase tracking-wider">
                            Bahasa Transkripsi Utama
                        </label>
                        <select x-model="preferences.language"
                                class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[15px] text-black font-medium transition-colors cursor-pointer">
                            <option value="id">Bahasa Indonesia (Otomatis)</option>
                            <option value="en">English (US/UK)</option>
                            <option value="bilingual">Bilingual (Indonesia & English)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[12px] font-bold text-black/50 uppercase tracking-wider">
                            Format Ekspor Dokumen Default
                        </label>
                        <select x-model="preferences.exportFormat"
                                class="w-full border-b border-[#d9d9d9] bg-transparent focus:border-black focus:outline-none focus:ring-0 px-0 py-2.5 text-[15px] text-black font-medium transition-colors cursor-pointer">
                            <option value="pdf">PDF Berita Acara Rapat Resmi</option>
                            <option value="docx">Microsoft Word (.docx)</option>
                            <option value="markdown">Markdown (.md)</option>
                        </select>
                    </div>

                    <!-- Minimalist Toggle Rows -->
                    <div class="pt-2 space-y-5 border-t border-[#d9d9d9]/60">
                        <div class="flex items-center justify-between py-2">
                            <div>
                                <p class="text-[15px] font-bold text-black">Pemisahan Pembicara Otomatis (Diarisasi)</p>
                                <p class="text-[13px] text-black/50">Mendeteksi pergantian orang yang sedang berbicara dalam sesi audio.</p>
                            </div>
                            <button type="button" 
                                    @click="preferences.autoDiarization = !preferences.autoDiarization"
                                    :class="preferences.autoDiarization ? 'bg-black' : 'bg-gray-200'"
                                    class="w-12 h-6 rounded-full transition-colors p-1 relative shrink-0">
                                <div :class="preferences.autoDiarization ? 'translate-x-6 bg-white' : 'translate-x-0 bg-white'"
                                     class="w-4 h-4 rounded-full transition-transform"></div>
                            </button>
                        </div>

                        <div class="flex items-center justify-between py-2 border-t border-[#d9d9d9]/40">
                            <div>
                                <p class="text-[15px] font-bold text-black">Rangkuman Poin & Action Items AI</p>
                                <p class="text-[13px] text-black/50">Ekstrak otomatis kesimpulan dan tabel penanggung jawab tugas.</p>
                            </div>
                            <button type="button" 
                                    @click="preferences.smartSummary = !preferences.smartSummary"
                                    :class="preferences.smartSummary ? 'bg-black' : 'bg-gray-200'"
                                    class="w-12 h-6 rounded-full transition-colors p-1 relative shrink-0">
                                <div :class="preferences.smartSummary ? 'translate-x-6 bg-white' : 'translate-x-0 bg-white'"
                                     class="w-4 h-4 rounded-full transition-transform"></div>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="button" 
                                @click="saveSettings()"
                                class="px-7 py-3 rounded-full bg-[#ff5347] hover:bg-[#e0453a] text-white text-[14px] font-semibold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95">
                            Simpan Preferensi
                        </button>
                    </div>
                </div>
            </div>

            <!-- TAB 3: KUOTA AI -->
            <div x-show="activeTab === 'kuota'" class="space-y-10" style="display: none;">
                <div class="border-b border-[#d9d9d9]/60 pb-4">
                    <h2 class="text-[24px] font-bold tracking-tight text-black">Kuota Pemrosesan AI</h2>
                    <p class="text-[14px] text-black/50 mt-0.5">Pemantauan durasi audio rapat dan kapasitas transkripsi yang tersedia.</p>
                </div>

                <div class="space-y-8 max-w-xl">
                    <!-- Clean Metric Box -->
                    <div class="bg-white border border-[#d9d9d9] rounded-2xl p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] font-bold uppercase tracking-wider text-black/50">Penggunaan Bulan Ini</span>
                            <span class="text-sm text-gray-500 font-medium">Paket Akademik</span>
                        </div>
                        <div>
                            <div class="flex items-baseline space-x-2">
                                <span class="text-[36px] font-black text-black tracking-tight">120</span>
                                <span class="text-[16px] text-black/45">/ 300 Menit</span>
                            </div>
                            <p class="text-[13px] text-black/55 mt-1">Tersisa 180 menit untuk periode penagihan hingga 31 Oktober 2026.</p>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-[#d9d9d9]/70 h-2 rounded-full overflow-hidden">
                            <div class="bg-[#ff5347] h-full rounded-full" style="width: 40%;"></div>
                        </div>
                    </div>

                    <div class="space-y-3 pt-2">
                        <h3 class="text-[16px] font-bold text-black">Perlu Tambahan Jam Rapat?</h3>
                        <p class="text-[14px] text-black/55 leading-relaxed">
                            Hubungi administrator institusi untuk meningkatkan kapasitas transkripsi audio tanpa batas untuk seluruh departemen.
                        </p>
                        <div class="pt-2">
                            <button type="button" class="px-6 py-2.5 rounded-lg border border-[#d9d9d9] text-[13px] font-medium text-black hover:bg-black hover:text-white transition-colors">
                                Minta Perpanjangan Kuota
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: INTEGRASI -->
            <div x-show="activeTab === 'integrasi'" class="space-y-10" style="display: none;">
                <div class="border-b border-[#d9d9d9]/60 pb-4">
                    <h2 class="text-[24px] font-bold tracking-tight text-black">Integrasi Layanan</h2>
                    <p class="text-[14px] text-black/50 mt-0.5">Hubungkan Nome dengan kalender kerja, platform video konferensi, dan penyimpanan berkas.</p>
                </div>

                <div class="space-y-4 max-w-xl">
                    <!-- Google Calendar Integration Card -->
                    <div class="bg-white border border-[#d9d9d9] rounded-2xl p-5 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Simple Colored Div Placeholder -->
                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center font-bold text-blue-600 text-sm">
                                G
                            </div>
                            <div>
                                <p class="text-[15px] font-bold text-black">Google Calendar</p>
                                <p class="text-[12px] text-black/50">Sinkronkan jadwal dan agenda rapat secara otomatis.</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 border-none">
                            Tersambung
                        </span>
                    </div>

                    <!-- Zoom Meetings Integration Card -->
                    <div class="bg-white border border-[#d9d9d9] rounded-2xl p-5 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Simple Colored Div Placeholder -->
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/30 flex items-center justify-center font-bold text-indigo-600 text-sm">
                                Z
                            </div>
                            <div>
                                <p class="text-[15px] font-bold text-black">Zoom Meetings</p>
                                <p class="text-[12px] text-black/50">Tarik rekaman awan Zoom setelah sesi pertemuan usai.</p>
                            </div>
                        </div>
                        <button type="button" class="text-[13px] font-medium text-black hover:text-[#ff5347] border border-[#d9d9d9] rounded-lg px-4 py-1.5 hover:border-black transition-colors">
                            Sambungkan
                        </button>
                    </div>

                    <!-- Google Drive Storage Card -->
                    <div class="bg-white border border-[#d9d9d9] rounded-2xl p-5 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Simple Colored Div Placeholder -->
                            <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center font-bold text-amber-600 text-sm">
                                D
                            </div>
                            <div>
                                <p class="text-[15px] font-bold text-black">Google Drive</p>
                                <p class="text-[12px] text-black/50">Arsipkan otomatis ekspor PDF berita acara rapat ke folder drive.</p>
                            </div>
                        </div>
                        <button type="button" class="text-[13px] font-medium text-black hover:text-[#ff5347] border border-[#d9d9d9] rounded-lg px-4 py-1.5 hover:border-black transition-colors">
                            Sambungkan
                        </button>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>
@endsection
