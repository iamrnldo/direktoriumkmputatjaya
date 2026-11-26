@extends('layouts.admin')
@section('title', 'Tinjau: ' . $umkm->name)
@section('page-title', 'Tinjauan Verifikasi')

@section('content')
<div class="max-w-5xl" x-data="verifyPanel()">

    {{-- Back + Header --}}
    <div class="flex items-center space-x-3 mb-6">
        <a href="{{ route('admin.verifikasi-umkm.index') }}"
           class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="font-bold text-slate-900 text-lg">{{ $umkm->name }}</h2>
            <p class="text-xs text-slate-400">Diajukan {{ $umkm->updated_at->diffForHumans() }} &bull; {{ $umkm->updated_at->isoFormat('D MMMM Y, HH:mm') }}</p>
        </div>
        <div class="ml-auto">
            @php
                $badgeClass = match($umkm->verification_status) {
                    'diajukan'    => 'bg-amber-100 text-amber-700 border-amber-200',
                    'aktif'       => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                    'ditolak'     => 'bg-red-100 text-red-700 border-red-200',
                    'perlu_revisi'=> 'bg-orange-100 text-orange-700 border-orange-200',
                    default       => 'bg-slate-100 text-slate-600 border-slate-200',
                };
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                {{ $umkm->status_label }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Business Info (2/3 width) --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Identity Card --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-800">Identitas Usaha</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Nama Usaha</p>
                            <p class="font-bold text-slate-900 text-base">{{ $umkm->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Pemilik</p>
                            <p class="font-semibold text-slate-800">{{ $umkm->owner_name }}</p>
                            @if($umkm->user)
                            <p class="text-xs text-slate-400 mt-0.5">{{ $umkm->user->email }}</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Kategori Usaha</p>
                            <span class="inline-flex items-center space-x-1.5 px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-sm font-semibold border border-blue-100">
                                <span>{{ $umkm->category?->icon ?? '🏪' }}</span>
                                <span>{{ $umkm->category?->name ?? '-' }}</span>
                            </span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">WhatsApp</p>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $umkm->whatsapp_number) }}" target="_blank"
                               class="inline-flex items-center space-x-1.5 font-semibold text-emerald-600 hover:text-emerald-700 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                <span>{{ $umkm->whatsapp_number }}</span>
                            </a>
                        </div>
                        @if($umkm->business_email)
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Email Usaha</p>
                            <p class="text-slate-700 text-sm">{{ $umkm->business_email }}</p>
                        </div>
                        @endif
                        @if($umkm->website_url)
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Website</p>
                            <a href="{{ $umkm->website_url }}" target="_blank" class="text-blue-600 hover:underline text-sm truncate block">{{ $umkm->website_url }}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Address Card --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center space-x-3">
                    <div class="w-8 h-8 bg-orange-100 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-800">Lokasi Usaha</h3>
                    @if($umkm->latitude)
                    <span class="ml-auto text-xs font-bold px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-full border border-emerald-200">✓ Koordinat Ada</span>
                    @else
                    <span class="ml-auto text-xs font-bold px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full border border-amber-200">⚠ Belum ada koordinat</span>
                    @endif
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Alamat Lengkap</p>
                            <p class="text-slate-800 font-medium">{{ $umkm->address }}</p>
                        </div>
                        @if($umkm->village || $umkm->district)
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Kelurahan / Kecamatan</p>
                            <p class="text-slate-700 text-sm">{{ implode(', ', array_filter([$umkm->village, $umkm->district])) }}</p>
                        </div>
                        @endif
                        @if($umkm->city)
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Kota / Provinsi</p>
                            <p class="text-slate-700 text-sm">{{ implode(', ', array_filter([$umkm->city, $umkm->province])) }}</p>
                        </div>
                        @endif
                        @if($umkm->latitude && $umkm->longitude)
                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">Koordinat GPS</p>
                            <div class="flex items-center space-x-3">
                                <code class="text-xs bg-slate-100 px-3 py-1.5 rounded-lg text-slate-600 font-mono">{{ $umkm->latitude }}, {{ $umkm->longitude }}</code>
                                <a href="https://maps.google.com/?q={{ $umkm->latitude }},{{ $umkm->longitude }}" target="_blank"
                                   class="text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                                    Buka di Google Maps →
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Description --}}
            @if($umkm->business_description)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center space-x-3">
                    <div class="w-8 h-8 bg-violet-100 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-800">Deskripsi Usaha</h3>
                </div>
                <div class="p-6">
                    <p class="text-slate-700 text-sm leading-relaxed">{{ $umkm->business_description }}</p>
                </div>
            </div>
            @endif

            {{-- Social Media & Marketplace --}}
            @php
                $socials = array_filter([
                    'Instagram' => $umkm->instagram_url,
                    'Facebook'  => $umkm->facebook_url,
                    'TikTok'    => $umkm->tiktok_url,
                    'Shopee'    => $umkm->shopee_url,
                    'Tokopedia' => $umkm->tokopedia_url,
                ]);
            @endphp
            @if(count($socials))
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center space-x-3">
                    <div class="w-8 h-8 bg-pink-100 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-800">Media Sosial & Marketplace</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($socials as $label => $url)
                        <a href="{{ $url }}" target="_blank"
                           class="flex items-center space-x-2.5 p-3 bg-slate-50 rounded-xl border border-slate-100 hover:bg-blue-50 hover:border-blue-200 transition-colors group">
                            <span class="text-base">{{ match($label) { 'Instagram'=>'📸', 'Facebook'=>'📘', 'TikTok'=>'🎵', 'Shopee'=>'🛒', 'Tokopedia'=>'🛍️', default=>'🔗' } }}</span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-500 uppercase">{{ $label }}</p>
                                <p class="text-xs text-blue-600 group-hover:text-blue-700 truncate">{{ $url }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Gallery --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-amber-100 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800">Foto Galeri</h3>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 {{ $umkm->images->count() ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }} rounded-full">
                        {{ $umkm->images->count() }} foto
                    </span>
                </div>
                <div class="p-6">
                    @if($umkm->images->count())
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                        @foreach($umkm->images as $img)
                        <div class="relative group rounded-xl overflow-hidden border border-slate-100" style="aspect-ratio:1">
                            <img src="{{ Storage::disk('public')->url($img->image_path) }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Foto galeri">
                            @if($img->is_cover)
                            <div class="absolute top-1 left-1 bg-amber-400 text-amber-900 text-[9px] font-black px-1.5 py-0.5 rounded-full shadow">Cover</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 text-slate-400">
                        <div class="text-3xl mb-2">📷</div>
                        <p class="text-sm font-medium">Belum ada foto galeri diunggah</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Products Summary --}}
            @if($umkm->activeProducts->count())
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800">Produk Terdaftar</h3>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full">{{ $umkm->activeProducts->count() }} produk</span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($umkm->activeProducts->take(6) as $product)
                        <div class="flex items-center space-x-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            @if($product->images->first())
                            <img src="{{ Storage::disk('public')->url($product->images->first()->image_path) }}" class="w-10 h-10 object-cover rounded-lg flex-shrink-0" alt="">
                            @else
                            <div class="w-10 h-10 bg-slate-200 rounded-lg flex items-center justify-center flex-shrink-0 text-slate-400 text-lg">🛒</div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-slate-500">{{ $product->price > 0 ? 'Rp ' . number_format($product->price, 0, ',', '.') : ($product->price_label ?? 'Harga negosiasi') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Verification History --}}
            @if($umkm->verifications->count())
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center space-x-3">
                    <div class="w-8 h-8 bg-slate-200 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-800">Riwayat Verifikasi</h3>
                </div>
                <div class="p-6">
                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-slate-100"></div>
                        <div class="space-y-5">
                            @foreach($umkm->verifications as $v)
                            @php
                                $vIcon = $v->status === 'approved' ? '✅' : ($v->status === 'rejected' ? '❌' : '⚠️');
                                $vBg   = $v->status === 'approved' ? 'bg-emerald-100' : ($v->status === 'rejected' ? 'bg-red-100' : 'bg-orange-100');
                                $vLabel= $v->status === 'approved' ? 'Disetujui' : ($v->status === 'rejected' ? 'Ditolak' : 'Diminta Revisi');
                            @endphp
                            <div class="flex items-start space-x-4 relative">
                                <div class="w-8 h-8 {{ $vBg }} rounded-full flex items-center justify-center flex-shrink-0 z-10 ring-2 ring-white text-sm">{{ $vIcon }}</div>
                                <div class="flex-1 pb-2">
                                    <p class="text-sm font-bold text-slate-800">{{ $vLabel }}</p>
                                    <p class="text-xs text-slate-400">oleh {{ $v->admin?->name ?? 'Sistem' }} &bull; {{ $v->created_at->isoFormat('D MMM Y, HH:mm') }}</p>
                                    @if($v->notes)
                                    <p class="text-sm text-slate-600 mt-1 p-2.5 bg-slate-50 rounded-lg border border-slate-100">{{ $v->notes }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- RIGHT: Actions Panel (1/3 width) --}}
        <div class="space-y-5">

            {{-- Quick Stats --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="font-bold text-slate-800 mb-4 text-sm">Kelengkapan Data</h3>
                <div class="space-y-3">
                    @php
                        $checks = [
                            ['label' => 'Nama & Pemilik',    'ok' => $umkm->name && $umkm->owner_name],
                            ['label' => 'Kategori Usaha',    'ok' => (bool) $umkm->category_id],
                            ['label' => 'Alamat Lengkap',    'ok' => (bool) $umkm->address],
                            ['label' => 'Nomor WhatsApp',    'ok' => (bool) $umkm->whatsapp_number],
                            ['label' => 'Deskripsi Usaha',   'ok' => (bool) $umkm->business_description],
                            ['label' => 'Foto Galeri',       'ok' => $umkm->images->count() > 0],
                            ['label' => 'Koordinat Lokasi',  'ok' => (bool) $umkm->latitude],
                        ];
                        $completedCount = collect($checks)->where('ok', true)->count();
                    @endphp
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold text-slate-500">Kelengkapan</span>
                        <span class="text-xs font-bold text-slate-700">{{ $completedCount }}/{{ count($checks) }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 mb-3">
                        @php $pct = round($completedCount / count($checks) * 100); @endphp
                        <div class="h-2 rounded-full {{ $pct >= 80 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-amber-400' : 'bg-red-400') }}" style="width: {{ $pct }}%"></div>
                    </div>
                    @foreach($checks as $check)
                    <div class="flex items-center space-x-2.5">
                        @if($check['ok'])
                        <div class="w-5 h-5 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-slate-700">{{ $check['label'] }}</span>
                        @else
                        <div class="w-5 h-5 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-red-500">{{ $check['label'] }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- View Public Profile --}}
            <a href="{{ route('umkm.show', $umkm->slug) }}" target="_blank"
               class="flex items-center justify-center space-x-2 w-full py-2.5 px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                <span>Lihat Profil Publik</span>
            </a>

            {{-- Action Panel --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-slate-50">
                    <h3 class="font-bold text-slate-800">Tindakan Verifikasi</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Pilih tindakan yang sesuai</p>
                </div>
                <div class="p-5 space-y-4">

                    {{-- ✅ APPROVE --}}
                    <div class="border border-emerald-200 rounded-xl overflow-hidden">
                        <div class="bg-emerald-50 px-4 py-2.5 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-bold text-emerald-700">Setujui & Aktifkan</span>
                        </div>
                        <div class="p-4">
                            <form method="POST" action="{{ route('admin.verifikasi-umkm.approve', $umkm->id) }}"
                                  @submit.prevent="confirmApprove($event)">
                                @csrf
                                <textarea name="notes" rows="2"
                                    placeholder="Catatan untuk pemilik UMKM (opsional)..."
                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm outline-none mb-3 focus:ring-2 focus:ring-emerald-400 resize-none"></textarea>
                                <label class="flex items-center space-x-2 mb-3 cursor-pointer">
                                    <input type="checkbox" name="is_featured" value="1"
                                           class="w-4 h-4 text-amber-500 rounded border-slate-300 focus:ring-amber-400">
                                    <span class="text-sm text-slate-700">⭐ Tandai sebagai UMKM Unggulan</span>
                                </label>
                                <button type="submit"
                                    class="w-full py-2.5 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 transition-colors flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Setujui & Aktifkan</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- ⚠️ REQUEST REVISION --}}
                    <div class="border border-amber-200 rounded-xl overflow-hidden">
                        <div class="bg-amber-50 px-4 py-2.5 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span class="text-sm font-bold text-amber-700">Minta Revisi</span>
                        </div>
                        <div class="p-4">
                            <form method="POST" action="{{ route('admin.verifikasi-umkm.request-revision', $umkm->id) }}">
                                @csrf
                                <textarea name="notes" rows="2"
                                    placeholder="Jelaskan apa yang perlu diperbaiki oleh pemilik UMKM..."
                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm outline-none mb-3 focus:ring-2 focus:ring-amber-400 resize-none" required></textarea>
                                <button type="submit"
                                    class="w-full py-2.5 bg-amber-500 text-white text-sm font-bold rounded-xl hover:bg-amber-600 transition-colors flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Kirim Permintaan Revisi</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- ❌ REJECT --}}
                    <div class="border border-red-200 rounded-xl overflow-hidden">
                        <div class="bg-red-50 px-4 py-2.5 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-bold text-red-700">Tolak Pengajuan</span>
                        </div>
                        <div class="p-4">
                            <form method="POST" action="{{ route('admin.verifikasi-umkm.reject', $umkm->id) }}"
                                  @submit.prevent="confirmReject($event)">
                                @csrf
                                <textarea name="notes" rows="2"
                                    placeholder="Alasan penolakan (wajib diisi, akan dikirim ke pemilik UMKM)..."
                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm outline-none mb-3 focus:ring-2 focus:ring-red-400 resize-none" required></textarea>
                                <button type="submit"
                                    class="w-full py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition-colors flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span>Tolak Pengajuan</span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- ===== CONFIRM APPROVE MODAL ===== --}}
    <div x-show="showApprove" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showApprove = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 z-10"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 text-center mb-2">Setujui Verifikasi?</h3>
            <p class="text-sm text-slate-500 text-center mb-1">UMKM <strong class="text-slate-700">{{ $umkm->name }}</strong> akan diaktifkan dan muncul di direktori publik.</p>
            <p class="text-xs text-slate-400 text-center mb-6">Pemilik UMKM akan mendapat notifikasi bahwa usahanya telah diverifikasi.</p>
            <div class="flex space-x-3">
                <button @click="showApprove = false"
                    class="flex-1 py-2.5 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button @click="submitApprove()"
                    class="flex-1 py-2.5 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 transition-colors">
                    Ya, Setujui
                </button>
            </div>
        </div>
    </div>

    {{-- ===== CONFIRM REJECT MODAL ===== --}}
    <div x-show="showReject" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showReject = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 z-10"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 text-center mb-2">Tolak Pengajuan?</h3>
            <p class="text-sm text-slate-500 text-center mb-1">UMKM <strong class="text-slate-700">{{ $umkm->name }}</strong> akan ditolak.</p>
            <p class="text-xs text-slate-400 text-center mb-6">Pemilik UMKM akan menerima alasan penolakan yang sudah Anda tulis.</p>
            <div class="flex space-x-3">
                <button @click="showReject = false"
                    class="flex-1 py-2.5 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button @click="submitReject()"
                    class="flex-1 py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition-colors">
                    Ya, Tolak
                </button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function verifyPanel() {
    return {
        showApprove: false,
        showReject: false,
        pendingApproveForm: null,
        pendingRejectForm: null,

        confirmApprove(e) {
            this.pendingApproveForm = e.target;
            this.showApprove = true;
        },
        submitApprove() {
            this.showApprove = false;
            if (this.pendingApproveForm) this.pendingApproveForm.submit();
        },
        confirmReject(e) {
            const textarea = e.target.querySelector('textarea[name="notes"]');
            if (!textarea || textarea.value.trim() === '') {
                textarea.focus();
                textarea.style.borderColor = '#ef4444';
                return;
            }
            this.pendingRejectForm = e.target;
            this.showReject = true;
        },
        submitReject() {
            this.showReject = false;
            if (this.pendingRejectForm) this.pendingRejectForm.submit();
        }
    }
}
</script>
@endpush

@endsection
