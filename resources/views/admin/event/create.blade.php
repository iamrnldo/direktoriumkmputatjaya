@extends('layouts.admin')
@section('title', 'Tambah Event')
@section('page-title', 'Tambah Event Baru')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.event.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Event
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Judul Acara <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Bazar UMKM Putat Jaya">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Acara <span class="text-red-500">*</span></label>
                        <input type="date" name="event_date" value="{{ old('event_date') }}" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Waktu Mulai</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Waktu Selesai</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Tempat / Lokasi</label>
                    <input type="text" name="location_name" value="{{ old('location_name') }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Balai RW 03 Putat Jaya">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Lengkap</label>
                    <input type="text" name="address" value="{{ old('address') }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Jl. Putat Jaya No...">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Acara <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none" placeholder="Jelaskan detail kegiatan...">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Sampul (Cover)</label>
                    <input type="file" name="cover_image" accept="image/jpeg,image/png,image/webp" data-image-preview="event-cover-preview" class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <div id="event-cover-preview" class="hidden mt-3 max-w-xs grid grid-cols-1"></div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="isActive" class="text-sm font-semibold text-slate-700">Publikasikan acara ini (Aktif)</label>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex gap-3 justify-end">
                <a href="{{ route('admin.event.index') }}" class="px-5 py-2.5 border border-gray-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold text-sm rounded-xl hover:bg-blue-700 transition-colors">Simpan Event</button>
            </div>
        </form>
    </div>
</div>
@endsection
