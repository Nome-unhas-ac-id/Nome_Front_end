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
            *:not(.floating-glass-pill):not(.floating-glass-pill *):not(button:hover):not(a:hover) {
                box-shadow: none !important;
            }
            .floating-glass-pill {
                box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.04) !important;
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(16px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in-up {
                animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
            .animate-fade-in-up-delay {
                animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
            }
        </style>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endif

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body x-data="{ 
    isLoggedIn: localStorage.getItem('nome_is_logged_in') === 'true',
    showLoginModal: false,
    setLoggedIn(val) {
        this.isLoggedIn = val;
        if (val) {
            localStorage.setItem('nome_is_logged_in', 'true');
        } else {
            localStorage.removeItem('nome_is_logged_in');
        }
    }
}" class="bg-[#F8F7F3] text-black/95 font-sans antialiased selection:bg-[#ff5347]/20 selection:text-black">

    <!-- FLOATING LIQUID GLASS PILL NAVBAR (Top Center, Pill-Shaped, Glassmorphism) -->
    <header class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[92%] sm:w-auto max-w-4xl bg-white/60 backdrop-blur-lg border border-white/40 ring-1 ring-black/[0.08] shadow-sm floating-glass-pill rounded-full px-6 py-3 flex items-center justify-between gap-6 sm:gap-10 transition-all">
        <!-- Left: Logo & Live Pulse Recording Icon -->
        <a href="{{ url('/') }}" class="flex items-center space-x-2.5 group shrink-0" title="Nome — Sistem Notulensi & Transkripsi AI">
            <!-- Pulsing #FF5347 Recording Icon with Grain/Noise Texture -->
            <span class="relative flex items-center justify-center w-7 h-7 shrink-0">
                <span class="absolute inline-flex w-full h-full rounded-full bg-[#ff5347] opacity-40 animate-ping"></span>
                <span class="absolute -inset-0.5 rounded-full bg-[#ff5347]/30 blur-[2px] animate-pulse"></span>
                <span class="relative w-6 h-6 rounded-full overflow-hidden flex items-center justify-center bg-gradient-to-br from-[#ff6b60] via-[#ff5347] to-[#e03d32] border border-white/30 shadow-xs transition-transform group-hover:scale-105">
                    <!-- SVG Noise Texture Overlay -->
                    <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-45 mix-blend-overlay" xmlns="http://www.w3.org/2000/svg">
                        <filter id="rec-noise-nav">
                            <feTurbulence type="fractalNoise" baseFrequency="0.85" numOctaves="3" stitchTiles="stitch"/>
                        </filter>
                        <rect width="100%" height="100%" filter="url(#rec-noise-nav)"/>
                    </svg>
                    <!-- Inner Recording Core Dot -->
                    <span class="relative w-2 h-2 rounded-full bg-white shadow-[0_0_6px_rgba(255,255,255,0.95)] animate-pulse"></span>
                </span>
            </span>

            <!-- Official Nome Logo Image -->
            <img src="{{ asset('images/nome-logo.png') }}" alt="Nome." class="h-6 sm:h-7 w-auto object-contain transition-transform group-hover:scale-[1.02]">
        </a>

        <!-- Center: Unauthenticated Marketing Links (Fitur, Cara Kerja, Harga, Testimoni) -->
        <nav x-show="!isLoggedIn" x-cloak class="hidden md:flex items-center space-x-7 text-[13px] font-medium text-black/70">
            <a href="{{ url('/#fitur') }}" class="hover:text-black hover:text-[#ff5347] transition-colors">Fitur</a>
            <a href="{{ url('/#cara-kerja') }}" class="hover:text-black hover:text-[#ff5347] transition-colors">Cara Kerja</a>
            <a href="{{ url('/#harga') }}" class="hover:text-black hover:text-[#ff5347] transition-colors">Harga</a>
            <a href="{{ url('/#testimoni') }}" class="hover:text-black hover:text-[#ff5347] transition-colors">Testimoni</a>
        </nav>

        <!-- Center: Authenticated App Navigation (Workspace & Memo) -->
        <nav x-show="isLoggedIn" x-cloak class="hidden md:flex items-center space-x-8 text-[13px] font-medium">
            <a href="{{ url('/dashboard') }}" 
               class="transition-colors pb-0.5 {{ request()->is('dashboard') || request()->is('/') ? 'font-bold text-[#ff5347] border-b-2 border-[#ff5347]' : 'text-black/65 hover:text-black' }}">
                Workspace
            </a>
            <a href="{{ url('/memo') }}" 
               class="transition-colors pb-0.5 {{ request()->is('memo*') || request()->is('history*') ? 'font-bold text-[#ff5347] border-b-2 border-[#ff5347]' : 'text-black/65 hover:text-black' }}">
                Memo
            </a>
        </nav>

        <!-- Right: Unauthenticated Actions: Masuk (Ghost) & Daftar Gratis (Primary #ff5347 Pill) -->
        <div x-show="!isLoggedIn" x-cloak class="flex items-center space-x-2 sm:space-x-3 shrink-0">
            <a href="{{ url('/login') }}" 
               class="text-[13px] font-medium text-black/75 hover:text-black px-3 py-2 transition-colors">
                Masuk
            </a>
            <a href="{{ url('/signup') }}" 
               class="inline-flex items-center space-x-1.5 bg-[#ff5347] hover:bg-[#e0453a] text-white rounded-full px-5 py-2 text-[13px] font-semibold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95">
                <span>Daftar Gratis</span>
            </a>
        </div>

        <!-- Right: Authenticated Actions: Mulai Rapat & User Account Dropdown -->
        <div x-show="isLoggedIn" x-cloak class="flex items-center space-x-3 shrink-0">
            <a href="{{ url('/add-memo') }}" 
               class="inline-flex items-center space-x-2 bg-[#ff5347] hover:bg-[#e0453a] text-white rounded-full px-5 py-2 text-[13px] font-semibold transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span>Mulai Rapat</span>
            </a>

            <!-- Account Menu Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        @click.outside="open = false" 
                        type="button" 
                        class="flex items-center focus:outline-none transition-transform duration-300 ease-out hover:scale-105" 
                        title="Menu Pengguna">
                    <div class="w-8 h-8 rounded-full bg-[#ff5347] cursor-pointer ring-2 ring-white"></div>
                </button>

                <!-- Dropdown Menu Card -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                     class="absolute right-0 mt-3 w-48 bg-white border border-[#d9d9d9] rounded-2xl p-2 z-50 floating-glass-pill space-y-1">
                    <div class="px-3.5 py-1.5 border-b border-[#d9d9d9]/60">
                        <div class="text-[12px] font-bold text-black">Akun Pengguna</div>
                        <div class="text-[11px] text-black/50 truncate">user@nome.ac.id</div>
                    </div>
                    <a href="{{ url('/settings') }}" class="flex items-center px-3.5 py-2 rounded-xl text-[13px] font-medium text-black/75 hover:text-black hover:bg-black/[0.04] transition-colors">
                        Settings
                    </a>
                    <div class="h-px bg-[#d9d9d9]/60 my-1"></div>
                    <button type="button" 
                            @click="setLoggedIn(false); open = false" 
                            class="w-full text-left flex items-center px-3.5 py-2 rounded-xl text-[13px] font-semibold text-[#ff5347] hover:bg-[#ff5347]/10 transition-colors">
                        Keluar (Simulasi)
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- FULL VIEWPORT CONTAINER (100% WIDTH, NO SIDEBAR) -->
    <div class="min-h-screen bg-[#F8F7F3] flex flex-col w-full relative">
        <!-- Main Content Area with 100% Viewport Width -->
        <main class="@yield('main_class', 'flex-1 w-full px-6 sm:px-10 lg:px-14 pt-28 pb-12')">
            @yield('content')
        </main>

        <!-- Clean, Spacious Footer with Secondary Color Base (#ff5347) -->
        <footer class="w-full bg-[#ff5347] text-white py-12 px-6 sm:px-10 lg:px-14 mt-auto">
            <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6">
                <!-- Left: Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <span class="relative flex items-center justify-center w-7 h-7 shrink-0">
                        <span class="absolute inline-flex w-full h-full rounded-full bg-white opacity-40 animate-ping"></span>
                        <span class="relative w-6 h-6 rounded-full overflow-hidden flex items-center justify-center bg-white shadow-xs">
                            <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-30 mix-blend-multiply" xmlns="http://www.w3.org/2000/svg">
                                <filter id="rec-noise-footer">
                                    <feTurbulence type="fractalNoise" baseFrequency="0.85" numOctaves="3" stitchTiles="stitch"/>
                                </filter>
                                <rect width="100%" height="100%" filter="url(#rec-noise-footer)"/>
                            </svg>
                            <span class="relative w-2 h-2 rounded-full bg-[#ff5347] animate-pulse"></span>
                        </span>
                    </span>
                    <img src="{{ asset('images/nome-logo.png') }}" alt="Nome." class="h-6 w-auto object-contain brightness-0 invert">
                    <span class="text-white/70 text-xs hidden sm:inline ml-2">&copy; {{ date('Y') }}</span>
                </div>

                <!-- Right: Simple Links -->
                <div class="flex items-center space-x-6 sm:space-x-8 text-[13px] font-medium text-white/90">
                    <a href="#" class="hover:text-white transition-colors">Bantuan</a>
                    <a href="#" class="hover:text-white transition-colors">Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Ketentuan</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- ======================================================== -->
    <!-- THE GATE (LOGIN WARNING MODAL) -->
    <!-- x-show="showLoginModal" -->
    <!-- ======================================================== -->
    <div x-show="showLoginModal" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
         style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="showLoginModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showLoginModal = false"
             class="fixed inset-0 bg-black/40 backdrop-blur-xs"></div>

        <!-- Modal Dialog Box (Notion-like, warm paper border, zero shadow) -->
        <div x-show="showLoginModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-3"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-3"
             @keydown.escape.window="showLoginModal = false"
             class="relative bg-white border border-[#d9d9d9] rounded-2xl p-7 sm:p-9 max-w-md w-full space-y-6 z-10 text-center">
            
            <!-- Close Button -->
            <button type="button" 
                    @click="showLoginModal = false"
                    class="absolute top-5 right-5 text-black/40 hover:text-black w-8 h-8 rounded-full flex items-center justify-center hover:bg-black/[0.05] transition-colors cursor-pointer"
                    title="Tutup">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Icon Header -->
            <div class="w-14 h-14 rounded-2xl bg-[#ff5347]/10 border border-[#ff5347]/20 flex items-center justify-center mx-auto text-[#ff5347]">
                <span class="relative flex items-center justify-center w-8 h-8">
                    <span class="absolute inline-flex w-full h-full rounded-full bg-[#ff5347] opacity-35 animate-ping"></span>
                    <svg class="w-6 h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </span>
            </div>

            <!-- Modal Typography -->
            <div class="space-y-2">
                <h3 class="text-[22px] sm:text-[24px] font-black tracking-tight text-black leading-snug">
                    Akses Fitur Terkunci
                </h3>
                <p class="text-[15px] font-semibold text-black/85 leading-relaxed">
                    Harap masuk untuk mulai mencatat rapat
                </p>
                <p class="text-[13px] text-black/55 leading-relaxed">
                    Masuk atau buat akun baru untuk mengakses transkripsi suara, diarisasi pembicara otomatis, dan ekspor arsip resmi.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 pt-2">
                <a href="{{ url('/login') }}" 
                   class="block w-full bg-[#ff5347] hover:bg-[#e0453a] text-white font-bold text-[14px] rounded-full py-3.5 transition-all duration-300 ease-out hover:-translate-y-0.5 active:scale-95 shadow-none text-center">
                    Masuk ke Akun
                </a>
                
                <a href="{{ url('/signup') }}" 
                   class="block w-full bg-[#F8F7F3] hover:bg-black hover:text-white text-black border border-[#d9d9d9] font-semibold text-[14px] rounded-full py-3.5 transition-all duration-300 ease-out hover:-translate-y-0.5 active:scale-95 text-center">
                    Daftar Akun Baru
                </a>

                <button type="button"
                        @click="setLoggedIn(true); showLoginModal = false"
                        class="w-full text-[12px] font-semibold text-[#ff5347] hover:underline pt-1 py-1 transition-colors cursor-pointer">
                    &bull; Masuk Cepat Sebagai Pengguna Demo &bull;
                </button>
            </div>

        </div>
    </div>
</body>
</html>
