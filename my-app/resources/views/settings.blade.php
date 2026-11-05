@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto space-y-8 pt-6 pb-20">
    <h1 class="text-4xl sm:text-5xl font-black tracking-tighter">Pengaturan Akun.</h1>
    <div x-show="isLoggedIn" x-cloak class="bg-white border border-[#d9d9d9] rounded-3xl p-8 space-y-6">
        <h2 class="font-bold text-xl">Profil Pengguna</h2>
        <dl class="grid grid-cols-3 gap-4 text-sm"><dt>Nama</dt><dd class="col-span-2" x-text="user?.name"></dd><dt>Email</dt><dd class="col-span-2" x-text="user?.email"></dd></dl>
        <p class="text-sm text-black/55">Untuk memperbarui identitas atau kata sandi, hubungi pengelola akun.</p>
        <p class="text-sm text-black/55">Memo tersimpan di akun Anda. Sesi login disimpan pada tab ini dan berakhir paling lambat setelah tujuh hari.</p>
        <button type="button" @click="logout()" class="rounded-full border border-red-200 px-6 py-2.5 text-red-700 text-sm">Keluar dari Akun</button>
    </div>
    <p x-show="!isLoggedIn && !authLoading">Masuk untuk melihat akun. <a href="{{ route('login') }}" class="underline">Masuk ke Akun</a></p>
</div>
@endsection
