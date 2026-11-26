@extends('layouts.app')

@section('title', $umkm->name)
@section('meta_description', Str::limit($umkm->business_description, 155))
@section('needs_leaflet', true)

@push('head')
<style>#umkm-map { height: 280px; border-radius: 12px; }</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-400 mb-5 flex items-center space-x-2" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('direktori.umkm') }}" class="hover:text-blue-600 transition-colors">Direktori</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">{{ Str::limit($umkm->name, 40) }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- LEFT: Main info --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Gallery --}}
            @if($umkm->images->count())
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100" x-data="{ lightbox: false, lightboxSrc: '' }">
                @php $cover = $umkm->images->firstWhere('is_cover', true) ?? $umkm->images->first(); @endphp
                <div class="relative">
                    <img src="{{ Storage::disk('public')->url($cover->image_path) }}" alt="{{ $umkm->name }}" class="w-full h-64 sm:h-80 object-cover cursor-zoom-in hover:opacity-95 transition-opacity" id="main-gallery-img" @click="lightboxSrc = document.getElementById('main-gallery-img').src; lightbox = true">
                    @if($umkm->is_featured)
                    <div class="absolute top-3 left-3 bg-amber-400 text-amber-900 text-xs font-bold px-3 py-1 rounded-full shadow flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        UMKM Unggulan
                    </div>
                    @endif
                </div>
                @if($umkm->images->count() > 1)
                <div class="p-3 flex gap-2 overflow-x-auto">
                    @foreach($umkm->images as $img)
                    <img src="{{ Storage::disk('public')->url($img->image_path) }}" alt="" class="h-14 w-14 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500 flex-shrink-0 transition-colors"
                         onclick="document.getElementById('main-gallery-img').src=this.src"
                         @click="lightboxSrc = '{{ Storage::disk('public')->url($img->image_path) }}'; lightbox = true">
                    @endforeach
                </div>
                @endif

                {{-- Lightbox Modal --}}
                <div x-show="lightbox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="lightbox = false" @keydown.escape.window="if(lightbox) lightbox = false" class="fixed inset-0 z-[100] bg-black/90 lightbox-overlay flex items-center justify-center p-4 cursor-zoom-out" style="display:none;">
                    <button @click="lightbox = false" class="absolute top-4 right-4 text-white/80 hover:text-white transition-colors z-10" aria-label="Tutup">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <img :src="lightboxSrc" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl" @click.stop>
                </div>
            </div>
            @endif

            {{-- Business Info --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        @if($umkm->verification_status === 'verified')
                        <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 mb-2">
                            <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Terverifikasi Resmi
                        </div>
                        @endif
                        @if($umkm->category)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 mb-2">
                            {{ $umkm->category->icon ?? '' }} {{ $umkm->category->name }}
                        </span>
                        @endif
                        <h1 class="text-2xl font-extrabold text-gray-900">{{ $umkm->name }}</h1>
                        <p class="text-gray-500 mt-1">Pemilik: <span class="font-medium">{{ $umkm->owner_name }}</span></p>
                    </div>
                    <div class="flex-shrink-0 ml-4 text-right">
                        @if($isOpen !== null)
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $isOpen ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                            <span class="inline-block w-2 h-2 rounded-full {{ $isOpen ? 'bg-emerald-500' : 'bg-gray-400' }} mr-1.5"></span>{{ $isOpen ? 'Buka' : 'Tutup' }}
                        </span>
                        @if(!$isOpen && $umkm->businessHours->count())
                        @php
                            $today = now()->dayOfWeek;
                            $nextOpen = null;
                            for ($d = 1; $d <= 7; $d++) {
                                $checkDay = ($today + $d) % 7;
                                $nextHour = $umkm->businessHours->firstWhere('day_of_week', $checkDay);
                                if ($nextHour && !$nextHour->is_closed && $nextHour->open_time) {
                                    $dayNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                                    $nextOpen = $dayNames[$checkDay] . ' ' . \Carbon\Carbon::parse($nextHour->open_time)->format('H:i');
                                    break;
                                }
                            }
                        @endphp
                        @if($nextOpen)
                        <p class="text-xs text-gray-500 mt-1.5">Buka: <span class="font-semibold text-blue-600">{{ $nextOpen }}</span></p>
                        @endif
                        @endif
                        @endif
                    </div>
                </div>

                @if($umkm->business_description)
                <p class="text-gray-600 leading-relaxed">{{ $umkm->business_description }}</p>
                @endif

                {{-- Contact Actions + Share --}}
                <div class="mt-5 flex flex-wrap gap-3 items-center">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->whatsapp_number) }}"
                       target="_blank"
                       onclick="fetch('{{ route('api.analytics.track-click') }}', {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({type:'whatsapp',umkm_id:{{ $umkm->id }}})});"
                       class="flex items-center px-5 py-2.5 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition-colors btn-press">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    @if($umkm->latitude)
                    <button onclick="document.getElementById('umkm-map').scrollIntoView({behavior:'smooth'});" class="flex items-center px-5 py-2.5 border border-blue-600 text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors btn-press">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Lihat Peta
                    </button>
                    @endif
                    @auth
                    <button id="fav-btn" onclick="toggleFavorite({{ $umkm->id }})"
                        class="flex items-center px-4 py-2.5 border border-gray-300 text-gray-600 rounded-xl hover:border-red-300 hover:text-red-500 transition-colors btn-press {{ $isFavorite ? 'text-red-500 border-red-300' : '' }}">
                        <svg class="w-5 h-5" fill="{{ $isFavorite ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    @endauth

                    {{-- Share Buttons --}}
                    <div class="flex items-center space-x-2 ml-auto" x-data="{ copied: false }">
                        <span class="text-xs text-gray-400 font-medium hidden sm:block">Bagikan:</span>
                        <a href="https://wa.me/?text={{ urlencode($umkm->name . ' - Direktori UMKM Putat Jaya ' . route('umkm.show', $umkm->slug)) }}" target="_blank" class="w-9 h-9 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 flex items-center justify-center transition-colors" title="Share via WhatsApp" aria-label="Bagikan ke WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('umkm.show', $umkm->slug)) }}" target="_blank" class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors" title="Share via Facebook" aria-label="Bagikan ke Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        </a>
                        <button @click="navigator.clipboard.writeText('{{ route('umkm.show', $umkm->slug) }}'); copied = true; setTimeout(() => copied = false, 2000)" class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-colors relative" title="Salin Link" aria-label="Salin link">
                            <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copied" class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Business Hours --}}
            @if($umkm->businessHours->count())
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="font-bold text-gray-800 mb-4">Jam Operasional</h2>
                @php $days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']; @endphp
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @foreach($umkm->businessHours->sortBy('day_of_week') as $hour)
                    <div class="flex items-center justify-between py-2 px-3 rounded-lg {{ $hour->day_of_week == now()->dayOfWeek ? 'bg-blue-50 border border-blue-200' : 'bg-gray-50' }}">
                        <span class="text-sm font-medium text-gray-700">{{ $days[$hour->day_of_week] }}</span>
                        <span class="text-xs text-gray-500">
                            {{ $hour->is_closed ? 'Tutup' : ($hour->open_time ? \Carbon\Carbon::parse($hour->open_time)->format('H:i') . '-' . \Carbon\Carbon::parse($hour->close_time)->format('H:i') : '-') }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Products --}}
            @if($umkm->activeProducts->count())
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="font-bold text-gray-800 mb-4">Produk Kami ({{ $umkm->activeProducts->count() }})</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach($umkm->activeProducts->take(6) as $product)
                    @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
                @if($umkm->activeProducts->count() > 6)
                <a href="{{ route('produk.index', ['umkm' => $umkm->slug]) }}" class="block text-center mt-4 text-sm text-blue-600 hover:underline font-medium">Lihat semua produk &rarr;</a>
                @endif
            </div>
            @endif

            {{-- Reviews --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100" id="ulasan">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-gray-800">Ulasan & Rating</h2>
                    @if($umkm->reviews->count())
                    <div class="flex items-center">
                        <span class="text-xl font-bold text-amber-500">{{ number_format($umkm->average_rating, 1) }}</span>
                        <div class="flex ml-2">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= round($umkm->average_rating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-400 ml-2">({{ $umkm->reviews->count() }})</span>
                    </div>
                    @endif
                </div>

                {{-- Write review --}}
                @auth
                <div class="bg-gray-50 rounded-xl p-4 mb-5" x-data="{ rating: 0 }">
                    <p class="text-sm font-medium text-gray-700 mb-3">Tulis Ulasan</p>
                    <form method="POST" action="{{ route('ulasan.store') }}">
                        @csrf
                        <input type="hidden" name="umkm_profile_id" value="{{ $umkm->id }}">
                        <div class="flex space-x-1 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" @click="rating = {{ $i }}" class="text-2xl transition-colors" :class="rating >= {{ $i }} ? 'text-amber-400' : 'text-gray-300'">★</button>
                            @endfor
                            <input type="hidden" name="rating" :value="rating">
                        </div>
                        <textarea name="comment" rows="2" placeholder="Tulis pengalaman Anda..." class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                        <button type="submit" class="mt-2 px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 btn-press">Kirim Ulasan</button>
                    </form>
                </div>
                @else
                <p class="text-sm text-gray-500 mb-4"><a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk</a> untuk menulis ulasan.</p>
                @endauth

                {{-- Review list --}}
                @forelse($umkm->reviews->take(5) as $review)
                <div class="py-4 border-b border-gray-100 last:border-0">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $review->user->name }}</p>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    @if($review->comment)
                    <p class="text-sm text-gray-600 mt-2 ml-10">{{ $review->comment }}</p>
                    @endif
                </div>
                @empty
                <p class="text-center text-gray-400 text-sm py-5">Belum ada ulasan. Jadilah yang pertama!</p>
                @endforelse
            </div>
        </div>

        {{-- RIGHT: Sidebar info --}}
        <div class="space-y-5">

            {{-- Location --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-3">Informasi Kontak</h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="text-sm text-gray-600">{{ $umkm->address }}, {{ $umkm->village }}, Kec. {{ $umkm->district }}, {{ $umkm->city }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->whatsapp_number) }}" target="_blank" class="text-sm text-green-600 hover:underline">{{ $umkm->whatsapp_number }}</a>
                    </div>
                    @if($umkm->business_email)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-blue-500 mr-2.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:{{ $umkm->business_email }}" class="text-sm text-blue-600 hover:underline">{{ $umkm->business_email }}</a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Social Media --}}
            @if($umkm->instagram_url || $umkm->facebook_url || $umkm->tiktok_url || $umkm->shopee_url || $umkm->tokopedia_url)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-3">Media Sosial & Marketplace</h3>
                <div class="space-y-2">
                    @if($umkm->instagram_url)
                    <a href="{{ $umkm->instagram_url }}" target="_blank" class="flex items-center text-sm text-pink-600 hover:underline p-2 rounded-lg hover:bg-pink-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Instagram
                    </a>
                    @endif
                    @if($umkm->facebook_url)
                    <a href="{{ $umkm->facebook_url }}" target="_blank" class="flex items-center text-sm text-blue-600 hover:underline p-2 rounded-lg hover:bg-blue-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        Facebook
                    </a>
                    @endif
                    @if($umkm->tiktok_url)
                    <a href="{{ $umkm->tiktok_url }}" target="_blank" class="flex items-center text-sm text-gray-800 hover:underline p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/></svg>
                        TikTok
                    </a>
                    @endif
                    @if($umkm->shopee_url)
                    <a href="{{ $umkm->shopee_url }}" target="_blank" class="flex items-center text-sm text-orange-500 hover:underline p-2 rounded-lg hover:bg-orange-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Shopee
                    </a>
                    @endif
                    @if($umkm->tokopedia_url)
                    <a href="{{ $umkm->tokopedia_url }}" target="_blank" class="flex items-center text-sm text-green-600 hover:underline p-2 rounded-lg hover:bg-green-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Tokopedia
                    </a>
                    @endif
                </div>
            </div>
            @endif

            {{-- Map --}}
            @if($umkm->latitude)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                <div id="umkm-map"></div>
                <div class="p-3">
                    <a href="https://www.google.com/maps?q={{ $umkm->latitude }},{{ $umkm->longitude }}" target="_blank"
                       class="flex items-center justify-center text-sm text-blue-600 font-medium hover:underline">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Buka di Google Maps
                    </a>
                </div>
            </div>
            @endif

            {{-- Stats --}}
            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div>
                        <p class="text-lg font-bold text-blue-600">{{ number_format($umkm->view_count) }}</p>
                        <p class="text-xs text-gray-500">Dilihat</p>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-blue-600">{{ $umkm->activeProducts->count() }}</p>
                        <p class="text-xs text-gray-500">Produk</p>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-blue-600">{{ $umkm->reviews->count() }}</p>
                        <p class="text-xs text-gray-500">Ulasan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($umkm->latitude)
<script>
const map = L.map('umkm-map').setView([{{ $umkm->latitude }}, {{ $umkm->longitude }}], 17);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
L.marker([{{ $umkm->latitude }}, {{ $umkm->longitude }}]).addTo(map).bindPopup('<strong>{{ addslashes($umkm->name) }}</strong>').openPopup();
</script>
@endif

<script>
async function toggleFavorite(umkmId) {
    const res = await fetch(`/umkm/${umkmId}/favorite`, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'}
    });
    const data = await res.json();
    const btn = document.getElementById('fav-btn');
    btn.querySelector('svg').setAttribute('fill', data.is_favorite ? 'currentColor' : 'none');
    btn.classList.toggle('text-red-500', data.is_favorite);
    btn.classList.toggle('border-red-300', data.is_favorite);
}
</script>
@endpush
