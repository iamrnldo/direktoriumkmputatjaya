@props(['umkm'])
<a href="{{ route('umkm.show', $umkm->slug ?? '') }}" aria-label="Lihat profil {{ $umkm->name }}" class="card-hover bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col group">
    {{-- Cover Image --}}
    <div class="relative h-44 overflow-hidden bg-slate-100">
        @php
            $cover = $umkm->images?->firstWhere('is_cover', true) ?? $umkm->images?->first();
        @endphp
        @if($cover && Storage::disk('public')->exists($cover->image_path))
            <img src="{{ Storage::disk('public')->url($cover->image_path) }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
        @else
            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-50 text-slate-400">
                <span class="text-4xl mb-1.5 transform group-hover:scale-110 transition-transform duration-300">{{ $umkm->category?->icon_emoji ?? '🏪' }}</span>
                <span class="text-xs font-semibold text-slate-500">{{ $umkm->category?->name ?? 'UMKM Putat Jaya' }}</span>
            </div>
        @endif
        @if($umkm->is_featured)
            <div class="absolute top-2 right-2 bg-amber-400 text-amber-900 text-xs font-bold px-2 py-0.5 rounded-full shadow-sm flex items-center">
                <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Unggulan
            </div>
        @endif
        @if($umkm->verification_status === 'verified')
            <div class="absolute top-2 left-2 bg-blue-600/90 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm flex items-center backdrop-blur-sm">
                <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Terverifikasi
            </div>
        @endif
        @if($umkm->category)
            <div class="absolute bottom-2 left-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-600/90 text-white backdrop-blur-sm shadow-sm">
                    {{ $umkm->category->name }}
                </span>
            </div>
        @endif
    </div>
    {{-- Content --}}
    <div class="p-4 flex-1 flex flex-col">
        <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-1">{{ $umkm->name }}</h3>
        <p class="text-xs text-gray-500 mt-0.5 mb-2">{{ $umkm->owner_name }}</p>
        @if($umkm->business_description)
            <p class="text-sm text-gray-600 line-clamp-2 flex-1">{{ $umkm->business_description }}</p>
        @endif
        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
            <div class="flex items-center text-xs text-gray-400">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="truncate max-w-[120px]">{{ Str::limit($umkm->address, 30) }}</span>
            </div>
            @if(isset($umkm->active_products_count) && $umkm->active_products_count > 0)
                <span class="text-xs text-blue-600 font-medium">{{ $umkm->active_products_count }} Produk</span>
            @endif
        </div>
    </div>
</a>
