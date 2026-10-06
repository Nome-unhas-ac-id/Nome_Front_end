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
</head>
<body class="bg-[#F8F7F3] text-black/95 font-sans antialiased selection:bg-[#ff5347]/20 selection:text-black">

    <!-- FLOATING LIQUID GLASS PILL NAVBAR (Top Center, Pill-Shaped, Glassmorphism) -->
    <header class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[92%] sm:w-auto max-w-4xl bg-white/60 backdrop-blur-lg border border-white/40 ring-1 ring-black/[0.08] shadow-sm floating-glass-pill rounded-full px-6 py-3 flex items-center justify-between gap-6 sm:gap-10 transition-all">
        <!-- Left: Logo text (Black, bold) -->
        <a href="{{ url('/dashboard') }}" class="flex items-center space-x-2.5 group shrink-0">
            <span class="w-7 h-7 rounded-full bg-black text-white flex items-center justify-center font-black text-xs tracking-tighter transition-transform group-hover:scale-105">
                N
            </span>
            <span class="text-[18px] sm:text-[19px] font-black tracking-tight text-black leading-none">Nome.</span>
        </a>

        <!-- Center: Simple navigation links (Only Workspace & Memo) -->
        <nav class="hidden md:flex items-center space-x-8 text-[13px] font-medium">
            <a href="{{ url('/dashboard') }}" 
               class="transition-colors pb-0.5 {{ request()->is('dashboard') || request()->is('/') ? 'font-bold text-[#ff5347] border-b-2 border-[#ff5347]' : 'text-black/65 hover:text-black' }}">
                Workspace
            </a>
            <a href="{{ url('/memo') }}" 
               class="transition-colors pb-0.5 {{ request()->is('memo*') || request()->is('history*') ? 'font-bold text-[#ff5347] border-b-2 border-[#ff5347]' : 'text-black/65 hover:text-black' }}">
                Memo
            </a>
        </nav>

        <!-- Right: Primary Action Button (#ff5347) & Simple Account Dropdown -->
        <div class="flex items-center space-x-3 shrink-0">
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
                    <div class="w-8 h-8 rounded-full bg-[#ff5347] cursor-pointer"></div>
                </button>

                <!-- Dropdown Menu Card -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                     class="absolute right-0 mt-3 w-44 bg-white border border-[#d9d9d9] rounded-2xl p-2 z-50 floating-glass-pill space-y-1">
                    <a href="{{ url('/settings') }}" class="flex items-center px-3.5 py-2 rounded-xl text-[13px] font-medium text-black/75 hover:text-black hover:bg-black/[0.04] transition-colors">
                        Settings
                    </a>
                    <div class="h-px bg-[#d9d9d9]/60 my-1"></div>
                    <a href="{{ url('/login') }}" class="flex items-center px-3.5 py-2 rounded-xl text-[13px] font-medium text-black/75 hover:text-black hover:bg-black/[0.04] transition-colors">
                        Login/Signup
                    </a>
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

        <!-- Minimalist Editorial Footer (100% Full Width) -->
        <footer class="w-full px-6 sm:px-10 lg:px-14 py-8 border-t border-[#d9d9d9]/60 text-[12px] text-black/45 flex items-center justify-between">
            <span class="font-bold text-black tracking-tight text-[13px]">Nome.</span>
        </footer>
    </div>
</body>
</html>
