<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Nome - Transkripsi & Notulensi Rapat AI' }}</title>
    <meta name="description" content="Nome - Platform cerdas pencatatan, transkripsi real-time, dan perumusan notulensi rapat otomatis berbasis kecerdasan buatan.">

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback Tailwind CSS CDN for instant rendering -->
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
        </style>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endif
</head>
<body class="bg-[#F8F7F3] text-black/95 font-sans antialiased selection:bg-[#ff5347]/20 selection:text-black">
    <div class="min-h-screen bg-[#F8F7F3] text-black/95 font-sans flex flex-col justify-between" x-data="{ mobileMenuOpen: false }">
        <!-- Top Navigation -->
        <header class="border-b border-[#d9d9d9] bg-[#F8F7F3] sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Brand & Left Nav -->
                    <div class="flex items-center space-x-8">
                        <a href="{{ url('/dashboard') }}" class="flex items-center space-x-2.5 group">
                            <span class="w-8 h-8 rounded-[8px] bg-[#ff5347] flex items-center justify-center text-white font-bold text-lg tracking-tight transition-transform group-hover:scale-105">
                                N
                            </span>
                            <div class="flex flex-col">
                                <span class="text-[20px] font-bold tracking-tight text-black leading-none">Nome</span>
                                <span class="text-[10px] uppercase font-semibold tracking-wider text-black/60 mt-0.5">Notulensi AI</span>
                            </div>
                        </a>

                        <!-- Navigation Links -->
                        <nav class="hidden md:flex items-center space-x-1">
                            <a href="{{ url('/dashboard') }}" 
                               class="px-3.5 py-1.5 rounded-[8px] text-[14px] font-medium transition-colors {{ request()->is('dashboard') || request()->is('/') ? 'bg-white border border-[#d9d9d9] text-black' : 'text-black/70 hover:text-black hover:bg-black/5' }}">
                                Dashboard
                            </a>
                            <a href="{{ url('/history') }}" 
                               class="px-3.5 py-1.5 rounded-[8px] text-[14px] font-medium transition-colors {{ request()->is('history*') ? 'bg-white border border-[#d9d9d9] text-black' : 'text-black/70 hover:text-black hover:bg-black/5' }}">
                                Riwayat Memo
                            </a>
                            <a href="{{ url('/add-memo') }}" 
                               class="px-3.5 py-1.5 rounded-[8px] text-[14px] font-medium transition-colors {{ request()->is('add-memo*') ? 'bg-white border border-[#d9d9d9] text-black' : 'text-black/70 hover:text-black hover:bg-black/5' }}">
                                Buat Rapat Baru
                            </a>
                            <a href="{{ url('/preview') }}" 
                               class="px-3.5 py-1.5 rounded-[8px] text-[14px] font-medium transition-colors {{ request()->is('preview*') ? 'bg-white border border-[#d9d9d9] text-black' : 'text-black/70 hover:text-black hover:bg-black/5' }}">
                                Preview Editor
                            </a>
                        </nav>
                    </div>

                    <!-- Right Nav: System Status & Profile CTA -->
                    <div class="hidden sm:flex items-center space-x-3.5">
                        <!-- AI Engine Status Pill -->
                        <div class="flex items-center space-x-2 px-3 py-1 rounded-full border border-[#d9d9d9] bg-white text-[12px] font-medium text-black/70">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Whisper AI: Siap</span>
                        </div>

                        <!-- CTA Button -->
                        <a href="{{ url('/add-memo') }}" class="inline-flex items-center space-x-1.5 bg-[#ff5347] text-white font-medium text-[14px] rounded-[8px] px-4 py-2 hover:bg-[#e0453a] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Rekam Rapat</span>
                        </a>

                        <!-- User Profile Dropdown Simulator -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 border border-[#d9d9d9] rounded-[8px] bg-white px-2.5 py-1.5 hover:bg-black/5 transition-colors">
                                <div class="w-6 h-6 rounded-full bg-black/10 text-black/80 font-bold text-[11px] flex items-center justify-center">
                                    AG
                                </div>
                                <span class="text-[13px] font-medium text-black/90">Andi Ghalib</span>
                                <svg class="w-3.5 h-3.5 text-black/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute right-0 mt-2 w-48 bg-white border border-[#d9d9d9] rounded-[12px] py-1.5 z-50">
                                <div class="px-3.5 py-2 border-b border-[#d9d9d9] text-[12px]">
                                    <p class="font-semibold text-black">Notulis Resmi</p>
                                    <p class="text-black/60 truncate">andiabi4925@unhas.ac.id</p>
                                </div>
                                <a href="{{ url('/login') }}" class="block px-3.5 py-1.5 text-[13px] text-black/80 hover:bg-[#F8F7F3] transition-colors">Ganti Akun (Login)</a>
                                <a href="{{ url('/signup') }}" class="block px-3.5 py-1.5 text-[13px] text-black/80 hover:bg-[#F8F7F3] transition-colors">Daftar Akun Baru</a>
                                <div class="border-t border-[#d9d9d9] my-1"></div>
                                <a href="{{ url('/login') }}" class="block px-3.5 py-1.5 text-[13px] text-[#ff5347] font-medium hover:bg-[#F8F7F3] transition-colors">Keluar</a>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Hamburger -->
                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-[8px] border border-[#d9d9d9] bg-white text-black/80">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div x-show="mobileMenuOpen" class="md:hidden border-t border-[#d9d9d9] bg-white px-4 pt-2 pb-4 space-y-1">
                <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded-[8px] text-[14px] font-medium {{ request()->is('dashboard') || request()->is('/') ? 'bg-[#F8F7F3] text-black font-semibold' : 'text-black/70' }}">Dashboard</a>
                <a href="{{ url('/history') }}" class="block px-3 py-2 rounded-[8px] text-[14px] font-medium {{ request()->is('history*') ? 'bg-[#F8F7F3] text-black font-semibold' : 'text-black/70' }}">Riwayat Memo</a>
                <a href="{{ url('/add-memo') }}" class="block px-3 py-2 rounded-[8px] text-[14px] font-medium {{ request()->is('add-memo*') ? 'bg-[#F8F7F3] text-black font-semibold' : 'text-black/70' }}">Buat Rapat Baru</a>
                <a href="{{ url('/preview') }}" class="block px-3 py-2 rounded-[8px] text-[14px] font-medium {{ request()->is('preview*') ? 'bg-[#F8F7F3] text-black font-semibold' : 'text-black/70' }}">Preview Editor</a>
                <div class="pt-2 border-t border-[#d9d9d9] flex flex-col space-y-2">
                    <a href="{{ url('/login') }}" class="text-center border border-[#d9d9d9] rounded-[8px] py-2 text-[14px] font-medium text-black">Login</a>
                    <a href="{{ url('/add-memo') }}" class="text-center bg-[#ff5347] text-white rounded-[8px] py-2 text-[14px] font-medium">Rekam Rapat Baru</a>
                </div>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="border-t border-[#d9d9d9] bg-[#F8F7F3] py-6 text-center text-[13px] text-black/60">
            <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-2">
                    <span class="font-bold text-black tracking-tight">Nome</span>
                    <span>&mdash;</span>
                    <span>Pencatat & Perumus Memo Rapat Cerdas</span>
                </div>
                <div class="flex items-center space-x-4 text-[12px]">
                    <span class="inline-flex items-center space-x-1.5 text-black/70">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Diarization & Whisper API Ready</span>
                    </span>
                    <span>&bull;</span>
                    <a href="{{ url('/history') }}" class="hover:text-black">Daftar Memo</a>
                    <span>&bull;</span>
                    <a href="{{ url('/preview') }}" class="hover:text-black">Format Dokumen</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
