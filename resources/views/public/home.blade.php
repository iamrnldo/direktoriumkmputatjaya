@extends('layouts.app')
@section('title', 'Beranda')
@section('meta_description', 'Temukan UMKM, produk lokal, dan informasi usaha terbaik di Kelurahan Putat Jaya, Surabaya.')

@section('content')

{{-- HERO SECTION --}}
<section class="relative overflow-hidden bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 text-white">
    {{-- Decorative bg --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl opacity-20 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-600 rounded-full filter blur-3xl opacity-25 translate-x-1/3 translate-y-1/3"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-white/15 backdrop-blur-sm text-white mb-6 border border-white/20">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-300 mr-2 animate-pulse"></span>
                Portal Resmi · Putat Jaya, Kec. Sawahan, Surabaya
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight tracking-tight">
                Direktori UMKM
                <span class="block text-blue-200">Kelurahan Putat Jaya</span>
            </h1>
            <p class="text-lg sm:text-xl text-blue-100 mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform digital terpadu untuk menemukan, mempromosikan, dan mendukung UMKM lokal Kelurahan Putat Jaya, Surabaya.
            </p>

            {{-- Search Bar --}}
            <form action="{{ route('cari') }}" method="GET" class="max-w-2xl mx-auto">
                <div class="flex bg-white/10 backdrop-blur-md rounded-2xl p-1.5 shadow-2xl border border-white/20">
                    <div class="flex items-center flex-1 px-4">
                        <svg class="w-5 h-5 text-blue-200 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="q" placeholder="Cari nama UMKM, produk, atau pemilik..."
                            class="flex-1 bg-transparent outline-none text-white placeholder-blue-200 text-sm py-2.5"
                            autocomplete="off">
                    </div>
                    <button type="submit" class="bg-white text-blue-700 hover:bg-blue-50 px-6 py-2.5 rounded-xl font-bold text-sm transition-colors flex items-center space-x-2 flex-shrink-0 btn-press">
                        <span>Cari</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>

            {{-- Search Suggestion Chips --}}
            <div class="flex flex-wrap justify-center gap-2 mt-5">
                <span class="text-xs text-blue-200/70">Populer:</span>
                @php $suggestions = ['Kuliner', 'Kerajinan', 'Fashion', 'Jasa', 'Makanan Ringan']; @endphp
                @foreach($suggestions as $s)
                <a href="{{ route('cari', ['q' => $s]) }}" class="px-3 py-1 bg-white/5 hover:bg-white/15 border border-white/10 rounded-full text-xs text-blue-100 transition-all">{{ $s }}</a>
                @endforeach
            </div>

            {{-- Quick Links --}}
            <div class="flex flex-wrap justify-center gap-3 mt-6">
                <a href="{{ route('direktori.umkm') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-sm font-semibold transition-all backdrop-blur-sm btn-press">Semua UMKM</a>
                <a href="{{ route('peta-umkm') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-sm font-semibold transition-all backdrop-blur-sm btn-press">Peta UMKM</a>
                <a href="{{ route('umkm-unggulan') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-sm font-semibold transition-all backdrop-blur-sm btn-press">UMKM Unggulan</a>
                <a href="{{ route('produk.index') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-sm font-semibold transition-all backdrop-blur-sm btn-press">Produk Lokal</a>
            </div>
        </div>
    </div>
</section>

{{-- BANNER CAROUSEL --}}
@if(isset($activeBanners) && $activeBanners->count())
<section class="bg-white py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php $bannerCount = $activeBanners->count(); @endphp
        <div
            x-data="{
                current: 0,
                total: {{ $bannerCount }},
                timer: null,
                interval: 5000,
                progress: 0,
                progressTimer: null,
                init() {
                    this.startAuto();
                },
                startAuto() {
                    this.stopAuto();
                    this.startProgress();
                    this.timer = setInterval(() => { this.next(); }, this.interval);
                },
                stopAuto() {
                    clearInterval(this.timer);
                    clearInterval(this.progressTimer);
                    this.progress = 0;
                },
                startProgress() {
                    this.progress = 0;
                    clearInterval(this.progressTimer);
                    const steps = 100;
                    const stepTime = this.interval / steps;
                    this.progressTimer = setInterval(() => {
                        this.progress = Math.min(this.progress + 1, 100);
                    }, stepTime);
                },
                goTo(index) {
                    this.current = index;
                    this.startAuto();
                },
                prev() {
                    this.current = (this.current - 1 + this.total) % this.total;
                    this.startAuto();
                },
                next() {
                    this.current = (this.current + 1) % this.total;
                    this.startProgress();
                }
            }"
            @mouseenter="stopAuto()"
            @mouseleave="startAuto()"
            class="relative rounded-2xl overflow-hidden shadow-xl group"
        >
            {{-- Slides wrapper — fixed-height container prevents collapse on Alpine init --}}
            <div class="relative w-full" style="height: clamp(14rem, 40vw, 26rem);">
                @foreach($activeBanners as $i => $banner)
                <div
                    x-show="current === {{ $i }}"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-[1.02]"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-[0.98]"
                    class="absolute inset-0 w-full h-full"
                    @if($i > 0) x-cloak @endif
                >
                    @php
                        $hasCta = !empty($banner->cta_label) && !empty($banner->cta_url);
                        $hasTitle = !empty($banner->title);
                    @endphp
                    <div class="relative w-full h-full">
                        @if($banner->image_path && Storage::disk('public')->exists($banner->image_path))
                        <img
                            src="{{ Storage::disk('public')->url($banner->image_path) }}"
                            alt="{{ $banner->title ?? 'Banner' }}"
                            class="w-full h-full object-cover"
                        >
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-600 to-indigo-700"></div>
                        @endif

                        {{-- Gradient overlay --}}
                        @if($hasTitle || $hasCta)
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                        @endif

                        {{-- Content overlay --}}
                        @if($hasTitle || $hasCta)
                        <div class="absolute bottom-0 inset-x-0 p-6 sm:p-8 md:p-10">
                            @if($hasTitle)
                            <h3 class="text-white font-extrabold text-xl sm:text-2xl md:text-3xl leading-tight drop-shadow-sm mb-1">
                                {{ $banner->title }}
                            </h3>
                            @endif
                            @if(!empty($banner->description))
                            <p class="text-white/80 text-sm sm:text-base mt-1 mb-4 max-w-xl line-clamp-2">
                                {{ $banner->description }}
                            </p>
                            @endif
                            @if($hasCta)
                            <a
                                href="{{ $banner->cta_url }}"
                                class="inline-flex items-center px-5 py-2.5 bg-white text-blue-700 font-bold text-sm rounded-xl shadow-lg hover:bg-blue-50 hover:scale-105 transition-all duration-200 group/btn"
                            >
                                {{ $banner->cta_label }}
                                <svg class="w-4 h-4 ml-1.5 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Progress bar --}}
            @if($bannerCount > 1)
            <div class="absolute top-0 inset-x-0 h-0.5 bg-white/20 z-20">
                <div
                    class="h-full bg-white/80 transition-none"
                    :style="'width: ' + progress + '%'"
                ></div>
            </div>

            {{-- Prev button --}}
            <button
                @click="prev()"
                class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center hover:bg-white hover:scale-110 transition-all duration-200 shadow-lg opacity-0 group-hover:opacity-100"
                aria-label="Slide sebelumnya"
            >
                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            {{-- Next button --}}
            <button
                @click="next()"
                class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center hover:bg-white hover:scale-110 transition-all duration-200 shadow-lg opacity-0 group-hover:opacity-100"
                aria-label="Slide berikutnya"
            >
                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- Dot indicators --}}
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center space-x-1.5">
                @foreach($activeBanners as $i => $banner)
                <button
                    @click="goTo({{ $i }})"
                    :class="current === {{ $i }}
                        ? 'w-6 h-2 bg-white rounded-full'
                        : 'w-2 h-2 bg-white/50 rounded-full hover:bg-white/80'"
                    class="transition-all duration-300"
                    aria-label="Slide {{ $i + 1 }}"
                ></button>
                @endforeach
            </div>

            {{-- Slide counter --}}
            <div class="absolute top-3 right-3 z-20 px-2.5 py-1 bg-black/40 backdrop-blur-sm rounded-full text-white text-xs font-semibold">
                <span x-text="current + 1"></span> / {{ $bannerCount }}
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- STATS BAR with Count-up Animation --}}
<section class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @php
                $statItems = [
                    ['value' => $stats['total_umkm_aktif'] ?? 0, 'label' => 'UMKM Aktif', 'color' => 'text-blue-600', 'icon' => '🏪'],
                    ['value' => $stats['total_produk'] ?? 0, 'label' => 'Produk Terdaftar', 'color' => 'text-indigo-600', 'icon' => '📦'],
                    ['value' => $stats['total_kategori'] ?? 0, 'label' => 'Kategori Usaha', 'color' => 'text-blue-600', 'icon' => '📂'],
                    ['value' => $stats['total_umkm_unggulan'] ?? 0, 'label' => 'UMKM Unggulan', 'color' => 'text-indigo-600', 'icon' => '⭐'],
                ];
            @endphp
            @foreach($statItems as $stat)
            <div x-data="{ count: 0, target: {{ $stat['value'] }}, done: false }"
                 x-intersect.once="let start = 0; const step = () => { start += Math.ceil(target/40); if(start >= target) { count = target; done = true; return; } count = start; requestAnimationFrame(step); }; step();"
                 class="text-center">
                <div class="text-2xl mb-1">{{ $stat['icon'] }}</div>
                <div class="text-3xl sm:text-4xl font-extrabold {{ $stat['color'] }}" x-text="count.toLocaleString('id-ID')">0</div>
                <div class="text-sm text-slate-500 mt-1 font-medium">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CATEGORIES --}}
