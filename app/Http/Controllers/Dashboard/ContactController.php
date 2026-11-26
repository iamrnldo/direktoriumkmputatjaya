<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function edit()
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())->firstOrFail();
        return view('dashboard.kontak-media-sosial', compact('umkm'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'business_email' => ['nullable', 'email', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:500'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'facebook_url' => ['nullable', 'url', 'max:500'],
            'tiktok_url' => ['nullable', 'url', 'max:500'],
            'shopee_url' => ['nullable', 'url', 'max:500'],
            'tokopedia_url' => ['nullable', 'url', 'max:500'],
            'marketplace_url' => ['nullable', 'url', 'max:500'],
        ]);

        $umkm = UmkmProfile::where('user_id', Auth::id())->firstOrFail();
        $umkm->update($request->only([
            'whatsapp_number', 'business_email', 'website_url',
            'instagram_url', 'facebook_url', 'tiktok_url',
            'shopee_url', 'tokopedia_url', 'marketplace_url',
        ]));

        return back()->with('success', 'Kontak dan media sosial berhasil diperbarui.');
    }
}
