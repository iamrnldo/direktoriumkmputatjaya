@extends('layouts.app')
@section('title', '403 - Akses Ditolak')
@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="text-8xl font-black text-red-100 mb-4">403</div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Akses Ditolak</h1>
        <p class="text-gray-500 mb-8">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
