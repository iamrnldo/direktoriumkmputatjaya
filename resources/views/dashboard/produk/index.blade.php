@extends('layouts.dashboard')
@section('title', 'Manajemen Produk')
@section('page-title', 'Manajemen Produk')

@section('content')
<div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h2 class="text-lg font-bold text-slate-800">Daftar Produk</h2>
        <p class="text-sm text-slate-500">Kelola produk usaha Anda</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('dashboard.produk.export') }}"
            class="flex items-center px-4 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export CSV
        </a>
        <a href="{{ route('dashboard.produk.create') }}"
            class="flex items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if($products->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Produk</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Kategori</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Harga</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
                    <th class="px-4 py-3 text-right font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($product->images->first())
                            <img src="{{ Storage::disk('public')->url($product->images->first()->image_path) }}" alt="{{ $product->name }}"
                                class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                            @else
                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            @endif
                            <div>
                                <p class="font-semibold text-slate-800">{{ Str::limit($product->name, 35) }}</p>
                                @if($product->is_featured)
                                <span class="text-xs text-amber-600 font-medium">⭐ Unggulan</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $product->category?->name ?? '-' }}</td>
                    <td class="px-4 py-3 font-medium text-slate-800">
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
                            <a href="{{ route('dashboard.produk.edit', $product->id) }}"
                                class="text-blue-600 hover:text-blue-800 text-xs font-semibold">Edit</a>
                            <form action="{{ route('dashboard.produk.destroy', $product->id) }}" method="POST" id="delete-produk-{{ $product->id }}">
                                @csrf @method('DELETE')
                                <button type="button" onclick="window.dispatchEvent(new CustomEvent('confirm-delete', {detail: {form: 'delete-produk-{{ $product->id }}', message: 'Produk \"{{ addslashes($product->name) }}\" akan dihapus permanen.'}}))"
                                    class="text-red-500 hover:text-red-700 text-xs font-semibold">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $products->links() }}
    </div>
    @else
    <div class="text-center py-16">
        <div class="text-5xl mb-3">🛒</div>
        <h3 class="font-bold text-slate-700 mb-2">Belum Ada Produk</h3>
        <p class="text-sm text-slate-400 mb-5">Tambahkan produk untuk ditampilkan di direktori.</p>
        <a href="{{ route('dashboard.produk.create') }}"
            class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
            + Tambah Produk Pertama
        </a>
    </div>
    @endif
</div>
@endsection
