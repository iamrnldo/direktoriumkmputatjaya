<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UmkmProfileRequest;
use App\Models\UmkmCategory;
use App\Models\UmkmProfile;
use App\Services\UmkmService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(private UmkmService $umkmService) {}

    public function edit()
    {
        $user = Auth::user();
        $umkm = UmkmProfile::where('user_id', $user->id)->with('category', 'images')->first();
        $categories = UmkmCategory::active()->orderBy('sort_order')->get();

        return view('dashboard.profil-usaha', compact('umkm', 'categories'));
    }

    public function store(UmkmProfileRequest $request)
    {
        $umkm = $this->umkmService->create($request->validated(), Auth::id());

        return redirect()->route('dashboard.profil-usaha')
            ->with('success', 'Profil usaha berhasil dibuat! Silakan lengkapi data dan ajukan verifikasi.');
    }

    public function update(UmkmProfileRequest $request)
    {
        $user = Auth::user();
        $umkm = UmkmProfile::where('user_id', $user->id)->firstOrFail();

        $this->authorize('update', $umkm);

        $this->umkmService->update($umkm, $request->validated());

        return redirect()->route('dashboard.profil-usaha')
            ->with('success', 'Profil usaha berhasil diperbarui.');
    }
}