@if(isset($categories) && $categories->count())
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kategori Usaha</h2>
            <p class="text-slate-500 mt-3 text-lg">Temukan UMKM berdasarkan jenis usaha yang Anda butuhkan</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 stagger-children">
            @foreach($categories as $category)
            <a href="{{ route('kategori.show', $category->slug) }}"
               class="group bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-100 hover:border-blue-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 flex items-center justify-center text-3xl mb-4 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                    <span>{{ $category->icon_emoji ?? '🏪' }}</span>
                </div>
                <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition-colors">{{ $category->name }}</h3>
                <p class="text-xs text-slate-400 mt-1 font-medium">{{ $category->umkm_profiles_count ?? 0 }} UMKM</p>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('direktori.umkm') }}" class="inline-flex items-center px-6 py-3 border border-blue-600 text-blue-600 rounded-xl text-sm font-bold hover:bg-blue-600 hover:text-white transition-all btn-press">
                Lihat Semua Direktori
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>
@endif

{{-- NEWEST UMKM --}}
@if(isset($newestUmkm) && $newestUmkm->count())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Baru Bergabung</h2>
                <p class="text-slate-500 mt-2">UMKM terbaru yang bergabung di platform kami</p>
            </div>
            <a href="{{ route('direktori.umkm', ['urut' => 'terbaru']) }}" class="hidden sm:flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                Lihat Semua <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger-children">
            @foreach($newestUmkm as $umkm)
            @include('components.umkm-card', ['umkm' => $umkm])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- FEATURED UMKM --}}
