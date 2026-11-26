@extends('layouts.admin')
@section('title', 'Tambah Banner')
@section('page-title', 'Tambah Banner Baru')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.banner.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Banner
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Judul Banner <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Semarak UMKM Putat Jaya">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none" placeholder="Teks penjelasan banner...">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Gambar Banner <span class="text-red-500">*</span></label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp" required data-image-preview="banner-image-preview" class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <div id="banner-image-preview" class="hidden mt-3 max-w-xs grid grid-cols-1"></div>
                    <p class="text-xs text-slate-400 mt-1">Format JPG, PNG, WEBP. Ukuran rekomendasi 1200x500 px</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Teks Tombol (CTA Label)</label>
                        <input type="text" name="cta_label" value="{{ old('cta_label') }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Lihat Selengkapnya">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tautan URL (CTA URL)</label>
                        <input type="url" name="cta_url" value="{{ old('cta_url') }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="https://...">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Berakhir</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="isActive" class="text-sm font-semibold text-slate-700">Aktifkan banner ini</label>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex gap-3 justify-end">
                <a href="{{ route('admin.banner.index') }}" class="px-5 py-2.5 border border-gray-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold text-sm rounded-xl hover:bg-blue-700 transition-colors">Simpan Banner</button>
            </div>
        </form>
    </div>
</div>
@endsection
