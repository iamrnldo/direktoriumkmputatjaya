@extends('layouts.app')

@section('title', 'Katalog Produk')
@section('meta_description', 'Jelajahi berbagai produk dan layanan unggulan dari UMKM Kelurahan Putat Jaya, Surabaya.')

@section('content')
<div class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold mb-2">Katalog Produk</h1>
        <p class="text-blue-200">Jelajahi berbagai produk dan layanan unggulan dari UMKM Putat Jaya</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-8">

        {{-- Mobile Filter Button --}}
        <div class="md:hidden" x-data="{ filterOpen: false }">
            <button @click="filterOpen = true" class="w-full flex items-center justify-center space-x-2 bg-white border border-slate-200 text-slate-700 py-3 rounded-xl font-semibold text-sm shadow-sm hover:bg-slate-50 transition-colors btn-press mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                <span>Filter & Urutkan</span>
                @php $activeCount = count(array_filter(request()->only(['q', 'kategori', 'kategori-umkm', 'harga-min', 'harga-max']))); @endphp
                @if($activeCount > 0)
                <span class="bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full font-bold">{{ $activeCount }}</span>
                @endif
            </button>

            {{-- Mobile Filter Drawer --}}
            <div x-show="filterOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="filterOpen = false" class="fixed inset-0 bg-black/50 z-40" style="display:none;"></div>
            <div x-show="filterOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full" class="fixed bottom-0 inset-x-0 z-50 bg-white rounded-t-3xl shadow-2xl max-h-[85vh] overflow-y-auto custom-scrollbar" style="display:none;">
                <div class="sticky top-0 bg-white px-5 pt-4 pb-3 border-b border-slate-100 flex items-center justify-between rounded-t-3xl z-10">
                    <h3 class="font-bold text-lg text-slate-900">Filter Produk</h3>
                    <button @click="filterOpen = false" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center" aria-label="Tutup filter">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="p-5">
                    <form method="GET" action="{{ route('produk.index') }}">
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pencarian</label>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama produk..." class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Produk</label>
                            <select name="kategori" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Kategori</option>
                                @foreach($productCategories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('kategori') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori UMKM</label>
                            <select name="kategori-umkm" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua UMKM</option>
                                @foreach($umkmCategories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('kategori-umkm') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Rentang Harga</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="harga-min" value="{{ request('harga-min') }}" placeholder="Min" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <input type="number" name="harga-max" value="{{ request('harga-max') }}" placeholder="Max" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Urutkan</label>
                            <select name="urut" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="terbaru" {{ request('urut') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="populer" {{ request('urut') == 'populer' ? 'selected' : '' }}>Terpopuler</option>
                                <option value="harga-asc" {{ request('urut') == 'harga-asc' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="harga-desc" {{ request('urut') == 'harga-desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl text-sm font-bold hover:from-blue-700 hover:to-indigo-700 transition-all btn-press">Terapkan Filter</button>
                        @if(request()->except('page'))
                        <a href="{{ route('produk.index') }}" class="block text-center mt-2.5 text-sm text-gray-500 hover:text-red-600 font-medium transition-colors">✕ Reset Filter</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Filter (Desktop) -->
        <div class="w-full md:w-1/4 hidden md:block">
            <form method="GET" action="{{ route('produk.index') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 sticky top-24">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Filter</h3>
                    @if(request()->except('page'))
                        <a href="{{ route('produk.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Reset</a>
                    @endif
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama produk..." class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Produk</label>
                    <select name="kategori" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Kategori</option>
                        @foreach($productCategories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('kategori') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori UMKM</label>
                    <select name="kategori-umkm" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua UMKM</option>
                        @foreach($umkmCategories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('kategori-umkm') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Harga</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" name="harga-min" value="{{ request('harga-min') }}" placeholder="Min" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <input type="number" name="harga-max" value="{{ request('harga-max') }}" placeholder="Max" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl transition-all font-semibold shadow-md hover:shadow-lg btn-press">Terapkan Filter</button>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="w-full md:w-3/4">
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-gray-100 gap-4">
                <p class="text-gray-600">Menampilkan <span class="font-bold text-gray-900">{{ $products->total() }}</span> Produk</p>
                <form method="GET" action="{{ route('produk.index') }}" class="flex items-center">
                    @foreach(request()->except(['urut', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <label for="urut" class="mr-2 text-sm text-gray-600">Urutkan:</label>
                    <select name="urut" id="urut" onchange="this.form.submit()" class="rounded-xl border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm font-medium">
                        <option value="terbaru" {{ request('urut') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="populer" {{ request('urut') == 'populer' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="harga-asc" {{ request('urut') == 'harga-asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="harga-desc" {{ request('urut') == 'harga-desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </form>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 stagger-children">
                    @foreach($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-16 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">Coba gunakan kata kunci lain atau hapus beberapa filter.</p>
                    <a href="{{ route('produk.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors btn-press">Reset Semua Filter</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
