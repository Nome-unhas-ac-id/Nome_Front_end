@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-12 space-y-8">
    <div class="text-center space-y-3">
        <!-- Minimalist Line-Art Brand Icon -->
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-black text-white font-black text-2xl tracking-tighter mx-auto">
            N
        </div>
        <div>
            <h1 class="text-[38px] sm:text-[44px] font-black tracking-tighter text-black leading-tight">
                Masuk ke Nome.
            </h1>
            <p class="text-[15px] text-black/55 mt-1 font-normal">
                Akses ruang kerja notulensi cerdas dan kelola arsip rapat Anda.
            </p>
        </div>
    </div>

    <!-- White Feature Card (Rounded-3xl, Zero Shadow, 1px Border) -->
    <div class="bg-white border border-[#d9d9d9]/80 rounded-3xl p-8 sm:p-10 space-y-6">
        <form action="{{ url('/dashboard') }}" method="GET" class="space-y-5">
            <div class="space-y-1.5">
                <label class="block text-[14px] font-bold text-black">Email Civitas / Kedinasan</label>
                <input type="email" 
                       value="andiabi4925@unhas.ac.id" 
                       required
                       placeholder="nama@unhas.ac.id" 
                       class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-2xl px-4 py-3.5 text-[15px] text-black focus:outline-none focus:bg-white focus:border-black transition-colors">
            </div>

            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="text-[14px] font-bold text-black">Kata Sandi</label>
                    <a href="#" class="text-[12px] text-black/50 hover:text-black transition-colors font-medium">Lupa sandi?</a>
                </div>
                <input type="password" 
                       value="••••••••••••" 
                       required
                       class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-2xl px-4 py-3.5 text-[15px] text-black focus:outline-none focus:bg-white focus:border-black transition-colors">
            </div>

            <div class="flex items-center justify-between text-[13px] pt-1">
                <label class="flex items-center space-x-2.5 cursor-pointer">
                    <input type="checkbox" checked class="rounded border-[#d9d9d9] text-black focus:ring-0">
                    <span class="text-black/70 font-medium">Ingat sesi saya</span>
                </label>
                <span class="text-black/45 text-[12px]">SSO Unhas Aktif</span>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-black text-white font-semibold text-[15px] rounded-full py-3.5 hover:bg-black/85 transition-transform active:scale-95 flex items-center justify-center space-x-2">
                    <span>Masuk ke Workspace</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>

        <div class="pt-4 border-t border-[#d9d9d9]/60 text-center text-[13px] text-black/55">
            <span>Belum memiliki akun notulis resmi?</span>
            <a href="{{ url('/signup') }}" class="text-black font-bold ml-1 hover:underline">Daftar Akun Baru</a>
        </div>
    </div>
</div>
@endsection
