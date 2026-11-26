<x-app-layout>
    <!-- Hero Section with Glassmorphism & Gradient -->
    <div class="relative overflow-hidden bg-white">
        <div class="absolute inset-y-0 w-full h-full">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-50 via-indigo-50/50 to-white"></div>
            <!-- Decorative blobs -->
            <div class="absolute top-[-10%] right-[-5%] w-[40%] h-[40%] rounded-full bg-blue-200/40 blur-3xl mix-blend-multiply animate-pulse"></div>
            <div class="absolute bottom-[-10%] left-[-5%] w-[40%] h-[40%] rounded-full bg-indigo-200/40 blur-3xl mix-blend-multiply animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 flex flex-col lg:flex-row items-center">
            <div class="w-full lg:w-1/2 lg:pr-12 text-center lg:text-left z-10">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100/80 text-blue-700 font-semibold text-sm mb-6 backdrop-blur-sm border border-blue-200 shadow-sm">
                    <span class="flex w-2 h-2 rounded-full bg-blue-600 mr-2 animate-ping"></span>
                    Portal UMKM Resmi Kelurahan Putat Jaya
                </div>
                <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight leading-tight mb-6">
                    Temukan & Dukung <br class="hidden lg:block" />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Usaha Lokal Kita</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto lg:mx-0">
                    Jelajahi berbagai produk dan layanan unggulan dari UMKM di Kelurahan Putat Jaya. Mari bersama-sama memajukan ekonomi kerakyatan.
                </p>
                
                <!-- Search Box Glassmorphism -->
                <div class="bg-white/60 backdrop-blur-md p-2 rounded-2xl shadow-xl border border-white/50 max-w-2xl mx-auto lg:mx-0">
                    <form action="{{ route('cari') }}" method="GET" class="flex items-center">
                        <div class="flex-grow flex items-center pl-4 pr-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" name="q" placeholder="Cari UMKM atau produk..." class="w-full bg-transparent border-none focus:ring-0 text-gray-800 placeholder-gray-500 py-3 px-3">
                        </div>
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-8 rounded-xl shadow-md transition-all transform hover:scale-105">
                            Cari
                        </button>
                    </form>
                </div>

                <div class="mt-8 flex flex-wrap justify-center lg:justify-start gap-4 text-sm font-medium text-gray-500">
                    <span class="flex items-center"><svg class="w-5 h-5 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Terverifikasi</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Terintegrasi Maps</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Kontak Langsung</span>
                </div>
            </div>
            <div class="hidden lg:block w-full lg:w-1/2 z-10 relative">
                <!-- Abstract Hero Image Composition -->
                <div class="relative w-full h-[500px]">
                    <div class="absolute top-10 right-10 w-64 h-80 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl shadow-2xl p-6 transform rotate-6 hover:rotate-0 transition-transform duration-500 z-20 flex flex-col justify-end text-white">
                        <span class="text-4xl mb-2">🏪</span>
                        <h4 class="font-bold text-lg">Direktori UMKM</h4>
                        <p class="text-xs text-blue-100">Putat Jaya Surabaya</p>
                    </div>
                    <div class="absolute bottom-10 left-10 w-72 h-64 bg-white rounded-3xl shadow-2xl p-6 transform -rotate-3 hover:rotate-0 transition-transform duration-500 z-30 border border-slate-100 flex flex-col justify-end">
                        <span class="text-4xl mb-2">🛍️</span>
                        <h4 class="font-bold text-slate-800 text-lg">Produk Unggulan</h4>
                        <p class="text-xs text-slate-500">Karya warga lokal</p>
                    </div>
                    <!-- Stats Floating Card -->
                    <div class="absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-1/4 bg-white/80 backdrop-blur-md p-4 rounded-2xl shadow-xl z-40 border border-white flex items-center gap-4">
                        <div class="bg-blue-100 p-3 rounded-xl text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold uppercase">Pertumbuhan</p>
                            <p class="text-2xl font-bold text-gray-900">+120 UMKM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kategori Section -->
    <div class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Kategori Usaha</h2>
                <p class="mt-4 text-lg text-gray-500">Pilih dari berbagai kategori untuk menemukan layanan atau produk yang Anda butuhkan.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Data ini idealnya dari controller, tapi kita mock up statis untuk keindahan jika tidak ada data -->
                @forelse($categories ?? [] as $cat)
                <a href="{{ route('kategori.show', $cat->slug) }}" class="group bg-white p-6 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 text-center transform hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                    <div class="w-16 h-16 mx-auto bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white rounded-2xl flex items-center justify-center mb-4 transition-colors duration-300">
                        <!-- Icon fallback jika icon database kosong -->
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">{{ $cat->name }}</h3>
                    <p class="text-sm text-gray-500 mt-2">{{ $cat->umkm_profiles_count ?? 0 }} Usaha</p>
                </a>
                @empty
                <!-- Fallback jika belum di-passing dari controller HomeController (di plan kita, sudah pakai view composer atau bisa hardcode untuk demo UI elegant) -->
                @php
                    $demoCats = ['Kuliner', 'Kerajinan', 'Jasa & Layanan', 'Pakaian'];
                @endphp
                @foreach($demoCats as $cat)
                <a href="{{ route('direktori.umkm') }}" class="group bg-white p-6 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 text-center transform hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                    <div class="w-16 h-16 mx-auto bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white rounded-2xl flex items-center justify-center mb-4 transition-colors duration-300 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">{{ $cat }}</h3>
                </a>
                @endforeach
                @endforelse
            </div>
        </div>
    </div>

    <!-- Call to Action (Untuk UMKM) -->
    <div class="relative py-20 bg-gray-900 overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-blue-950 to-gray-900"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-2/3 text-center md:text-left mb-8 md:mb-0">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl mb-4">
                    Punya Usaha di Kelurahan Putat Jaya?
                </h2>
                <p class="text-lg text-gray-300 max-w-2xl">
                    Daftarkan UMKM Anda sekarang! Dapatkan akses fitur promosi digital, integrasi peta, dan kemudahan ditemukan oleh lebih banyak pelanggan.
                </p>
            </div>
            <div class="md:w-1/3 flex justify-center md:justify-end">
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-bold rounded-xl text-blue-900 bg-white hover:bg-gray-100 shadow-xl transition-transform hover:scale-105">
                    Daftar Sekarang Gratis
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
