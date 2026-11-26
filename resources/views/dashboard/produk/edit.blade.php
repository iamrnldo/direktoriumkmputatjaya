@extends('layouts.dashboard')
@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('dashboard.produk.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Produk
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="font-bold text-slate-800 text-lg mb-5">Edit Produk</h3>

        <form action="{{ route('dashboard.produk.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori Produk <span class="text-red-500">*</span></label>
                        <select name="product_category_id" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('product_category_id', $product->product_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Ketersediaan <span class="text-red-500">*</span></label>
                    <select name="availability_status" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="available" {{ old('availability_status', $product->availability_status) == 'available' ? 'selected' : '' }}>Tersedia (Ready Stock)</option>
                        <option value="out_of_stock" {{ old('availability_status', $product->availability_status) == 'out_of_stock' ? 'selected' : '' }}>Habis (Stok Kosong)</option>
                        <option value="preorder" {{ old('availability_status', $product->availability_status) == 'preorder' ? 'selected' : '' }}>Pre-Order</option>
                        <option value="unavailable" {{ old('availability_status', $product->availability_status) == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Label Harga</label>
                    <input type="text" name="price_label" value="{{ old('price_label', $product->price_label) }}"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Contoh: Mulai Rp 15.000">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Produk</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" id="isActive"
                        {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="isActive" class="text-sm font-semibold text-slate-700">Tampilkan produk (aktif)</label>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex gap-3 justify-end">
                <a href="{{ route('dashboard.produk.index') }}"
                    class="px-5 py-2.5 border border-gray-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold text-sm rounded-xl hover:bg-blue-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Upload Foto Tambahan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-slate-800 mb-4">Foto Produk</h3>

        @if($product->images && $product->images->count() > 0)
        <div class="grid grid-cols-3 gap-3 mb-4">
            @foreach($product->images as $img)
            <div class="relative group rounded-xl overflow-hidden aspect-square border border-gray-100">
                <img src="{{ Storage::disk('public')->url($img->image_path) }}" class="w-full h-full object-cover" alt="">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <form action="{{ route('dashboard.produk.gambar.destroy', [$product->id, $img->id]) }}" method="POST"
                        onsubmit="return confirm('Hapus foto ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <form action="{{ route('dashboard.produk.gambar.store', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex items-center gap-3">
                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" data-image-preview="dashboard-product-extra-preview"
                    class="flex-1 text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <div id="dashboard-product-extra-preview" class="hidden mt-4 grid grid-cols-3 sm:grid-cols-4 gap-3"></div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors flex-shrink-0">
                    Tambah Foto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
