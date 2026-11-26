@extends('layouts.app')

@section('title', 'Direktori UMKM')
@section('meta_description', 'Temukan semua UMKM aktif di Kelurahan Putat Jaya, Surabaya.')

@section('content')
<div class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold mb-2">Direktori UMKM</h1>
        <p class="text-blue-200">{{ isset($umkmList) ? $umkmList->total() : 0 }} UMKM ditemukan di Kelurahan Putat Jaya</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Mobile Filter Button --}}
        <div class="lg:hidden" x-data="{ filterOpen: false }">
            <button @click="filterOpen = true" class="w-full flex items-center justify-center space-x-2 bg-white border border-slate-200 text-slate-700 py-3 rounded-xl font-semibold text-sm shadow-sm hover:bg-slate-50 transition-colors btn-press mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                <span>Filter & Urutkan</span>
                @php $activeFilterCount = count(array_filter(request()->only(['q', 'kategori', 'unggulan', 'punya-produk']))); @endphp
                @if($activeFilterCount > 0)
                <span class="bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full font-bold">{{ $activeFilterCount }}</span>
                @endif
            </button>

            {{-- Mobile Filter Drawer --}}
            <div x-show="filterOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="filterOpen = false" class="fixed inset-0 bg-black/50 z-40" style="display:none;"></div>
            <div x-show="filterOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full" class="fixed bottom-0 inset-x-0 z-50 bg-white rounded-t-3xl shadow-2xl max-h-[85vh] overflow-y-auto custom-scrollbar" style="display:none;">
                <div class="sticky top-0 bg-white px-5 pt-4 pb-3 border-b border-slate-100 flex items-center justify-between rounded-t-3xl z-10">
                    <h3 class="font-bold text-lg text-slate-900">Filter & Urutkan</h3>
                    <button @click="filterOpen = false" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center" aria-label="Tutup filter">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="p-5">
                    <form action="{{ route('direktori.umkm') }}" method="GET">
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Cari UMKM</label>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama usaha atau pemilik..." class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <div class="space-y-1.5 max-h-48 overflow-y-auto custom-scrollbar">
                                <label class="flex items-center p-2.5 rounded-xl hover:bg-gray-50 cursor-pointer {{ !request('kategori') ? 'bg-blue-50 ring-1 ring-blue-200' : '' }}">
                                    <input type="radio" name="kategori" value="" {{ !request('kategori') ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2.5 text-sm font-medium">Semua Kategori</span>
                                </label>
                                @if(isset($categories))
                                @foreach($categories as $cat)
                                <label class="flex items-center p-2.5 rounded-xl hover:bg-gray-50 cursor-pointer {{ request('kategori') === $cat->slug ? 'bg-blue-50 ring-1 ring-blue-200' : '' }}">
                                    <input type="radio" name="kategori" value="{{ $cat->slug }}" {{ request('kategori') === $cat->slug ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2.5 text-sm flex-1">{{ $cat->icon ?? '' }} {{ $cat->name }}</span>
                                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ $cat->umkm_profiles_count }}</span>
                                </label>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Filter Tambahan</label>
                            <label class="flex items-center p-2.5 rounded-xl hover:bg-gray-50 cursor-pointer mb-1.5 {{ request('unggulan') ? 'bg-amber-50 ring-1 ring-amber-200' : '' }}">
                                <input type="checkbox" name="unggulan" value="1" {{ request('unggulan') ? 'checked' : '' }} class="text-amber-500 rounded focus:ring-amber-400">
                                <span class="ml-2.5 text-sm">UMKM Unggulan</span>
                            </label>
                            <label class="flex items-center p-2.5 rounded-xl hover:bg-gray-50 cursor-pointer {{ request('punya-produk') ? 'bg-blue-50 ring-1 ring-blue-200' : '' }}">
                                <input type="checkbox" name="punya-produk" value="1" {{ request('punya-produk') ? 'checked' : '' }} class="text-blue-600 rounded focus:ring-blue-500">
                                <span class="ml-2.5 text-sm">Memiliki Produk</span>
                            </label>
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Urutkan</label>
                            <select name="urut" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                                <option value="terbaru" {{ ($sort ?? 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="az" {{ ($sort ?? '') === 'az' ? 'selected' : '' }}>A - Z</option>
                                <option value="za" {{ ($sort ?? '') === 'za' ? 'selected' : '' }}>Z - A</option>
                                <option value="populer" {{ ($sort ?? '') === 'populer' ? 'selected' : '' }}>Paling Populer</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl text-sm font-bold hover:from-blue-700 hover:to-indigo-700 transition-all btn-press">Terapkan Filter</button>
                        @if(request()->hasAny(['q', 'kategori', 'unggulan', 'punya-produk', 'urut']))
                        <a href="{{ route('direktori.umkm') }}" class="block text-center mt-2.5 text-sm text-gray-500 hover:text-red-600 font-medium transition-colors">✕ Reset Semua Filter</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar Filters (Desktop) --}}
        <aside class="lg:w-64 flex-shrink-0 hidden lg:block">
            <form id="filter-form" action="{{ route('direktori.umkm') }}" method="GET">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Cari UMKM</label>
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama usaha atau pemilik..." class="w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Kategori</label>
                    <div class="space-y-1.5 max-h-64 overflow-y-auto pr-1 custom-scrollbar">
                        <label class="flex items-center p-2.5 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors {{ !request('kategori') ? 'bg-blue-50 ring-1 ring-blue-200' : '' }}">
                            <input type="radio" name="kategori" value="" {{ !request('kategori') ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500" onchange="document.getElementById('filter-form').submit()">
                            <span class="ml-2.5 text-sm font-medium {{ !request('kategori') ? 'text-blue-700' : 'text-gray-700' }}">Semua Kategori</span>
                        </label>
                        @if(isset($categories))
                        @foreach($categories as $cat)
                        <label class="flex items-center p-2.5 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors {{ request('kategori') === $cat->slug ? 'bg-blue-50 ring-1 ring-blue-200' : '' }}">
                            <input type="radio" name="kategori" value="{{ $cat->slug }}" {{ request('kategori') === $cat->slug ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500" onchange="document.getElementById('filter-form').submit()">
                            <span class="ml-2.5 text-sm flex-1 {{ request('kategori') === $cat->slug ? 'text-blue-700 font-semibold' : 'text-gray-700' }}">{{ $cat->icon ?? '' }} {{ $cat->name }}</span>
                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-medium">{{ $cat->umkm_profiles_count }}</span>
                        </label>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Filter Tambahan</label>
                    <label class="flex items-center p-2.5 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors mb-1.5 {{ request('unggulan') ? 'bg-amber-50 ring-1 ring-amber-200' : '' }}">
                        <input type="checkbox" name="unggulan" value="1" {{ request('unggulan') ? 'checked' : '' }} class="text-amber-500 rounded focus:ring-amber-400" onchange="document.getElementById('filter-form').submit()">
                        <span class="ml-2.5 text-sm {{ request('unggulan') ? 'text-amber-700 font-semibold' : 'text-gray-700' }}">UMKM Unggulan</span>
                    </label>
                    <label class="flex items-center p-2.5 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors {{ request('punya-produk') ? 'bg-blue-50 ring-1 ring-blue-200' : '' }}">
                        <input type="checkbox" name="punya-produk" value="1" {{ request('punya-produk') ? 'checked' : '' }} class="text-blue-600 rounded focus:ring-blue-500" onchange="document.getElementById('filter-form').submit()">
                        <span class="ml-2.5 text-sm {{ request('punya-produk') ? 'text-blue-700 font-semibold' : 'text-gray-700' }}">Memiliki Produk</span>
                    </label>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Urutkan</label>
                    <select name="urut" onchange="document.getElementById('filter-form').submit()" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="terbaru" {{ ($sort ?? 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="az" {{ ($sort ?? '') === 'az' ? 'selected' : '' }}>A - Z</option>
                        <option value="za" {{ ($sort ?? '') === 'za' ? 'selected' : '' }}>Z - A</option>
                        <option value="populer" {{ ($sort ?? '') === 'populer' ? 'selected' : '' }}>Paling Populer</option>
                    </select>
                </div>
                <button type="submit" id="apply-filter-btn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl text-sm font-bold hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md shadow-blue-200 btn-press">Terapkan Filter</button>
                @if(request()->hasAny(['q', 'kategori', 'unggulan', 'punya-produk', 'urut']))
                <a href="{{ route('direktori.umkm') }}" class="block text-center mt-2.5 text-sm text-gray-500 hover:text-red-600 font-medium transition-colors">✕ Reset Semua Filter</a>
                @endif
            </form>
        </aside>

        {{-- UMKM Grid --}}
        <div class="flex-1">
            @if(request()->hasAny(['q', 'kategori', 'unggulan', 'punya-produk']))
            <div class="flex flex-wrap gap-2 mb-5">
                <span class="text-xs font-semibold text-gray-500 flex items-center mr-1">Filter aktif:</span>
                @if(request('q'))
                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                    Pencarian: "{{ request('q') }}"
                    <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="ml-1.5 hover:text-blue-900">✕</a>
                </span>
                @endif
                @if(request('kategori'))
                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                    Kategori: {{ request('kategori') }}
                    <a href="{{ request()->fullUrlWithQuery(['kategori' => null]) }}" class="ml-1.5 hover:text-blue-900">✕</a>
                </span>
                @endif
                @if(request('unggulan'))
                <span class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium">
                    Unggulan
                    <a href="{{ request()->fullUrlWithQuery(['unggulan' => null]) }}" class="ml-1.5 hover:text-amber-900">✕</a>
                </span>
                @endif
                @if(request('punya-produk'))
                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                    Punya Produk
                    <a href="{{ request()->fullUrlWithQuery(['punya-produk' => null]) }}" class="ml-1.5 hover:text-blue-900">✕</a>
                </span>
                @endif
            </div>
            @endif

            @if(isset($umkmList) && $umkmList->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 stagger-children">
                    @foreach($umkmList as $umkm)
                    @include('components.umkm-card', ['umkm' => $umkm])
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $umkmList->links('components.pagination') }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-4"><svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
                    <h3 class="text-lg font-bold text-gray-700">UMKM tidak ditemukan</h3>
                    <p class="text-gray-400 mt-1 text-sm">Coba ubah kata kunci atau filter pencarian Anda.</p>
                    <a href="{{ route('direktori.umkm') }}" class="inline-block mt-5 px-6 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors btn-press">Reset Pencarian</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
