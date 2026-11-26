@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.pengguna.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Data Pengguna
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.pengguna.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Nama pengguna">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="email@contoh.com">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="08xxxxxxxxxx">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Peran / Role <span class="text-red-500">*</span></label>
                    <select name="role" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">— Pilih Peran —</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $role->name)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Min 8 karakter">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Ulangi password">
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex gap-3 justify-end">
                <a href="{{ route('admin.pengguna.index') }}" class="px-5 py-2.5 border border-gray-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold text-sm rounded-xl hover:bg-blue-700 transition-colors">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>
@endsection
