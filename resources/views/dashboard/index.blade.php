@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@if(!$umkm)
{{-- No UMKM yet --}}
<div class="max-w-2xl mx-auto text-center py-16">
    <div class="w-20 h-20 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-5">
        <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
    </div>
    <h2 class="text-2xl font-bold text-gray-900 mb-3">Mulai Daftarkan Usaha Anda</h2>
    <p class="text-gray-500 mb-8">Lengkapi profil usaha Anda untuk muncul di direktori UMKM Putat Jaya dan jangkau lebih banyak pelanggan.</p>
    <a href="{{ route('dashboard.profil-usaha') }}" class="inline-flex items-center px-8 py-3 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-colors">
        Buat Profil Usaha
        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
    </a>
</div>
@else

{{-- Status Banner --}}
@if($umkm->verification_status !== 'aktif')
<div class="mb-5 p-4 rounded-xl border flex items-start space-x-3
    @if($umkm->verification_status === 'draft') bg-gray-50 border-gray-200
    @elseif($umkm->verification_status === 'diajukan') bg-amber-50 border-amber-200
    @elseif($umkm->verification_status === 'perlu_revisi') bg-orange-50 border-orange-200
    @elseif($umkm->verification_status === 'ditolak') bg-red-50 border-red-200
    @endif">
    <div class="flex-shrink-0 mt-0.5">
        @if($umkm->verification_status === 'draft')
        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        @elseif($umkm->verification_status === 'diajukan')
        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @elseif($umkm->verification_status === 'perlu_revisi')
        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        @elseif($umkm->verification_status === 'ditolak')
        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @endif
    </div>
    <div class="flex-1">
        <p class="font-semibold text-gray-800">Status: {{ $umkm->status_label }}</p>
        @if($umkm->verification_notes)
        <p class="text-sm text-gray-600 mt-1">{{ $umkm->verification_notes }}</p>
        @endif
        @if(in_array($umkm->verification_status, ['draft', 'perlu_revisi', 'ditolak']))
        <a href="{{ route('dashboard.status-verifikasi') }}" class="inline-block mt-2 text-sm font-medium text-teal-600 hover:text-teal-700">Ajukan Verifikasi →</a>
        @endif
    </div>
</div>
@endif

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500">Total Dilihat</p>
        <p class="text-2xl font-bold text-teal-600 mt-1">{{ number_format($stats['profile_views'] ?? 0) }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500">WhatsApp Diklik</p>
        <p class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($stats['whatsapp_clicks'] ?? 0) }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500">Klik Peta</p>
        <p class="text-2xl font-bold text-teal-600 mt-1">{{ number_format($stats['map_clicks'] ?? 0) }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500">30 Hari Terakhir</p>
        <p class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($stats['views_last_30_days'] ?? 0) }}</p>
    </div>
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('dashboard.profil-usaha') }}" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:border-teal-300 hover:shadow-md transition-all text-center group">
        <div class="text-2xl mb-2">✏️</div>
        <p class="text-sm font-medium text-gray-700 group-hover:text-teal-700">Edit Profil</p>
    </a>
    <a href="{{ route('dashboard.galeri-usaha') }}" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:border-teal-300 hover:shadow-md transition-all text-center group">
        <div class="text-2xl mb-2">📷</div>
        <p class="text-sm font-medium text-gray-700 group-hover:text-teal-700">Tambah Foto</p>
    </a>
    <a href="{{ route('dashboard.produk.create') }}" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:border-teal-300 hover:shadow-md transition-all text-center group">
        <div class="text-2xl mb-2">🛒</div>
        <p class="text-sm font-medium text-gray-700 group-hover:text-teal-700">Tambah Produk</p>
    </a>
    <a href="{{ route('dashboard.qr-code') }}" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:border-teal-300 hover:shadow-md transition-all text-center group">
        <div class="text-2xl mb-2">📱</div>
        <p class="text-sm font-medium text-gray-700 group-hover:text-teal-700">QR Code</p>
    </a>
</div>

{{-- UMKM Summary --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Ringkasan Usaha</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Nama Usaha</span>
                <span class="text-sm font-medium text-gray-800">{{ $umkm->name }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Kategori</span>
                <span class="text-sm font-medium text-gray-800">{{ $umkm->category?->name ?? '-' }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Jumlah Produk</span>
                <span class="text-sm font-medium text-teal-600">{{ $umkm->activeProducts?->count() ?? 0 }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Foto Galeri</span>
                <span class="text-sm font-medium text-teal-600">{{ $umkm->images?->count() ?? 0 }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Lokasi di Peta</span>
                <span class="text-sm font-medium {{ $umkm->latitude ? 'text-emerald-600' : 'text-gray-400' }}">
                    {{ $umkm->latitude ? '✓ Sudah ditentukan' : 'Belum diisi' }}
                </span>
            </div>
        </div>
        @if($umkm->verification_status === 'aktif')
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('umkm.show', $umkm->slug) }}" target="_blank" class="flex items-center text-sm text-teal-600 hover:text-teal-700 font-medium">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat Profil Publik
            </a>
        </div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Produk Terbaru</h3>
        @if($umkm->activeProducts?->count())
        <div class="space-y-2">
            @foreach($umkm->activeProducts->take(5) as $product)
            <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                <span class="text-sm text-gray-700">{{ Str::limit($product->name, 30) }}</span>
                <span class="text-sm font-medium text-teal-600">{{ $product->price > 0 ? 'Rp ' . number_format($product->price, 0, ',', '.') : ($product->price_label ?? '-') }}</span>
            </div>
            @endforeach
        </div>
        <a href="{{ route('dashboard.produk.index') }}" class="mt-3 inline-block text-sm text-teal-600 hover:underline">Kelola semua produk →</a>
        @else
        <div class="text-center py-6">
            <div class="text-3xl mb-2">🛒</div>
            <p class="text-sm text-gray-400">Belum ada produk</p>
            <a href="{{ route('dashboard.produk.create') }}" class="mt-3 inline-block px-4 py-2 bg-teal-600 text-white text-sm rounded-lg hover:bg-teal-700">+ Tambah Produk</a>
        </div>
        @endif
    </div>
</div>
@endif
@endsection
