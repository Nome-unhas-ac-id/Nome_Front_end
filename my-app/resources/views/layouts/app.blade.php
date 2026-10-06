<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Nome — Sistem Notulensi & Transkripsi AI' }}</title>
    <meta name="description" content="Nome — Platform notulensi rapat cerdas bertenaga AI dengan desain ultra-clean, minimalis, dan lega.">

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            canvas: '#F8F7F3',
                            primary: {
                                DEFAULT: '#ff5347',
                                hover: '#e0453a',
                                accent: '#ff5347'
                            },
                            border: {
                                muted: '#d9d9d9'
                            },
                            surface: {
                                card: '#ffffff'
                            }
                        },
                        fontFamily: {
                            sans: ['Inter', 'sans-serif']
                        }
                    }
                }
            }
        </script>
        <style>
            :root {
                --bg-canvas: #F8F7F3;
                --primary-accent: #ff5347;
                --border-muted: #d9d9d9;
                --surface-card: #ffffff;
                --text-main: #000000;
            }
            body {
                background-color: #F8F7F3;
                color: rgba(0,0,0,0.95);
                font-family: 'Inter', sans-serif;
            }
            * {
                box-shadow: none !important;
            }
        </style>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endif
</head>
<body class="bg-[#F8F7F3] text-black/95 font-sans antialiased selection:bg-black/10 selection:text-black"
      x-data="{ 
          sidebarOpen: false, 
          globalSearchQuery: '',
          userMenuOpen: false
      }">

    <div class="min-h-screen bg-[#F8F7F3] flex">
        <!-- 1. LEFT FIXED VERTICAL SIDEBAR -->
        <aside class="fixed inset-y-0 left-0 z-40 w-64 xl:w-72 bg-white border-r border-[#d9d9d9]/70 flex flex-col justify-between transition-transform duration-200 ease-in-out md:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            
            <div class="p-6 xl:p-8 space-y-8 flex-1 overflow-y-auto">
                <!-- Brand / Logo (Sleek Minimalist Editorial) -->
                <div class="flex items-center justify-between">
                    <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 group">
                        <span class="w-9 h-9 rounded-xl bg-black text-white flex items-center justify-center font-bold text-lg tracking-tighter transition-transform group-hover:scale-105">
                            N
                        </span>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-extrabold tracking-tighter text-black leading-none">Nome</span>
                            <span class="text-[10px] uppercase font-semibold tracking-widest text-black/40 mt-1">AI Transcriber</span>
                        </div>
                    </a>

                    <!-- Close button for mobile -->
                    <button @click="sidebarOpen = false" class="md:hidden p-1.5 rounded-lg text-black/40 hover:text-black">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Main Menu Links -->
                <nav class="space-y-1.5">
                    <div class="text-[11px] font-bold uppercase tracking-widest text-black/35 px-4 mb-2">Navigasi Utama</div>

                    <a href="{{ url('/dashboard') }}" 
                       class="flex items-center space-x-3.5 px-4 py-2.5 text-[14px] transition-colors {{ request()->is('dashboard') || request()->is('/') ? 'bg-black/[0.05] text-black font-semibold rounded-full' : 'text-black/60 hover:text-black hover:bg-black/[0.02] rounded-full' }}">
                        <svg class="w-4 h-4 text-black/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ url('/history') }}" 
                       class="flex items-center space-x-3.5 px-4 py-2.5 text-[14px] transition-colors {{ request()->is('history*') ? 'bg-black/[0.05] text-black font-semibold rounded-full' : 'text-black/60 hover:text-black hover:bg-black/[0.02] rounded-full' }}">
                        <svg class="w-4 h-4 text-black/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span>Riwayat Memo</span>
                    </a>

                    <a href="{{ url('/add-memo') }}" 
                       class="flex items-center space-x-3.5 px-4 py-2.5 text-[14px] transition-colors {{ request()->is('add-memo*') ? 'bg-black/[0.05] text-black font-semibold rounded-full' : 'text-black/60 hover:text-black hover:bg-black/[0.02] rounded-full' }}">
                        <svg class="w-4 h-4 text-black/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Buat Rapat Baru</span>
                    </a>

                    <a href="{{ url('/preview') }}" 
                       class="flex items-center space-x-3.5 px-4 py-2.5 text-[14px] transition-colors {{ request()->is('preview*') ? 'bg-black/[0.05] text-black font-semibold rounded-full' : 'text-black/60 hover:text-black hover:bg-black/[0.02] rounded-full' }}">
                        <svg class="w-4 h-4 text-black/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Preview Editor</span>
                    </a>
                </nav>

                <!-- Category / Workspaces Folders -->
                <div class="space-y-1.5 pt-4 border-t border-[#d9d9d9]/60">
                    <div class="text-[11px] font-bold uppercase tracking-widest text-black/35 px-4 mb-2">Folder Ruang Kerja</div>

                    <a href="{{ url('/history') }}" class="flex items-center justify-between px-4 py-2 text-[13px] text-black/70 hover:text-black hover:bg-black/[0.02] rounded-full transition-colors">
                        <span class="flex items-center space-x-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#E5DEFF]"></span>
                            <span class="font-medium">Rapat Pimpinan Senat</span>
                        </span>
                        <span class="text-[11px] font-mono text-black/40">12</span>
                    </a>

                    <a href="{{ url('/history') }}" class="flex items-center justify-between px-4 py-2 text-[13px] text-black/70 hover:text-black hover:bg-black/[0.02] rounded-full transition-colors">
                        <span class="flex items-center space-x-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#D7EBFB]"></span>
                            <span class="font-medium">Kurikulum & MBKM</span>
                        </span>
                        <span class="text-[11px] font-mono text-black/40">8</span>
                    </a>

                    <a href="{{ url('/history') }}" class="flex items-center justify-between px-4 py-2 text-[13px] text-black/70 hover:text-black hover:bg-black/[0.02] rounded-full transition-colors">
                        <span class="flex items-center space-x-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#FCE8D5]"></span>
                            <span class="font-medium">Anggaran & Sarana</span>
                        </span>
                        <span class="text-[11px] font-mono text-black/40">5</span>
                    </a>

                    <a href="{{ url('/history') }}" class="flex items-center justify-between px-4 py-2 text-[13px] text-black/70 hover:text-black hover:bg-black/[0.02] rounded-full transition-colors">
                        <span class="flex items-center space-x-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#DCF0DF]"></span>
                            <span class="font-medium">Hibah Pengabdian</span>
                        </span>
                        <span class="text-[11px] font-mono text-black/40">3</span>
                    </a>
                </div>
            </div>

            <!-- Bottom Sidebar: User Profile & Minimalist Engine Status -->
            <div class="p-5 border-t border-[#d9d9d9]/70 bg-white space-y-3">
                <div class="flex items-center justify-between px-2">
                    <div class="flex items-center space-x-2 text-[12px] font-medium text-black/60">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Whisper AI Online</span>
                    </div>
                    <span class="text-[11px] font-mono text-black/40">v2.4</span>
                </div>

                <div class="flex items-center justify-between p-2 rounded-xl bg-black/[0.03] border border-[#d9d9d9]/60">
                    <div class="flex items-center space-x-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-black text-white font-bold text-[12px] flex items-center justify-center shrink-0">
                            AG
                        </div>
                        <div class="min-w-0">
                            <p class="text-[13px] font-semibold text-black truncate leading-tight">Andi Ghalib</p>
                            <p class="text-[11px] text-black/50 truncate">Notulis Resmi</p>
                        </div>
                    </div>
                    <a href="{{ url('/login') }}" title="Ganti Akun" class="text-black/40 hover:text-black p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Sidebar overlay for mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/20 backdrop-blur-xs md:hidden"></div>

        <!-- 2. MAIN RIGHT CANVAS (AIRY WHITESPACE) -->
        <div class="flex-1 md:ml-64 xl:ml-72 min-h-screen flex flex-col justify-between">
            @hasSection('top_navbar')
                @yield('top_navbar')
            @else
                <!-- Global Top Header Bar (Subtle & Airy) -->
                <header class="px-6 sm:px-10 lg:px-14 pt-8 pb-4 flex items-center justify-between gap-4">
                    <!-- Left Mobile Hamburger & Global Search Bar -->
                    <div class="flex items-center space-x-3 w-full max-w-xl">
                        <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-full border border-[#d9d9d9] bg-white text-black/80">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>

                        <!-- Global Search Bar -->
                        <div class="relative w-full">
                            <input type="text" 
                                   placeholder="Cari risalah, agenda, atau berkas transkrip..." 
                                   class="w-full bg-white border border-[#d9d9d9] rounded-full pl-11 pr-14 py-2.5 text-[14px] text-black placeholder-black/40 focus:outline-none focus:border-black transition-colors">
                            <svg class="w-4 h-4 text-black/40 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span class="absolute right-3.5 top-2.5 text-[11px] font-mono text-black/40 bg-[#F8F7F3] border border-[#d9d9d9] px-2 py-0.5 rounded-full">⌘K</span>
                        </div>
                    </div>

                    <!-- Right Quick Action & Notification -->
                    <div class="flex items-center space-x-3 shrink-0">
                        <a href="{{ url('/history') }}" class="hidden sm:flex p-2.5 rounded-full bg-white border border-[#d9d9d9] text-black/60 hover:text-black transition-colors" title="Pemberitahuan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </a>

                        <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-2 bg-black text-white hover:bg-black/85 rounded-full px-5 py-2.5 text-[13px] font-medium transition-transform active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>Rapat Baru</span>
                        </a>
                    </div>
                </header>
            @endif

            <!-- Main Content Area with Massive Breathing Room (p-8 sm:p-12 lg:p-16) -->
            <main class="@yield('main_class', 'flex-1 px-6 sm:px-10 lg:px-14 py-6')">
                @yield('content')
            </main>

            <!-- Minimalist Editorial Footer -->
            <footer class="px-6 sm:px-10 lg:px-14 py-8 border-t border-[#d9d9d9]/60 text-[12px] text-black/45 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <span class="font-bold text-black tracking-tighter text-[13px]">Nome</span>
                    <span>&mdash;</span>
                    <span>AI Meeting Transcription & Editorial Minutes</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span>Universitas Hasanuddin</span>
                    <span>&bull;</span>
                    <span>Whisper + PyAnnote Engine</span>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
