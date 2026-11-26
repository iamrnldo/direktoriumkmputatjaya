@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
    <h3 class="text-3xl font-medium text-gray-700">Pengaturan Sistem</h3>
    <p class="mt-2 text-gray-600">Kelola pengaturan dasar direktori UMKM.</p>

    <div class="mt-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Website</label>
                    <input type="text" id="site_name" name="site_name" value="Direktori UMKM Putat Jaya" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                </div>
                
                <div class="mb-4">
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email Kontak</label>
                    <input type="email" id="contact_email" name="contact_email" value="admin@putatjaya.go.id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                </div>
                
                <div class="mb-4">
                    <label for="about_text" class="block text-sm font-medium text-gray-700 mb-1">Tentang Kami</label>
                    <textarea id="about_text" name="about_text" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">Platform resmi direktori UMKM Kelurahan Putat Jaya, Kecamatan Sawahan, Kota Surabaya.</textarea>
                </div>
                
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <button type="submit" class="bg-teal-600 text-white px-6 py-2 rounded shadow hover:bg-teal-700 focus:outline-none">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
