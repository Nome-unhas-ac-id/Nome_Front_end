@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto my-14 bg-white border border-[#d9d9d9] rounded-3xl p-9 space-y-6">
    <h1 class="text-3xl font-black tracking-tight">{{ $heading }}</h1>
    <p class="text-sm text-black/60 leading-relaxed">{{ $message }}</p>
    <a href="{{ route('login') }}" class="inline-block rounded-full bg-[#ff5347] text-white px-6 py-3 text-sm font-semibold">Masuk ke Akun</a>
</div>
@endsection
