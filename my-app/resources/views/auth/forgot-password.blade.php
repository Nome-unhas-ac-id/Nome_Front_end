@extends('layouts.app')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6">
    <!-- Centered Clean White Card (bg-white border border-[#d9d9d9] rounded-2xl p-10 max-w-md w-full) -->
    <div class="bg-white border border-[#d9d9d9] rounded-2xl p-8 sm:p-10 max-w-md w-full space-y-8" x-data="{ sent: false }">
        
        <!-- Header & Branding -->
        <div class="space-y-4">
            <div class="flex items-center space-x-2.5">
                <span class="relative flex items-center justify-center w-8 h-8 shrink-0">
                    <span class="absolute inline-flex w-full h-full rounded-full bg-[#ff5347] opacity-40 animate-ping"></span>
                    <span class="absolute -inset-0.5 rounded-full bg-[#ff5347]/30 blur-[2px] animate-pulse"></span>
                    <span class="relative w-7 h-7 rounded-full overflow-hidden flex items-center justify-center bg-gradient-to-br from-[#ff6b60] via-[#ff5347] to-[#e03d32] border border-white/30 shadow-xs">
                        <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-45 mix-blend-overlay" xmlns="http://www.w3.org/2000/svg">
                            <filter id="rec-noise-fp-page">
                                <feTurbulence type="fractalNoise" baseFrequency="0.85" numOctaves="3" stitchTiles="stitch"/>
                            </filter>
                            <rect width="100%" height="100%" filter="url(#rec-noise-fp-page)"/>
                        </svg>
                        <span class="relative w-2.5 h-2.5 rounded-full bg-white shadow-[0_0_6px_rgba(255,255,255,0.95)] animate-pulse"></span>
                    </span>
                </span>
                <img src="{{ asset('images/nome-logo.png') }}" alt="Nome." class="h-7 w-auto object-contain">
            </div>

            <div class="space-y-1.5">
                <h1 class="text-[32px] sm:text-[36px] font-black tracking-tighter text-black leading-tight">
                    Lupa Kata Sandi?
                </h1>
                <p class="text-[14px] text-black/55 font-normal leading-relaxed">
                    Masukkan email Anda untuk menerima instruksi pemulihan kata sandi akun.
                </p>
            </div>
        </div>

        <!-- Success Message on Sent -->
        <div x-show="sent" 
             x-cloak 
             class="bg-[#F0EEFF] border border-[#5b45d9]/30 rounded-xl p-4 text-[13px] text-[#5b45d9] space-y-1">
            <div class="font-bold">Tautan Pemulihan Terkirim</div>
            <div>Kami telah mengirimkan tautan reset kata sandi ke email Anda. Silakan periksa kotak masuk atau spam.</div>
        </div>

        <!-- Forgot Password Form -->
        <form x-show="!sent" @submit.prevent="sent = true" class="space-y-5">
            <!-- Single Email Input -->
            <div class="space-y-2">
                <label for="reset-email" class="block text-[13px] font-bold text-black tracking-tight">
                    Alamat Email Terdaftar
                </label>
                <input id="reset-email" 
                       type="email" 
                       required
                       placeholder="nama@unhas.ac.id"
                       class="w-full bg-[#fafafa] border border-[#d9d9d9] focus:border-[#ff5347] focus:ring-2 focus:ring-[#ff5347]/20 focus:bg-white focus:outline-none rounded-xl px-4 py-3.5 text-[14px] text-black transition-all">
            </div>

            <!-- Full-width primary button to send reset link -->
            <div class="pt-2">
                <button type="submit" 
                        class="w-full bg-[#ff5347] hover:bg-[#e0453a] text-white font-bold text-[15px] rounded-full py-3.5 transition-all duration-300 ease-out hover:-translate-y-0.5 active:scale-95 shadow-none flex items-center justify-center space-x-2 cursor-pointer">
                    <span>Kirim Tautan Reset</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>

        <!-- Ghost Link: Kembali ke Login -->
        <div class="pt-4 border-t border-[#d9d9d9]/60 text-center">
            <a href="{{ url('/login') }}" 
               class="inline-flex items-center space-x-1.5 text-[13px] font-semibold text-black/60 hover:text-black transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Kembali ke Login</span>
            </a>
        </div>

    </div>
</div>
@endsection
