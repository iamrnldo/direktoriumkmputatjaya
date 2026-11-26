<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — UMKM Putat Jaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @hasSection('needs_leaflet')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    @endif
    @hasSection('needs_chartjs')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @endif
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        svg { max-width: 100%; vertical-align: middle; }
        svg.w-5 { width: 1.25rem; height: 1.25rem; }
        svg.w-4 { width: 1rem; height: 1rem; }
        svg.w-6 { width: 1.5rem; height: 1.5rem; }
        .dash-link { display: flex; align-items: center; padding: 10px 12px; border-radius: 12px; font-size: 0.875rem; font-weight: 600; color: #64748b; transition: all 0.15s; }
        .dash-link:hover { background-color: #f1f5f9; color: #0f172a; }
        .dash-link.active { background-color: #eff6ff; color: #1d4ed8; }
        .dash-link svg { width: 18px; height: 18px; margin-right: 10px; flex-shrink: 0; }
        .mob-nav-item { display: flex; flex-direction: column; align-items: center; gap: 2px; padding: 6px 0; font-size: 0.65rem; font-weight: 600; color: #94a3b8; transition: color 0.15s; }
        .mob-nav-item.active { color: #2563eb; }
        .mob-nav-item svg { width: 20px; height: 20px; }
    </style>
    @stack('head')
</head>
<body class="bg-slate-50 antialiased" x-data="{ sidebarOpen: false }">

<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/50 z-20 lg:hidden"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

{{-- Sidebar --}}
<aside class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-slate-200 flex flex-col transition-transform duration-300"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

    {{-- Logo --}}
    <div class="flex items-center space-x-3 px-5 py-5 border-b border-slate-100">
        <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
            <svg class="w-5 h-5 text-white" width="20" height="20" style="width:20px;height:20px;max-width:20px;max-height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div class="leading-tight">
            <p class="font-extrabold text-slate-900 text-[14px]">Dashboard UMKM</p>
            <p class="text-xs text-blue-600 font-semibold">Putat Jaya</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">
        <a href="{{ route('dashboard.index') }}" class="dash-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Beranda
        </a>

        <p class="px-3 pt-4 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Profil Usaha</p>

        <a href="{{ route('dashboard.profil-usaha') }}" class="dash-link {{ request()->routeIs('dashboard.profil-usaha*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
            Profil Usaha
        </a>
        <a href="{{ route('dashboard.galeri-usaha') }}" class="dash-link {{ request()->routeIs('dashboard.galeri-usaha*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Galeri Foto
        </a>
        <a href="{{ route('dashboard.jam-operasional') }}" class="dash-link {{ request()->routeIs('dashboard.jam-operasional*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Jam Operasional
        </a>
        <a href="{{ route('dashboard.lokasi') }}" class="dash-link {{ request()->routeIs('dashboard.lokasi*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            Lokasi Usaha
        </a>
        <a href="{{ route('dashboard.kontak-media-sosial') }}" class="dash-link {{ request()->routeIs('dashboard.kontak-media-sosial*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            Kontak & Sosmed
        </a>

        <p class="px-3 pt-4 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Produk</p>

        <a href="{{ route('dashboard.produk.index') }}" class="dash-link {{ request()->routeIs('dashboard.produk*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            Manajemen Produk
        </a>

        <p class="px-3 pt-4 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Pelanggan</p>

        <a href="{{ route('dashboard.ulasan') }}" class="dash-link {{ request()->routeIs('dashboard.ulasan*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            Ulasan Pelanggan
        </a>

        <p class="px-3 pt-4 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Akun & Info</p>

        <a href="{{ route('dashboard.status-verifikasi') }}" class="dash-link {{ request()->routeIs('dashboard.status-verifikasi*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Status Verifikasi
        </a>
        <a href="{{ route('dashboard.statistik') }}" class="dash-link {{ request()->routeIs('dashboard.statistik*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Statistik Usaha
        </a>
        <a href="{{ route('dashboard.qr-code') }}" class="dash-link {{ request()->routeIs('dashboard.qr-code*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
            QR Code Usaha
        </a>
        <a href="{{ route('dashboard.pengaturan-akun') }}" class="dash-link {{ request()->routeIs('dashboard.pengaturan-akun*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Pengaturan Akun
        </a>

        <div class="pt-3 border-t border-slate-100 mt-3">
            @php $umkmProfile = auth()->user()->umkmProfile ?? null; @endphp
            @if($umkmProfile && $umkmProfile->slug)
            <a href="{{ route('umkm.show', $umkmProfile->slug) }}" target="_blank" class="dash-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Preview Usaha Saya
            </a>
            @endif
            <a href="{{ route('home') }}" target="_blank" class="dash-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat Website
            </a>
        </div>
    </nav>

    {{-- User Info --}}
    <div class="p-4 border-t border-slate-100" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center w-full text-left space-x-3 p-2 rounded-xl hover:bg-slate-100 transition-colors">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
            </div>
            <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div x-show="open" @click.outside="open = false" x-transition
             class="absolute bottom-20 left-4 right-4 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Main --}}
<div class="lg:ml-64 flex flex-col min-h-screen pb-16 lg:pb-0">
    <header class="bg-white border-b border-slate-200 sticky top-0 z-10">
        <div class="px-4 sm:px-6 h-[60px] flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-[15px] font-bold text-slate-900">@yield('page-title', 'Dashboard')</h1>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                @if($umkmProfile ?? false)
                    <span class="hidden sm:flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>{{ $umkmProfile->name }}</span>
                    </span>
                @endif
            </div>
        </div>
    </header>

    <main class="flex-1 p-4 sm:p-6 lg:p-8">
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
             class="mb-6 flex items-center bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
            <svg class="w-5 h-5 mr-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-emerald-500 hover:text-emerald-700 text-lg">&times;</button>
        </div>
        @endif
        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition
             class="mb-6 flex items-center bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
            <svg class="w-5 h-5 mr-3 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/></svg>
            <span class="text-sm font-semibold">{{ session('error') }}</span>
            <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700 text-lg">&times;</button>
        </div>
        @endif
        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
            <ul class="text-sm font-medium space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
        </div>
        @endif
        @yield('content')
    </main>
</div>

{{-- Delete Confirmation Modal --}}
<div x-data="{ showDeleteModal: false, deleteFormId: null, deleteMessage: '' }"
     @confirm-delete.window="showDeleteModal = true; deleteFormId = $event.detail.form; deleteMessage = $event.detail.message || 'Data yang dihapus tidak dapat dikembalikan.'"
     x-cloak>
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
        <div x-show="showDeleteModal" @click="showDeleteModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
        <div x-show="showDeleteModal" class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 z-10"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="text-center">
                <div class="w-14 h-14 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Konfirmasi Hapus</h3>
                <p class="text-sm text-slate-500 mb-6" x-text="deleteMessage"></p>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false" type="button" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors text-sm">Batal</button>
                    <button @click="document.getElementById(deleteFormId).submit(); showDeleteModal = false" type="button" class="flex-1 px-4 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors text-sm">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Mobile Bottom Nav --}}
<nav class="fixed bottom-0 left-0 right-0 z-20 bg-white border-t border-slate-200 lg:hidden">
    <div class="grid grid-cols-4 h-14">
        <a href="{{ route('dashboard.index') }}" class="mob-nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Beranda
        </a>
        <a href="{{ route('dashboard.produk.index') }}" class="mob-nav-item {{ request()->routeIs('dashboard.produk*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            Produk
        </a>
        <a href="{{ route('dashboard.statistik') }}" class="mob-nav-item {{ request()->routeIs('dashboard.statistik*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Statistik
        </a>
        <a href="{{ route('dashboard.profil-usaha') }}" class="mob-nav-item {{ request()->routeIs('dashboard.profil-usaha*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
            Profil
        </a>
    </div>
</nav>

@hasSection('needs_leaflet')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
@endif
@stack('scripts')
</body>
</html>
