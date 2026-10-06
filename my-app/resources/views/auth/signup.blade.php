@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-8 space-y-6">
    <div class="text-center space-y-2">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-[12px] bg-[#ff5347] text-white font-bold text-2xl mb-2">
            N
        </div>
        <h1 class="text-[28px] font-bold tracking-tight text-black">Daftar Akun Notulis</h1>
        <p class="text-[14px] text-black/60">Daftarkan diri Anda untuk mengakses fitur transkripsi dan rumusan memo otomatis.</p>
    </div>

    <!-- White Feature Card -->
    <div class="bg-white border border-[#d9d9d9] rounded-[12px] p-6 sm:p-8 space-y-5">
        <form action="{{ url('/dashboard') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-[13px] font-semibold text-black mb-1.5">Nama Lengkap & Gelar</label>
                <input type="text" 
                       placeholder="e.g. Andi Muhammad Abigail, S.T." 
                       required
                       class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-black mb-1.5">Unit Kerja / Fakultas / Instansi</label>
                <input type="text" 
                       placeholder="e.g. Departemen Informatika Fakultas Teknik" 
                       required
                       class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-black mb-1.5">Email Kedinasan</label>
                <input type="email" 
                       placeholder="nama@unhas.ac.id" 
                       required
                       class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-black mb-1.5">Kata Sandi Baru</label>
                <input type="password" 
                       placeholder="Minimal 8 karakter" 
                       required
                       class="w-full bg-[#F8F7F3] border border-[#d9d9d9] rounded-[8px] px-3.5 py-2.5 text-[14px] text-black focus:outline-none focus:border-[#ff5347] transition-colors">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-[#ff5347] text-white font-medium text-[15px] rounded-[8px] py-2.5 hover:bg-[#e0453a] transition-colors flex items-center justify-center space-x-2">
                    <span>Buat Akun & Mulai</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>

        <div class="pt-4 border-t border-[#d9d9d9] text-center text-[13px] text-black/60">
            <span>Sudah memiliki akun?</span>
            <a href="{{ url('/login') }}" class="text-[#ff5347] font-semibold ml-1 hover:underline">Masuk Disini</a>
        </div>
    </div>
</div>
@endsection
