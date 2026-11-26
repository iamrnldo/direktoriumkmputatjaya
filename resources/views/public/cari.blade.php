@extends('layouts.app')
@section('title', request('q') ? 'Pencarian: ' . request('q') : 'Pencarian')
@section('meta_description', 'Cari UMKM dan produk di Kelurahan Putat Jaya, Surabaya.')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900">
                @if(request('q'))
                Hasil Pencarian
                @else
                Cari UMKM & Produk
                @endif
            </h1>
            @if(request('q'))
            <p class="text-slate-500 mt-2">Menampilkan hasil untuk: <span class="font-bold text-slate-900">"{{ request('q') }}"</span></p>
            @else
            <p class="text-slate-500 mt-2">Temukan UMKM dan produk lokal di Kelurahan Putat Jaya</p>
            @endif
        </div>

        {{-- Search Form --}}
        <form action="{{ route('cari') }}" method="GET" class="mb-8 max-w-2xl">
            <div class="flex bg-white rounded-xl shadow-sm border border-slate-200 p-1">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari UMKM atau produk..." class="flex-1 px-4 py-2.5 bg-transparent outline-none text-slate-900 text-sm" autocomplete="off">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-blue-700 transition-colors btn-press">Cari</button>
            </div>
        </form>

        @if(!request('q'))
        {{-- Suggested Searches --}}
        <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-sm">
            <div class="text-center mb-6">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 text-lg mb-1">Mulai Pencarian</h3>
                <p class="text-slate-500 text-sm">Ketik kata kunci atau pilih dari pencarian populer:</p>
            </div>
            <div class="flex flex-wrap justify-center gap-2">
                @php $popularSearches = ['Makanan', 'Minuman', 'Kerajinan', 'Fashion', 'Jasa', 'Kuliner', 'Kue', 'Aksesoris', 'Snack', 'Konveksi']; @endphp
                @foreach($popularSearches as $search)
                <a href="{{ route('cari', ['q' => $search]) }}" class="px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl text-sm font-medium transition-colors btn-press">{{ $search }}</a>
                @endforeach
            </div>
            <div class="mt-6 pt-5 border-t border-slate-100 flex flex-wrap justify-center gap-3">
                <a href="{{ route('direktori.umkm') }}" class="inline-flex items-center text-sm text-slate-600 hover:text-blue-600 font-medium transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Lihat Direktori UMKM
                </a>
                <a href="{{ route('produk.index') }}" class="inline-flex items-center text-sm text-slate-600 hover:text-blue-600 font-medium transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Lihat Katalog Produk
                </a>
            </div>
        </div>
        @else
        {{-- Results with Tabs --}}
        @php
            $umkmCount = isset($umkmResults) ? $umkmResults->count() : 0;
            $produkCount = isset($productResults) ? $productResults->count() : 0;
            $totalCount = $umkmCount + $produkCount;
        @endphp

        @if($totalCount === 0)
        {{-- No Results --}}
        <div class="bg-white rounded-2xl p-12 border border-slate-100 shadow-sm text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-5">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Tidak Ada Hasil</h3>
            <p class="text-slate-500 mb-6 max-w-md mx-auto">Kami tidak menemukan UMKM atau produk dengan kata kunci "<strong>{{ request('q') }}</strong>".</p>
            <div class="space-y-3">
                <p class="text-sm text-slate-500 font-medium">Coba pencarian lain:</p>
                <div class="flex flex-wrap justify-center gap-2">
                    @php $altSearches = ['Makanan', 'Kuliner', 'Jasa', 'Fashion', 'Kerajinan']; @endphp
                    @foreach($altSearches as $alt)
                    <a href="{{ route('cari', ['q' => $alt]) }}" class="px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl text-sm font-medium transition-colors btn-press">{{ $alt }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        {{-- Tab Navigation --}}
        <div x-data="{ tab: '{{ $umkmCount > 0 ? 'umkm' : 'produk' }}' }">
            <div class="flex space-x-1 bg-white rounded-xl p-1 max-w-sm mb-6 shadow-sm border border-slate-100">
                <button @click="tab = 'umkm'" :class="tab === 'umkm' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-50'" class="flex-1 py-2.5 px-4 rounded-lg text-sm font-semibold transition-all btn-press">
                    UMKM <span class="ml-1 text-xs opacity-80">({{ $umkmCount }})</span>
                </button>
                <button @click="tab = 'produk'" :class="tab === 'produk' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-50'" class="flex-1 py-2.5 px-4 rounded-lg text-sm font-semibold transition-all btn-press">
                    Produk <span class="ml-1 text-xs opacity-80">({{ $produkCount }})</span>
                </button>
            </div>

            {{-- UMKM Results --}}
            <div x-show="tab === 'umkm'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                @if($umkmCount > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger-children">
                    @foreach($umkmResults as $umkm)
                        @include('components.umkm-card', ['umkm' => $umkm])
                    @endforeach
                </div>
                @else
                <div class="bg-white rounded-2xl p-8 text-center border border-slate-100">
                    <svg class="w-12 h-12 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <p class="text-slate-500 font-medium">Tidak ada UMKM yang cocok.</p>
                    <a href="{{ route('direktori.umkm') }}" class="inline-block mt-3 text-sm text-blue-600 hover:underline font-semibold">Lihat semua UMKM →</a>
                </div>
                @endif
            </div>

            {{-- Product Results --}}
            <div x-show="tab === 'produk'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="{{ $umkmCount > 0 ? 'display:none;' : '' }}">
                @if($produkCount > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 stagger-children">
                    @foreach($productResults as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
                @else
                <div class="bg-white rounded-2xl p-8 text-center border border-slate-100">
                    <svg class="w-12 h-12 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <p class="text-slate-500 font-medium">Tidak ada produk yang cocok.</p>
                    <a href="{{ route('produk.index') }}" class="inline-block mt-3 text-sm text-blue-600 hover:underline font-semibold">Lihat semua produk →</a>
                </div>
                @endif
            </div>
        </div>
        @endif
        @endif

    </div>
</div>
@endsection
