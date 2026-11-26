@extends('layouts.app')
@section('title', $product->name . ' - ' . $product->umkmProfile->name)
@section('meta_description', Str::limit($product->short_description ?? $product->description, 155))

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-400 mb-5 flex items-center space-x-2" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('produk.index') }}" class="hover:text-blue-600 transition-colors">Produk</a>
        <span>/</span>
        <a href="{{ route('umkm.show', $product->umkmProfile->slug) }}" class="hover:text-blue-600 transition-colors">{{ Str::limit($product->umkmProfile->name, 20) }}</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">{{ Str::limit($product->name, 30) }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8" x-data="{ lightbox: false, lightboxSrc: '' }">
        {{-- Product Images --}}
        <div>
            @php
                $coverImg = $product->images->firstWhere('is_cover', true) ?? $product->images->first();
                $hasValidImage = $coverImg && \Illuminate\Support\Facades\Storage::disk('public')->exists($coverImg->image_path);
            @endphp
            @if($hasValidImage)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                <img src="{{ Storage::disk('public')->url($coverImg->image_path) }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover cursor-zoom-in hover:opacity-95 transition-opacity" id="product-main-img"
                     @click="lightboxSrc = document.getElementById('product-main-img').src; lightbox = true">
                @if($product->images->count() > 1)
                <div class="p-3 flex gap-2 overflow-x-auto">
                    @foreach($product->images as $img)
                    <img src="{{ Storage::disk('public')->url($img->image_path) }}" alt="" class="h-14 w-14 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500 flex-shrink-0 transition-colors"
                         onclick="document.getElementById('product-main-img').src=this.src"
                         @click="lightboxSrc = '{{ Storage::disk('public')->url($img->image_path) }}'; lightbox = true">
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl aspect-square flex items-center justify-center"><svg class="w-20 h-20 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                @if($product->productCategory)
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 mb-2">{{ $product->productCategory->name }}</span>
                @endif

                <h1 class="text-2xl font-extrabold text-gray-900 mb-2">{{ $product->name }}</h1>

                <div class="flex items-center justify-between mb-4">
                    <div>
                        @if($product->price > 0)
                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @elseif($product->price_label)
                        <span class="text-xl font-bold text-blue-600">{{ $product->price_label }}</span>
                        @else
                        <span class="text-gray-400">Hubungi Penjual</span>
                        @endif
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $product->availability_status === 'available' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $product->availability_status === 'available' ? 'Tersedia' : ucfirst($product->availability_status) }}
                    </span>
                </div>

                @if($product->short_description)
                <p class="text-gray-600 text-sm">{{ $product->short_description }}</p>
                @endif

                {{-- WhatsApp Button --}}
                <div class="mt-5">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->umkmProfile->whatsapp_number) }}?text={{ urlencode('Halo, saya tertarik dengan produk ' . $product->name . '. Apakah masih tersedia? ' . route('produk.show', $product->slug)) }}" target="_blank"
                       class="flex items-center justify-center w-full px-6 py-3 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition-colors btn-press">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Tanya via WhatsApp
                    </a>
                </div>

                {{-- Share Buttons --}}
                <div class="mt-4 flex items-center space-x-2 pt-4 border-t border-gray-100" x-data="{ copied: false }">
                    <span class="text-xs text-gray-400 font-medium">Bagikan:</span>
                    <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . route('produk.show', $product->slug)) }}" target="_blank" class="w-8 h-8 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 flex items-center justify-center transition-colors" title="Share via WhatsApp" aria-label="Bagikan ke WhatsApp">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('produk.show', $product->slug)) }}" target="_blank" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors" title="Share via Facebook" aria-label="Bagikan ke Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                    </a>
                    <button @click="navigator.clipboard.writeText('{{ route('produk.show', $product->slug) }}'); copied = true; setTimeout(() => copied = false, 2000)" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-colors" title="Salin Link" aria-label="Salin link">
                        <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg x-show="copied" class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- Description --}}
            @if($product->description)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-2">Deskripsi Produk</h3>
                <p class="text-sm text-gray-600 whitespace-pre-line leading-relaxed">{{ $product->description }}</p>
            </div>
            @endif

            {{-- Seller Info --}}
            <a href="{{ route('umkm.show', $product->umkmProfile->slug) }}" class="block bg-blue-50 border border-blue-200 rounded-2xl p-4 hover:bg-blue-100 transition-colors group">
                <p class="text-xs text-blue-500 font-medium mb-1">Dijual oleh</p>
                <p class="font-bold text-blue-800 group-hover:text-blue-900">{{ $product->umkmProfile->name }}</p>
                <p class="text-xs text-blue-600 mt-1 font-medium">Lihat profil lengkap &rarr;</p>
            </a>
        </div>

        {{-- Lightbox Modal --}}
        <div x-show="lightbox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="lightbox = false" @keydown.escape.window="if(lightbox) lightbox = false" class="fixed inset-0 z-[100] bg-black/90 lightbox-overlay flex items-center justify-center p-4 cursor-zoom-out" style="display:none;">
            <button @click="lightbox = false" class="absolute top-4 right-4 text-white/80 hover:text-white transition-colors z-10" aria-label="Tutup">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img :src="lightboxSrc" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl" @click.stop>
        </div>
    </div>
</div>

{{-- Related Products --}}
@if(isset($relatedProducts) && $relatedProducts->count())
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
    <h2 class="text-xl font-bold text-gray-900 mb-5">Produk Serupa</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 stagger-children">
        @foreach($relatedProducts as $relProduct)
        @include('components.product-card', ['product' => $relProduct])
        @endforeach
    </div>
</div>
@endif

@endsection
