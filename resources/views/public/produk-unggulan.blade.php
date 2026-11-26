@extends('layouts.app')
@section('title', 'Produk Unggulan')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-gradient-to-br from-indigo-700 to-blue-800 rounded-3xl p-8 sm:p-12 text-white mb-10 shadow-lg relative overflow-hidden">
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-indigo-500 rounded-full filter blur-3xl opacity-30 translate-y-1/2 translate-x-1/3"></div>
            <div class="relative z-10">
                <span class="inline-block py-1 px-3 rounded-full bg-emerald-400 text-emerald-950 text-xs font-bold mb-4 tracking-wider uppercase">Rekomendasi</span>
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-4">Produk Unggulan</h1>
                <p class="text-indigo-100 max-w-2xl text-lg">Pilihan produk-produk terbaik dari UMKM lokal Kelurahan Putat Jaya dengan kualitas terjamin.</p>
            </div>
        </div>

        @if(isset($featuredProducts) && $featuredProducts->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
        
        <div class="mt-10">
            {{ $featuredProducts->links() }}
        </div>
        @else
        <div class="bg-white rounded-2xl p-12 text-center border border-slate-100">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4"><svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Belum ada Produk Unggulan</h3>
            <p class="text-slate-500">Saat ini belum ada data produk yang ditandai sebagai unggulan.</p>
        </div>
        @endif
        
    </div>
</div>
@endsection
