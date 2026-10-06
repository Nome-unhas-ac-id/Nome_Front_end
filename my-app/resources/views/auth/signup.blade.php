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
                Daftar Akun Baru.
            </h1>
            <p class="text-[15px] text-black/55 mt-1 font-normal">
                Daftar sekarang untuk mulai merangkum catatan dan obrolan rapat secara otomatis.
            </p>
        </div>
    </div>

    <!-- White Feature Card (Rounded-3xl, Zero Shadow, 1px Border) -->
    <div class="bg-white border border-[#d9d9d9]/80 rounded-3xl p-8 sm:p-10 space-y-6">
        <form action="{{ url('/dashboard') }}" method="GET" class="space-y-4">
            <div class="space-y-1.5">
                <label class="block text-[14px] font-bold text-black">Nama Lengkap</label>
                <input type="text" 
                       placeholder="Contoh: Rian Pratama" 
                       required
                       class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-2xl px-4 py-3 text-[14px] text-black focus:outline-none focus:bg-white focus:border-black transition-colors">
            </div>

            <div class="space-y-1.5">
                <label class="block text-[14px] font-bold text-black">Tim / Organisasi</label>
                <input type="text" 
                       placeholder="Contoh: Tim Produk & Desain" 
                       required
                       class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-2xl px-4 py-3 text-[14px] text-black focus:outline-none focus:bg-white focus:border-black transition-colors">
            </div>

            <div class="space-y-1.5">
                <label class="block text-[14px] font-bold text-black">Email Pengguna</label>
                <input type="email" 
                       placeholder="nama@contoh.id" 
                       required
                       class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-2xl px-4 py-3 text-[14px] text-black focus:outline-none focus:bg-white focus:border-black transition-colors">
            </div>

            <div class="space-y-1.5">
                <label class="block text-[14px] font-bold text-black">Kata Sandi Baru</label>
                <input type="password" 
                       placeholder="Minimal 8 karakter" 
                       required
                       class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-2xl px-4 py-3 text-[14px] text-black focus:outline-none focus:bg-white focus:border-black transition-colors">
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full bg-[#ff5347] hover:bg-[#e0453a] text-white font-semibold text-[15px] rounded-full py-3.5 transition-all duration-300 ease-out hover:-translate-y-0.5 hover:shadow-sm active:scale-95 flex items-center justify-center space-x-2">
                    <span>Buat Akun & Mulai</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>

        <div class="pt-4 border-t border-[#d9d9d9]/60 text-center text-[13px] text-black/55">
            <span>Sudah memiliki akun?</span>
            <a href="{{ url('/login') }}" class="text-[#ff5347] font-bold ml-1 hover:underline">Masuk Disini</a>
        </div>
    </div>
</div>
@endsection
