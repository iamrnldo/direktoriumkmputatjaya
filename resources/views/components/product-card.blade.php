@props(['product'])
<a href="{{ route('produk.show', $product->slug ?? '') }}" aria-label="Lihat produk {{ $product->name }}" class="card-hover bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col group">
    <div class="relative h-40 overflow-hidden bg-slate-100">
        @php
            $cover = $product->images?->firstWhere('is_cover', true) ?? $product->images?->first();
        @endphp
        @if($cover && Storage::disk('public')->exists($cover->image_path))
            <img src="{{ Storage::disk('public')->url($cover->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
        @else
            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50 text-slate-400">
                <svg class="w-8 h-8 text-slate-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span class="text-[11px] font-medium text-slate-400">{{ $product->category?->name ?? 'Produk' }}</span>
            </div>
        @endif
        @if($product->is_featured)
            <div class="absolute top-2 right-2 bg-amber-400 text-amber-900 text-xs font-bold px-2 py-0.5 rounded-full flex items-center">
                <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Unggulan
            </div>
        @endif
        @if($product->availability_status !== 'available')
            <div class="absolute bottom-2 left-2">
                <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-medium">{{ $product->availability_label ?? 'Tidak Tersedia' }}</span>
            </div>
        @endif
    </div>
    <div class="p-4 flex-1 flex flex-col">
        <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 text-sm">{{ $product->name }}</h3>
        <p class="text-xs text-gray-400 mt-0.5 mb-2 truncate">{{ $product->umkmProfile?->name }}</p>
        <div class="mt-auto">
            @if($product->price > 0)
                <span class="font-bold text-blue-600">{{ $product->price_formatted ?? 'Rp ' . number_format($product->price, 0, ',', '.') }}</span>
            @elseif($product->price_label)
                <span class="font-medium text-blue-600 text-sm">{{ $product->price_label }}</span>
            @else
                <span class="text-gray-400 text-sm">Hubungi Penjual</span>
            @endif
        </div>
    </div>
</a>
