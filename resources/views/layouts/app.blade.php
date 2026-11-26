<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', 'Direktori UMKM Kelurahan Putat Jaya - Temukan produk dan usaha lokal terbaik di Putat Jaya, Surabaya')">
    <link rel="icon" href="/favicon.ico">
    <title>@yield('title', 'Beranda') | {{ $siteSettings['app_name'] ?? config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @hasSection('needs_leaflet')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    @endif
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-active { color: #2563eb; background-color: #eff6ff; }
        svg { max-width: 100%; vertical-align: middle; }
        svg.w-5 { width: 1.25rem; height: 1.25rem; }
        svg.w-4 { width: 1rem; height: 1rem; }
        svg.w-6 { width: 1.5rem; height: 1.5rem; }
        [x-cloak] { display: none !important; }
    </style>
    @stack('head')
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-blue-100 selection:text-blue-900">

    {{-- Navigation --}}
    <nav class="bg-white/95 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-[68px]">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group flex-shrink-0">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" width="20" height="20" style="width:20px;height:20px;max-width:20px;max-height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="hidden sm:block leading-tight">
                        <span class="font-extrabold text-slate-900 text-[15px] block">Direktori UMKM</span>
                        <span class="text-xs text-blue-600 font-semibold">Putat Jaya · Surabaya</span>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center space-x-1">
                    @php
                        $navLinks = [
                            ['route' => 'home', 'label' => 'Beranda'],
                            ['route' => 'direktori.umkm', 'label' => 'Direktori'],
                            ['route' => 'produk.index', 'label' => 'Produk'],
                            ['route' => 'peta-umkm', 'label' => 'Peta'],
                            ['route' => 'event.index', 'label' => 'Event'],
                        ];
                    @endphp
                    @foreach($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                           class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 {{ request()->routeIs($link['route']) ? 'nav-active' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-100' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>

                {{-- Right Actions --}}
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="{{ route('cari') }}" class="p-2 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition-all" title="Cari" aria-label="Cari UMKM atau Produk">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </a>

                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 transition-all text-slate-700 text-sm font-semibold">
                                <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden sm:block">{{ Str::limit(auth()->user()->name, 14) }}</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.outside="open = false" x-transition
                                class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                                <div class="px-4 py-2 border-b border-slate-100 mb-1">
                                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Masuk sebagai</p>
                                    <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                </div>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.index') }}"
                                       class="flex items-center px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                        <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                        Panel Admin
                                    </a>
                                @elseif(auth()->user()->isUmkmOwner())
                                    <a href="{{ route('dashboard.index') }}"
                                       class="flex items-center px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                        <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        Dashboard Saya
                                    </a>
                                @endif
                                <div class="h-px bg-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="hidden sm:block text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors px-3 py-2 rounded-lg hover:bg-slate-100">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                           class="hidden sm:inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-bold rounded-xl shadow-sm hover:shadow-md transition-all">
                            Daftar UMKM
                        </a>
                    @endauth

                    {{-- Mobile Hamburger --}}
                    <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-colors" aria-label="Menu navigasi">
                        <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="md:hidden border-t border-slate-100 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : '' }}">Beranda</a>
                <a href="{{ route('direktori.umkm') }}" class="block px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl">Direktori UMKM</a>
                <a href="{{ route('produk.index') }}" class="block px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl">Katalog Produk</a>
                <a href="{{ route('peta-umkm') }}" class="block px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl">Peta UMKM</a>
                <a href="{{ route('event.index') }}" class="block px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl">Event</a>
                @guest
                    <div class="pt-2 border-t border-slate-100 space-y-2 mt-2">
                        <a href="{{ route('login') }}" class="block px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-xl">Masuk</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2.5 text-sm font-bold text-center text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl">Daftarkan UMKM Anda</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main>@yield('content')</main>

    {{-- Toast Notifications --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-20 md:bottom-6 right-6 z-[60] flex items-center bg-slate-900 text-white px-5 py-4 rounded-2xl shadow-2xl max-w-sm">
        <div class="w-8 h-8 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center mr-3 flex-shrink-0">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <span class="text-sm font-medium flex-1">{{ session('success') }}</span>
        <button @click="show = false" class="ml-3 text-slate-400 hover:text-white transition-colors text-lg leading-none">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         class="fixed bottom-20 md:bottom-6 right-6 z-[60] flex items-center bg-slate-900 text-white px-5 py-4 rounded-2xl shadow-2xl max-w-sm">
        <div class="w-8 h-8 rounded-full bg-red-500/20 border border-red-500/30 flex items-center justify-center mr-3 flex-shrink-0">
            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <span class="text-sm font-medium flex-1">{{ session('error') }}</span>
        <button @click="show = false" class="ml-3 text-slate-400 hover:text-white transition-colors text-lg leading-none">&times;</button>
    </div>
    @endif

    {{-- Accessibility Toolbar (Desktop) --}}
    <div x-data="{ open: false }" class="fixed right-4 top-1/2 -translate-y-1/2 z-40 hidden sm:flex flex-col items-end space-y-2">
        <button @click="open = !open" class="w-11 h-11 rounded-full bg-blue-600 text-white shadow-lg hover:bg-blue-700 transition-all flex items-center justify-center btn-press" title="Pengaturan Aksesibilitas" aria-label="Buka pengaturan aksesibilitas">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </button>
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-x-4" class="bg-white rounded-2xl shadow-2xl border border-slate-200 p-4 w-56" style="display:none;">
            <h4 class="text-sm font-bold text-slate-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Aksesibilitas
            </h4>
            {{-- Font Size --}}
            <div class="mb-3">
                <p class="text-xs text-slate-500 mb-1.5 font-medium">Ukuran Teks</p>
                <div class="flex space-x-1">
                    <button @click="$store.a11y.setFontSize('normal')" :class="$store.a11y.fontSize === 'normal' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="flex-1 py-2 rounded-lg text-xs font-bold transition-colors btn-press">A</button>
                    <button @click="$store.a11y.setFontSize('large')" :class="$store.a11y.fontSize === 'large' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="flex-1 py-2 rounded-lg text-sm font-bold transition-colors btn-press">A+</button>
                    <button @click="$store.a11y.setFontSize('xlarge')" :class="$store.a11y.fontSize === 'xlarge' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="flex-1 py-2 rounded-lg text-base font-bold transition-colors btn-press">A++</button>
                </div>
            </div>
            {{-- Dark Mode --}}
            <button @click="$store.a11y.toggleDark()" class="w-full flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-100 transition-colors mb-1.5">
                <span class="text-sm font-medium text-slate-700">🌙 Mode Gelap</span>
                <div :class="$store.a11y.dark ? 'bg-blue-600' : 'bg-slate-300'" class="w-10 h-5 rounded-full relative transition-colors">
                    <div :class="$store.a11y.dark ? 'translate-x-5' : 'translate-x-0.5'" class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform"></div>
                </div>
            </button>
            {{-- High Contrast --}}
            <button @click="$store.a11y.toggleHighContrast()" class="w-full flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-100 transition-colors">
                <span class="text-sm font-medium text-slate-700">🔲 Kontras Tinggi</span>
                <div :class="$store.a11y.highContrast ? 'bg-blue-600' : 'bg-slate-300'" class="w-10 h-5 rounded-full relative transition-colors">
                    <div :class="$store.a11y.highContrast ? 'translate-x-5' : 'translate-x-0.5'" class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform"></div>
                </div>
            </button>
        </div>
    </div>

    {{-- Back to Top --}}
    <button x-data="{ show: false }" @scroll.window="show = window.scrollY > 300" x-show="show" x-transition @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="fixed bottom-20 md:bottom-6 right-4 z-40 w-11 h-11 rounded-full bg-blue-600 text-white shadow-lg hover:bg-blue-700 transition-all flex items-center justify-center btn-press" style="display:none;" aria-label="Kembali ke atas">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
    </button>

    {{-- Footer --}}
    <footer class="bg-slate-900 text-slate-400 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 mb-12">
                {{-- Brand --}}
                <div class="md:col-span-4">
                    <div class="flex items-center space-x-3 mb-5">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" width="20" height="20" style="width:20px;height:20px;max-width:20px;max-height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <span class="font-extrabold text-white text-base block">Direktori UMKM</span>
                            <span class="text-sm text-blue-400 font-medium">Putat Jaya</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-xs">Portal digital resmi yang menghubungkan UMKM Kelurahan Putat Jaya dengan masyarakat luas secara mudah dan transparan.</p>
                </div>
                {{-- Nav Links --}}
                <div class="md:col-span-3">
                    <h4 class="text-sm font-bold text-slate-200 uppercase tracking-widest mb-5">Jelajahi</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('direktori.umkm') }}" class="hover:text-blue-400 transition-colors">Direktori UMKM</a></li>
                        <li><a href="{{ route('produk.index') }}" class="hover:text-blue-400 transition-colors">Katalog Produk</a></li>
                        <li><a href="{{ route('peta-umkm') }}" class="hover:text-blue-400 transition-colors">Peta Sebaran</a></li>
                        <li><a href="{{ route('event.index') }}" class="hover:text-blue-400 transition-colors">Event & Bazar</a></li>
                        <li><a href="{{ route('umkm-unggulan') }}" class="hover:text-blue-400 transition-colors">UMKM Unggulan</a></li>
                    </ul>
                </div>
                <div class="md:col-span-3">
                    <h4 class="text-sm font-bold text-slate-200 uppercase tracking-widest mb-5">Informasi</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('tentang') }}" class="hover:text-blue-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('kontak') }}" class="hover:text-blue-400 transition-colors">Kontak</a></li>
                        <li><a href="{{ route('kebijakan-privasi') }}" class="hover:text-blue-400 transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="{{ route('syarat-ketentuan') }}" class="hover:text-blue-400 transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">Daftarkan Usaha Anda →</a></li>
                    </ul>
                </div>
                <div class="md:col-span-2">
                    <h4 class="text-sm font-bold text-slate-200 uppercase tracking-widest mb-5">Lokasi</h4>
                    <address class="not-italic text-sm text-slate-400 space-y-1">
                        <p>Kel. Putat Jaya</p>
                        <p>Kec. Sawahan</p>
                        <p>Surabaya, Jawa Timur</p>
                        <p>Indonesia 60251</p>
                    </address>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} Direktori UMKM Putat Jaya. Semua Hak Cipta Dilindungi.</p>
                <p class="text-xs text-slate-600">Dikembangkan untuk Kelurahan Putat Jaya, Surabaya</p>
            </div>
        </div>
    </footer>

    {{-- Mobile Bottom Navigation --}}
    <nav class="md:hidden fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-slate-200 z-50 bottom-nav" aria-label="Navigasi mobile">
        <div class="flex items-center justify-around h-16">
            @php
                $bottomNavItems = [
                    ['route' => 'home', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>', 'label' => 'Beranda'],
                    ['route' => 'direktori.umkm', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>', 'label' => 'Direktori'],
                    ['route' => 'produk.index', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>', 'label' => 'Produk'],
                    ['route' => 'peta-umkm', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>', 'label' => 'Peta'],
                    ['route' => 'cari', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>', 'label' => 'Cari'],
                ];
            @endphp
            @foreach($bottomNavItems as $item)
            <a href="{{ route($item['route']) }}" class="flex flex-col items-center justify-center w-16 py-1 {{ request()->routeIs($item['route']) ? 'text-blue-600' : 'text-slate-400' }} transition-colors" aria-label="{{ $item['label'] }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                <span class="text-[10px] font-semibold mt-0.5">{{ $item['label'] }}</span>
            </a>
            @endforeach
        </div>
    </nav>

    @hasSection('needs_leaflet')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @endif
    @stack('scripts')
</body>
</html>