@if(isset($featuredUmkm) && $featuredUmkm->count())
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">UMKM Unggulan</h2>
                <p class="text-slate-500 mt-2">Usaha terpilih dan terverifikasi resmi oleh Kelurahan</p>
            </div>
            <a href="{{ route('umkm-unggulan') }}" class="hidden sm:flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                Lihat Semua <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger-children">
            @foreach($featuredUmkm as $umkm)
            @include('components.umkm-card', ['umkm' => $umkm])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- FEATURED PRODUCTS --}}
@if(isset($featuredProducts) && $featuredProducts->count())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Produk Unggulan</h2>
                <p class="text-slate-500 mt-2">Produk lokal pilihan dari UMKM Putat Jaya</p>
            </div>
            <a href="{{ route('produk.index') }}" class="hidden sm:flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                Lihat Semua <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 stagger-children">
            @foreach($featuredProducts as $product)
            @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- LATEST REVIEWS --}}
@if(isset($latestReviews) && $latestReviews->count())
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Apa Kata Mereka?</h2>
            <p class="text-slate-500 mt-2">Ulasan terbaru dari pengunjung UMKM Putat Jaya</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger-children">
            @foreach($latestReviews as $review)
            <div class="bg-white rounded-2xl p-5 border border-slate-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $review->user->name ?? 'Pengguna' }}</p>
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                    </div>
                </div>
                @if($review->comment)
                <p class="text-sm text-slate-600 line-clamp-3 mb-3 italic">"{{ $review->comment }}"</p>
                @endif
                @if($review->umkmProfile)
                <a href="{{ route('umkm.show', $review->umkmProfile->slug ?? '') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">{{ $review->umkmProfile->name ?? '' }} →</a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- MAP CTA --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-10 sm:p-16 text-white">
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500 rounded-full filter blur-3xl opacity-30 translate-x-1/3 -translate-y-1/3"></div>
            <div class="relative z-10 text-center">
                <div class="w-14 h-14 mx-auto mb-5 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold mb-3 tracking-tight">Temukan UMKM di Sekitar Anda</h2>
                <p class="text-blue-100 mb-8 max-w-xl mx-auto text-lg">Gunakan peta interaktif untuk menemukan UMKM terdekat di Kelurahan Putat Jaya secara visual dan real-time.</p>
                <a href="{{ route('peta-umkm') }}" class="inline-flex items-center px-8 py-3.5 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/20 btn-press">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Buka Peta UMKM
                </a>
            </div>
        </div>
    </div>
