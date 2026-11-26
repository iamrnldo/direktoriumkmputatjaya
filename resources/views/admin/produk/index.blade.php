@extends('layouts.admin')
@section('title', 'Data Produk')
@section('page-title', 'Data Produk')

@section('content')
<div class="mb-5 flex flex-wrap gap-3 justify-between items-center">
    <form method="GET" action="{{ route('admin.produk.index') }}" class="flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk..."
            class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none w-52">
        <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm outline-none">
            <option value="">Semua Status</option>
            <option value="tersedia" {{ request('status')=='tersedia'?'selected':'' }}>Tersedia</option>
            <option value="habis" {{ request('status')=='habis'?'selected':'' }}>Habis</option>
            <option value="preorder" {{ request('status')=='preorder'?'selected':'' }}>Pre-Order</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Filter</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Produk</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">UMKM</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Kategori</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Harga</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-800">{{ Str::limit($product->name, 40) }}</p>
                        @if($product->is_featured)
                        <span class="text-xs text-amber-600">⭐ Unggulan</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-xs">{{ $product->umkmProfile?->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $product->category?->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-800 font-medium">
                        @if($product->price > 0)
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        @else
                            {{ $product->price_label ?? '-' }}
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.produk.edit', $product) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">Edit</a>
                            <form action="{{ route('admin.produk.destroy', $product) }}" method="POST"
                                onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-gray-400">Belum ada data produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $products->links('components.pagination') }}
    </div>
</div>
@endsection
