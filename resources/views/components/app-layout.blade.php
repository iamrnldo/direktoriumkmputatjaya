<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="{{ $description ?? 'Direktori UMKM Kelurahan Putat Jaya - Temukan produk dan usaha lokal terbaik di Putat Jaya, Surabaya' }}">
    <link rel="icon" href="/favicon.ico">
    <title>{{ $title ?? 'Direktori UMKM' }} | {{ $siteSettings['app_name'] ?? config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-active { color: #2563eb; background-color: #eff6ff; }
        svg { max-width: 100%; vertical-align: middle; }
        svg.w-5 { width: 1.25rem; height: 1.25rem; }
        svg.w-4 { width: 1rem; height: 1rem; }
        svg.w-6 { width: 1.5rem; height: 1.5rem; }
    </style>
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
                    <a href="{{ route('cari') }}" class="p-2 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition-all" title="Cari">
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
                                    <a href="{{ route('admin.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                        Panel Admin
                                    </a>
                                @elseif(auth()->user()->isUmkmOwner())
                                    <a href="{{ route('dashboard.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                        Dashboard Saya
                                    </a>
                                @endif
                                <div class="h-px bg-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:block text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors px-3 py-2 rounded-lg hover:bg-slate-100">Masuk</a>
                        <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all">Daftar UMKM</a>
                    @endauth

                    {{-- Mobile Hamburger --}}
                    <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-colors">
                        <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileOpen" x-transition class="md:hidden border-t border-slate-100 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl">Beranda</a>
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
    <main>{{ $slot }}</main>

    {{-- Toast Notifications --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-6 right-6 z-50 flex items-center bg-slate-900 text-white px-5 py-4 rounded-2xl shadow-2xl max-w-sm">
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
         class="fixed bottom-6 right-6 z-50 flex items-center bg-slate-900 text-white px-5 py-4 rounded-2xl shadow-2xl max-w-sm">
        <div class="w-8 h-8 rounded-full bg-red-500/20 border border-red-500/30 flex items-center justify-center mr-3 flex-shrink-0">
            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <span class="text-sm font-medium flex-1">{{ session('error') }}</span>
        <button @click="show = false" class="ml-3 text-slate-400 hover:text-white transition-colors text-lg leading-none">&times;</button>
    </div>
    @endif

    {{-- Footer --}}
    <footer class="bg-slate-900 text-slate-400 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" width="20" height="20" style="width:20px;height:20px;max-width:20px;max-height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <span class="font-extrabold text-white text-base block">Direktori UMKM</span>
                            <span class="text-sm text-blue-400 font-medium">Putat Jaya</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">Portal digital resmi UMKM Kelurahan Putat Jaya, Surabaya.</p>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-200 uppercase tracking-widest mb-4">Jelajahi</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('direktori.umkm') }}" class="hover:text-blue-400 transition-colors">Direktori UMKM</a></li>
                        <li><a href="{{ route('produk.index') }}" class="hover:text-blue-400 transition-colors">Katalog Produk</a></li>
                        <li><a href="{{ route('peta-umkm') }}" class="hover:text-blue-400 transition-colors">Peta Sebaran</a></li>
                        <li><a href="{{ route('event.index') }}" class="hover:text-blue-400 transition-colors">Event & Bazar</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-200 uppercase tracking-widest mb-4">Informasi</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('tentang') }}" class="hover:text-blue-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('kontak') }}" class="hover:text-blue-400 transition-colors">Kontak</a></li>
                        <li><a href="{{ route('kebijakan-privasi') }}" class="hover:text-blue-400 transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">Daftarkan Usaha →</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-200 uppercase tracking-widest mb-4">Lokasi</h4>
                    <address class="not-italic text-sm text-slate-400 space-y-1">
                        <p>Kel. Putat Jaya</p>
                        <p>Kec. Sawahan</p>
                        <p>Surabaya, Jawa Timur 60251</p>
                    </address>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} Direktori UMKM Putat Jaya. Semua Hak Cipta Dilindungi.</p>
                <p class="text-xs text-slate-600">Dikembangkan untuk Kelurahan Putat Jaya, Surabaya</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @stack('scripts')
</body>
</html>
