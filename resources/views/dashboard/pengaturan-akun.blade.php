@extends('layouts.dashboard')
@section('title', 'Pengaturan Akun')
@section('page-title', 'Pengaturan Akun')

@section('content')
<div class="max-w-2xl space-y-6">

    {{-- Info Akun --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-slate-800 text-lg mb-5">Informasi Akun</h3>
        <form action="{{ route('dashboard.pengaturan-akun.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Ubah Password --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-slate-800 text-lg mb-5">Ubah Password</h3>
        <form action="{{ route('dashboard.pengaturan-akun.update') }}" method="POST">
            @csrf
            @method('PUT')
            {{-- Hidden fields so validation doesn't complain --}}
            <input type="hidden" name="name" value="{{ $user->name }}">
            <input type="hidden" name="email" value="{{ $user->email }}">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password Saat Ini</label>
                    <input type="password" name="current_password"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password Baru</label>
                    <input type="password" name="password"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <p class="text-xs text-slate-400 mt-1">Minimal 8 karakter</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>

    {{-- Hapus Akun --}}
    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6">
        <h3 class="font-bold text-red-700 text-lg mb-2">Hapus Akun</h3>
        <p class="text-sm text-slate-500 mb-5">Setelah dihapus, semua data akun dan usaha tidak dapat dikembalikan.</p>
        <form action="{{ route('dashboard.pengaturan-akun.destroy') }}" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan!')">
            @csrf
            @method('DELETE')
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Masukkan Password untuk Konfirmasi</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2.5 border border-red-200 rounded-xl text-sm focus:ring-2 focus:ring-red-400 outline-none">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors">
                Hapus Akun Saya
            </button>
        </form>
    </div>

</div>
@endsection
