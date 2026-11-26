@extends('layouts.dashboard')
@section('title', 'Kontak & Media Sosial')
@section('page-title', 'Kontak & Media Sosial')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="mb-5">
            <h3 class="font-bold text-slate-800 text-lg">Kontak & Media Sosial</h3>
            <p class="text-slate-500 text-sm mt-1">Informasi kontak dan media sosial yang akan ditampilkan ke pelanggan.</p>
        </div>

        <form action="{{ route('dashboard.kontak-media-sosial.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <span class="inline-flex items-center gap-1.5">
                            <span>📱</span> Nomor WhatsApp <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $umkm->whatsapp_number) }}"
                        placeholder="08xxxxxxxxxx" required
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <span class="inline-flex items-center gap-1.5"><span>✉️</span> Email Bisnis</span>
                    </label>
                    <input type="email" name="business_email" value="{{ old('business_email', $umkm->business_email) }}"
                        placeholder="email@usaha.com"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <span class="inline-flex items-center gap-1.5"><span>🌐</span> Website</span>
                    </label>
                    <input type="url" name="website_url" value="{{ old('website_url', $umkm->website_url) }}"
                        placeholder="https://website-usaha.com"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <hr class="border-gray-100">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Media Sosial</p>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <span class="inline-flex items-center gap-1.5"><span>📸</span> Instagram</span>
                    </label>
                    <input type="url" name="instagram_url" value="{{ old('instagram_url', $umkm->instagram_url) }}"
                        placeholder="https://instagram.com/usaha_anda"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <span class="inline-flex items-center gap-1.5"><span>👥</span> Facebook</span>
                    </label>
                    <input type="url" name="facebook_url" value="{{ old('facebook_url', $umkm->facebook_url) }}"
                        placeholder="https://facebook.com/usaha_anda"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <span class="inline-flex items-center gap-1.5"><span>🎵</span> TikTok</span>
                    </label>
                    <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $umkm->tiktok_url) }}"
                        placeholder="https://tiktok.com/@usaha_anda"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <hr class="border-gray-100">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Marketplace</p>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <span class="inline-flex items-center gap-1.5"><span>🛍️</span> Shopee</span>
                    </label>
                    <input type="url" name="shopee_url" value="{{ old('shopee_url', $umkm->shopee_url) }}"
                        placeholder="https://shopee.co.id/usaha_anda"
                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <span class="inline-flex items-center gap-1.5"><span>🏪</span> Tokopedia</span>
                    </label>
                    <input type="url" name="tokopedia_url" value="{{ old('tokopedia_url', $umkm->tokopedia_url) }}"
                        placeholder="https://tokopedia.com/usaha_anda"
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
</div>
@endsection
