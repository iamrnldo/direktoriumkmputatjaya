<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use App\Services\MapService;
use App\Services\UmkmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function __construct(private UmkmService $umkmService, private MapService $mapService) {}

    public function edit()
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())->firstOrFail();
        $center = $this->mapService->getDefaultCenter();
        return view('dashboard.lokasi', compact('umkm', 'center'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ], [
            'latitude.required' => 'Latitude wajib diisi.',
            'latitude.between' => 'Latitude harus antara -90 dan 90.',
            'longitude.required' => 'Longitude wajib diisi.',
            'longitude.between' => 'Longitude harus antara -180 dan 180.',
        ]);

        $umkm = UmkmProfile::where('user_id', Auth::id())->firstOrFail();
        $this->umkmService->updateLocation($umkm, $request->latitude, $request->longitude);

        return back()->with('success', 'Lokasi usaha berhasil diperbarui.');
    }
}
