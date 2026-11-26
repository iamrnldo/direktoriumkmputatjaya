@extends('layouts.admin')
@section('title', 'Detail UMKM: ' . $umkm->name)
@section('page-title', 'Detail UMKM')

@section('content')
<div class="max-w-4xl">
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('admin.umkm.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Data UMKM
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('umkm.show', $umkm->slug) }}" target="_blank" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">Lihat Halaman Publik ↗</a>
            <a href="{{ route('admin.umkm.edit', $umkm) }}" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors">Edit Data</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">{{ $umkm->name }}</h2>
                        <p class="text-slate-500 text-sm mt-0.5">Pemilik: <span class="font-semibold text-slate-700">{{ $umkm->owner_name }}</span></p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold
                        {{ $umkm->verification_status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $umkm->status_label }}
                    </span>
                </div>

                <div class="space-y-3 text-sm border-t border-gray-100 pt-4">
                    <div>
                        <span class="text-slate-400">Kategori:</span>
                        <span class="font-medium text-slate-800 ml-2">{{ $umkm->category?->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400">Alamat:</span>
                        <span class="text-slate-700 ml-2">{{ $umkm->address }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400">WhatsApp:</span>
                        <a href="{{ $umkm->whatsapp_link }}" target="_blank" class="text-emerald-600 font-medium ml-2 hover:underline">{{ $umkm->whatsapp_number }}</a>
                    </div>
                    @if($umkm->business_email)
                    <div>
                        <span class="text-slate-400">Email:</span>
                        <span class="text-slate-700 ml-2">{{ $umkm->business_email }}</span>
                    </div>
                    @endif
                </div>

                @if($umkm->business_description)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Usaha</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $umkm->business_description }}</p>
                </div>
                @endif
            </div>

            {{-- Products list --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-slate-800">Daftar Produk ({{ $umkm->products->count() }})</h3>
                </div>
                @if($umkm->products->count())
                <div class="divide-y divide-gray-50">
                    @foreach($umkm->products as $p)
                    <div class="py-3 flex items-center justify-between text-sm">
                        <span class="font-medium text-slate-700">{{ $p->name }}</span>
                        <span class="font-semibold text-blue-600">{{ $p->price > 0 ? 'Rp ' . number_format($p->price, 0, ',', '.') : ($p->price_label ?? '-') }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-slate-400 py-3 text-center">Belum ada produk terdaftar untuk UMKM ini.</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-slate-800 text-sm mb-4">Status & Pengaturan</h3>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1.5 border-b border-gray-50">
                        <span class="text-slate-400">Unggulan:</span>
                        <span class="font-bold {{ $umkm->is_featured ? 'text-amber-600' : 'text-slate-500' }}">{{ $umkm->is_featured ? '⭐ Ya' : 'Tidak' }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50">
                        <span class="text-slate-400">Status Aktif:</span>
                        <span class="font-bold {{ $umkm->is_active ? 'text-emerald-600' : 'text-slate-500' }}">{{ $umkm->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50">
                        <span class="text-slate-400">Total Dilihat:</span>
                        <span class="font-bold text-slate-700">{{ number_format($umkm->view_count ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <span class="text-slate-400">Terdaftar Pada:</span>
                        <span class="text-slate-700">{{ $umkm->created_at->isoFormat('D MMM Y') }}</span>
                    </div>
                </div>
            </div>

            @if($umkm->images->count())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-slate-800 text-sm mb-4">Galeri Foto ({{ $umkm->images->count() }})</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($umkm->images as $img)
                    <img src="{{ Storage::disk('public')->url($img->image_path) }}" alt="" class="w-full h-24 object-cover rounded-xl border border-gray-100">
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
