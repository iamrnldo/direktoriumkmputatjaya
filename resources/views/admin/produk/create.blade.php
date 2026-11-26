@extends('layouts.admin')
@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.produk.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Data Produk
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilih UMKM Pemilik <span class="text-red-500">*</span></label>
                    <select name="umkm_profile_id" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">— Pilih UMKM —</option>
                        @foreach($umkmList as $u)
                        <option value="{{ $u->id }}" {{ old('umkm_profile_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->owner_name }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Contoh: Nasi Rawon">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori Produk</label>
                        <select name="product_category_id" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('product_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price', 0) }}" min="0"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Ketersediaan <span class="text-red-500">*</span></label>
                    <select name="availability_status" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="available" {{ old('availability_status', 'available') == 'available' ? 'selected' : '' }}>Tersedia (Ready Stock)</option>
                        <option value="out_of_stock" {{ old('availability_status') == 'out_of_stock' ? 'selected' : '' }}>Habis (Stok Kosong)</option>
                        <option value="preorder" {{ old('availability_status') == 'preorder' ? 'selected' : '' }}>Pre-Order</option>
                        <option value="unavailable" {{ old('availability_status') == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Label Harga</label>
                    <input type="text" name="price_label" value="{{ old('price_label') }}"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Contoh: Mulai Rp 15.000">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Produk</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"
                        placeholder="Detail produk...">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Produk</label>
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" data-image-preview="admin-product-image-preview" class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <div id="admin-product-image-preview" class="hidden mt-3 grid grid-cols-3 sm:grid-cols-4 gap-3"></div>
                </div>

                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-amber-500 focus:ring-amber-400">
                        <span class="text-sm font-semibold text-slate-700">⭐ Produk Unggulan</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-semibold text-slate-700">Aktif</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex gap-3 justify-end">
                <a href="{{ route('admin.produk.index') }}" class="px-5 py-2.5 border border-gray-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold text-sm rounded-xl hover:bg-blue-700 transition-colors">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection
