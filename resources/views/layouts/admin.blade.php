<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — Direktori UMKM Putat Jaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        svg { max-width: 100%; vertical-align: middle; }
        svg.w-5 { width: 1.25rem; height: 1.25rem; }
        svg.w-4 { width: 1rem; height: 1rem; }
        svg.w-6 { width: 1.5rem; height: 1.5rem; }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            margin-bottom: 3px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-link:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            transform: translateX(3px);
        }
        .sidebar-link.active {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
        }
        .sidebar-link svg {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            flex-shrink: 0;
            color: #94a3b8;
            transition: color 0.2s ease, transform 0.2s ease;
        }
        .sidebar-link.active svg {
            color: #ffffff !important;
        }
        .sidebar-link:hover:not(.active) svg {
            color: #2563eb;
        }
    </style>
    @stack('head')
</head>
<body class="bg-slate-50 antialiased" x-data="{ sidebarOpen: false }">

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-900/50 z-20 lg:hidden"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    </div>

    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-slate-200 flex flex-col transition-transform duration-300"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        {{-- Logo --}}
        <div class="flex items-center space-x-3 px-5 py-5 border-b border-slate-100">
            <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                <svg class="w-5 h-5 text-white" width="20" height="20" style="width:20px;height:20px;max-width:20px;max-height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div class="leading-tight">
                <p class="font-extrabold text-slate-900 text-[14px]">Admin Panel</p>
                <p class="text-xs text-blue-600 font-semibold">UMKM Putat Jaya</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            <p class="px-3 pt-1 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Utama</p>

            <a href="{{ route('admin.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <a href="{{ route('admin.statistik') }}"
               class="sidebar-link {{ request()->routeIs('admin.statistik') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Statistik
            </a>

            <p class="px-3 pt-4 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Manajemen UMKM</p>

            <a href="{{ route('admin.umkm.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.umkm*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Data UMKM
            </a>

            <a href="{{ route('admin.verifikasi-umkm.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.verifikasi-umkm*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Verifikasi UMKM
                @php
                    $pendingCount = \App\Models\UmkmProfile::where('verification_status','diajukan')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="ml-auto inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 rounded-full">{{ $pendingCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.produk.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.produk*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Data Produk
            </a>

            <p class="px-3 pt-4 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Konten</p>

            <a href="{{ route('admin.event.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.event*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Event & Acara
            </a>

            <a href="{{ route('admin.banner.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.banner*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Banner / Slider
            </a>

            <a href="{{ route('admin.peta-umkm') }}"
               class="sidebar-link {{ request()->routeIs('admin.peta-umkm') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Peta UMKM
            </a>

            <p class="px-3 pt-4 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Sistem</p>

            <a href="{{ route('admin.pengguna.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pengguna*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Data Pengguna
            </a>

            <a href="{{ route('admin.ekspor') }}"
               class="sidebar-link {{ request()->routeIs('admin.ekspor') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Ekspor Data
            </a>

            <a href="{{ route('admin.pengaturan') }}"
               class="sidebar-link {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Pengaturan
            </a>

            <div class="pt-3 mt-3 border-t border-slate-100">
                <a href="{{ route('home') }}" target="_blank"
                   class="sidebar-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Website
                </a>
            </div>
        </nav>

        {{-- User --}}
        <div class="p-4 border-t border-slate-100" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center w-full text-left space-x-3 p-2 rounded-xl hover:bg-slate-100 transition-colors">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate">Administrator</p>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition
                 class="absolute bottom-20 left-4 right-4 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors rounded-xl">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar dari Admin
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div class="lg:ml-64 flex flex-col min-h-screen">

        {{-- Top Bar --}}
        <header class="bg-white border-b border-slate-200 sticky top-0 z-10">
            <div class="px-4 sm:px-6 h-[60px] flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h1 class="text-base font-bold text-slate-900">@yield('page-title', 'Dashboard')</h1>
                        @hasSection('page-subtitle')
                        <p class="text-xs text-slate-500">@yield('page-subtitle')</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="hidden sm:flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span>
                        Admin Panel
                    </span>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                 class="mb-6 flex items-center bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
                <svg class="w-5 h-5 mr-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
                <button @click="show = false" class="ml-auto text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
            @endif
            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition
                 class="mb-6 flex items-center bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
                <svg class="w-5 h-5 mr-3 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
                <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700">&times;</button>
            </div>
            @endif
            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
                <ul class="text-sm font-medium space-y-1">@foreach($errors->all() as $e)<li class="flex items-center"><svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/></svg>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