</section>

{{-- UPCOMING EVENTS --}}
@if(isset($upcomingEvents) && $upcomingEvents->count())
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Event Mendatang</h2>
                <p class="text-slate-500 mt-2">Kegiatan dan acara UMKM Putat Jaya</p>
            </div>
            <a href="{{ route('event.index') }}" class="hidden sm:flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                Lihat Semua <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 stagger-children">
            @foreach($upcomingEvents as $event)
            <a href="{{ route('event.show', $event->slug) }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                @if($event->cover_image && Storage::disk('public')->exists($event->cover_image))
                <img src="{{ Storage::disk('public')->url($event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-full h-44 bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                @endif
                <div class="p-5">
                    <div class="flex items-center text-xs text-blue-600 font-bold mb-2">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ \Carbon\Carbon::parse($event->event_date ?? $event->start_date)->isoFormat('D MMMM Y') }}
                    </div>
                    <h3 class="font-bold text-slate-900 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $event->title }}</h3>
                    @if($event->location_name ?? $event->address)
                    <p class="text-xs text-slate-500 mt-2 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $event->location_name ?? $event->address }}
                    </p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- REGISTER CTA --}}
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-slate-50 border border-slate-200 rounded-3xl p-10 sm:p-14">
            <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 mb-4 tracking-tight">Punya Usaha di Putat Jaya?</h2>
            <p class="text-slate-500 mb-8 text-lg max-w-xl mx-auto">Daftarkan usaha Anda secara gratis dan jangkau lebih banyak pelanggan melalui platform digital kami.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-200 hover:shadow-xl transition-all transform hover:-translate-y-0.5 btn-press">
                    Daftarkan Usaha Saya
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="{{ route('tentang') }}" class="inline-flex items-center justify-center px-8 py-3.5 border-2 border-slate-200 text-slate-700 font-bold rounded-xl hover:border-slate-300 hover:bg-slate-100 transition-all btn-press">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
