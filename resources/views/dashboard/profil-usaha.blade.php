@extends('layouts.dashboard')
@section('title', 'Profil Usaha')
@section('page-title', 'Profil Usaha')

@section('content')
<div class="max-w-3xl">

@if(!$umkm)
{{-- Belum punya profil --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <div class="text-center py-4 mb-6">
        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Buat Profil Usaha Baru</h3>
        <p class="text-slate-500 text-sm">Lengkapi data usaha Anda untuk ditampilkan di direktori UMKM Kelurahan Putat Jaya.</p>
    </div>

    <form action="{{ route('dashboard.profil-usaha.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Usaha <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                    placeholder="Contoh: Warung Bu Siti">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Pemilik <span class="text-red-500">*</span></label>
                <input type="text" name="owner_name" value="{{ old('owner_name', auth()->user()->name) }}" required
                    class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">NIK Pemilik</label>
                <input type="text" name="owner_nik" value="{{ old('owner_nik') }}" inputmode="numeric" maxlength="16" pattern="[0-9]{16}" autocomplete="off"
                    class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="16 digit angka">
                @error('owner_nik')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">RT Pemilik</label>
                    <input type="text" name="owner_rt" value="{{ old('owner_rt') }}" inputmode="numeric" maxlength="3" pattern="[0-9]{1,3}"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: 001">
                    @error('owner_rt')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">RW Pemilik</label>
                    <input type="text" name="owner_rw" value="{{ old('owner_rw') }}" inputmode="numeric" maxlength="3" pattern="[0-9]{1,3}"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: 005">
                    @error('owner_rw')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori Usaha <span class="text-red-500">*</span></label>
                <select name="category_id" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">— Pilih Kategori —</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor WhatsApp <span class="text-red-500">*</span></label>
                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', auth()->user()->phone) }}" placeholder="08xxxxxxxxxx" required
                    class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Usaha <span class="text-red-500">*</span></label>
                <input type="text" name="address" value="{{ old('address') }}" required
                    class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                    placeholder="Jl. Putat Jaya...">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Usaha</label>
                <textarea name="business_description" rows="4" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"
                    placeholder="Ceritakan tentang usaha Anda, produk unggulan, dsb...">{{ old('business_description') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Usaha</label>
                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" data-image-preview="profile-create-image-preview" class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <div id="profile-create-image-preview" class="hidden mt-3 grid grid-cols-3 sm:grid-cols-4 gap-3"></div>
                <p class="mt-1 text-xs text-slate-400">JPG, PNG, WEBP · Maks. 5 MB per foto · Maks. 10 foto</p>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                Buat Profil Usaha
            </button>
        </div>
    </form>
</div>

@else
{{-- Edit profil --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="font-bold text-slate-800 text-lg">Informasi Usaha</h3>
            <p class="text-xs text-slate-400 mt-0.5">Perbarui informasi profil usaha Anda</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-bold
            {{ $umkm->verification_status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
            {{ $umkm->status_label }}
        </span>
    </div>

    <form action="{{ route('dashboard.profil-usaha.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Usaha <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $umkm->name) }}" required
                    class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Pemilik <span class="text-red-500">*</span></label>
                <input type="text" name="owner_name" value="{{ old('owner_name', $umkm->owner_name) }}" required
                    class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">NIK Pemilik</label>
                <input type="text" name="owner_nik" value="{{ old('owner_nik', $umkm->owner_nik) }}" inputmode="numeric" maxlength="16" pattern="[0-9]{16}" autocomplete="off"
                    class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="16 digit angka">
                @error('owner_nik')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">RT Pemilik</label>
                    <input type="text" name="owner_rt" value="{{ old('owner_rt', $umkm->owner_rt) }}" inputmode="numeric" maxlength="3" pattern="[0-9]{1,3}"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: 001">
                    @error('owner_rt')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">RW Pemilik</label>
                    <input type="text" name="owner_rw" value="{{ old('owner_rw', $umkm->owner_rw) }}" inputmode="numeric" maxlength="3" pattern="[0-9]{1,3}"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: 005">
                    @error('owner_rw')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori Usaha <span class="text-red-500">*</span></label>
                <select name="category_id" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">— Pilih Kategori —</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $umkm->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor WhatsApp <span class="text-red-500">*</span></label>
                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $umkm->whatsapp_number) }}" placeholder="08xxxxxxxxxx" required
                    class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Usaha <span class="text-red-500">*</span></label>
                <input type="text" name="address" value="{{ old('address', $umkm->address) }}" required
                    class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Usaha</label>
                <textarea name="business_description" rows="4" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('business_description', $umkm->business_description) }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tambah Foto Usaha</label>
                @if($umkm->images->isNotEmpty())
                <div class="mb-3 grid grid-cols-3 sm:grid-cols-4 gap-3">
                    @foreach($umkm->images as $image)
                    <img src="{{ Storage::disk('public')->url($image->image_path) }}" alt="{{ $umkm->name }}" class="h-24 w-full rounded-lg border border-slate-200 object-cover">
                    @endforeach
                </div>
                @endif
                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" data-image-preview="profile-edit-image-preview" class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <div id="profile-edit-image-preview" class="hidden mt-3 grid grid-cols-3 sm:grid-cols-4 gap-3"></div>
                <p class="mt-1 text-xs text-slate-400">JPG, PNG, WEBP · Maks. 5 MB per foto · Maks. 10 foto</p>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endif

</div>
@endsection
