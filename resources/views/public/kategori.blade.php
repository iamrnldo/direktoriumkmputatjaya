@extends('layouts.app')

@section('title', 'Kategori: ' . $category->name)
@section('meta_description', $category->description ?? 'Temukan berbagai UMKM terbaik di kategori ' . $category->name . ' Kelurahan Putat Jaya.')

@section('content')
{{-- Category Hero --}}
<div class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center space-x-2 text-blue-200 text-sm mb-4">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('direktori.umkm') }}" class="hover:text-white transition-colors">Direktori UMKM</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white font-medium">{{ $category->name }}</span>
        </div>
        <div class="flex items-center space-x-5">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-4xl backdrop-blur-sm flex-shrink-0">
                {{ $category->icon_emoji ?? '🏪' }}
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $category->name }}</h1>
                <p class="text-blue-200 mt-1 text-lg">{{ $category->description ?? 'Temukan berbagai UMKM terbaik di kategori ini.' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar / Filter --}}
        <div class="lg:w-64 flex-shrink-0">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-6">
                {{-- Search --}}
                <h3 class="text-sm font-bold text-gray-700 mb-3">Pencarian</h3>
                <form method="GET" action="{{ route('kategori.show', $category->slug) }}" id="category-search-form">
                    <div class="relative mb-5">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari UMKM..."
                            class="w-full pl-4 pr-9 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-6 h-6 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-700">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>

                    {{-- Sort --}}
                    <h3 class="text-sm font-bold text-gray-700 mb-2">Urutkan</h3>
                    <select name="urut" onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white mb-5">
                        <option value="terbaru" {{ request('urut', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="populer" {{ request('urut') == 'populer' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="az" {{ request('urut') == 'az' ? 'selected' : '' }}>A - Z</option>
                    </select>
                </form>

                {{-- Other Categories --}}
                <h3 class="text-sm font-bold text-gray-700 mb-3">Kategori Lain</h3>
                <div class="space-y-1 max-h-72 overflow-y-auto pr-1">
                    @foreach($allCategories as $cat)
                        <a href="{{ route('kategori.show', $cat->slug) }}"
                           class="flex items-center px-3 py-2.5 rounded-xl transition-colors text-sm font-medium {{ $category->id === $cat->id ? 'bg-blue-600 text-white shadow-sm shadow-blue-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span class="mr-2">{{ $cat->icon_emoji ?? '🏪' }}</span>
                            <span class="flex-1">{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex-1">
            <div class="mb-5 flex justify-between items-center bg-white px-5 py-3.5 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-gray-600 text-sm">
                    Menampilkan <span class="font-bold text-gray-900">{{ $umkmList->total() }}</span> UMKM
                    @if(request('q'))<span class="text-blue-600"> untuk "{{ request('q') }}"</span>@endif
                </p>
                <a href="{{ route('direktori.umkm', ['kategori' => $category->slug]) }}"
                   class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center">
                    Lihat di Direktori
                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if($umkmList->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($umkmList as $umkm)
                        @include('components.umkm-card', ['umkm' => $umkm])
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $umkmList->links('components.pagination') }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4"><svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada UMKM</h3>
                    <p class="text-gray-500 text-sm mb-5">Belum ada UMKM yang terdaftar di kategori ini atau cocok dengan pencarian Anda.</p>
                    <a href="{{ route('kategori.show', $category->slug) }}"
                       class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-xl text-sm hover:bg-blue-700 transition-colors">
                        Reset Pencarian
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
