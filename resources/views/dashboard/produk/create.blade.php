@extends('layouts.dashboard')
@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('dashboard.produk.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Produk
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-slate-800 text-lg mb-5">Tambah Produk Baru</h3>

        <form action="{{ route('dashboard.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Contoh: Nasi Goreng Spesial">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori Produk <span class="text-red-500">*</span></label>
                        <select name="product_category_id" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('product_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price', 0) }}" min="0"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="0">
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
                        placeholder="Contoh: Mulai Rp 15.000, Hubungi Kami, dll">
                    <p class="text-xs text-slate-400 mt-1">Gunakan label harga jika harga bervariasi</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Produk</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"
                        placeholder="Ceritakan tentang produk Anda...">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Produk</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-blue-300 transition-colors">
                        <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" class="hidden" id="productImages"
                            data-image-preview="product-image-preview" onchange="updateProductLabel(this)">
                        <div id="product-image-preview" class="hidden mt-4 grid grid-cols-3 sm:grid-cols-4 gap-3 text-left"></div>
                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <label for="productImages" class="cursor-pointer text-sm text-blue-600 font-semibold hover:text-blue-700">Klik untuk memilih foto</label>
                        <p class="text-xs text-slate-400 mt-1" id="productFileLabel">Format JPG/PNG/WEBP, maks 5 MB per foto</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" id="isActive"
                        {{ old('is_active', '1') == '1' ? 'checked' : '' }}
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
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function updateProductLabel(input) {
    const label = document.getElementById('productFileLabel');
    label.textContent = input.files.length > 0 ? input.files.length + ' foto dipilih' : 'Format JPG/PNG/WEBP, maks 5 MB per foto';
}
</script>
@endpush
@endsection
