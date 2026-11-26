@extends('layouts.app')
@section('title', 'UMKM Unggulan')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-gradient-to-br from-blue-700 to-indigo-800 rounded-3xl p-8 sm:p-12 text-white mb-10 shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full filter blur-3xl opacity-20 -translate-y-1/2 translate-x-1/3"></div>
            <div class="relative z-10">
                <span class="inline-block py-1 px-3 rounded-full bg-amber-500 text-amber-950 text-xs font-bold mb-4 tracking-wider uppercase">Pilihan Terbaik</span>
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-4">UMKM Unggulan Putat Jaya</h1>
                <p class="text-blue-100 max-w-2xl text-lg">Temukan daftar usaha lokal terpilih yang telah diverifikasi dan memiliki kualitas terbaik di Kelurahan Putat Jaya.</p>
            </div>
        </div>

        @if(isset($featuredUmkm) && $featuredUmkm->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredUmkm as $umkm)
                @include('components.umkm-card', ['umkm' => $umkm])
            @endforeach
        </div>
        
        <div class="mt-10">
            {{ $featuredUmkm->links() }}
        </div>
        @else
        <div class="bg-white rounded-2xl p-12 text-center border border-slate-100">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4"><svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Belum ada UMKM Unggulan</h3>
            <p class="text-slate-500">Saat ini belum ada data UMKM yang ditandai sebagai unggulan.</p>
        </div>
        @endif
        
    </div>
</div>
@endsection
