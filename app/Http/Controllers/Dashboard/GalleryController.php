<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UmkmImage;
use App\Models\UmkmProfile;
use App\Services\UmkmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function __construct(private UmkmService $umkmService) {}

    private function getOwnedUmkm(): ?UmkmProfile
    {
        return UmkmProfile::where('user_id', Auth::id())->with('images')->first();
    }

    public function index()
    {
        $umkm = $this->getOwnedUmkm();

        if (!$umkm) {
            return redirect()->route('dashboard.profil-usaha')
                ->with('error', 'Silakan lengkapi profil usaha Anda terlebih dahulu sebelum mengelola galeri foto.');
        }

        return view('dashboard.galeri-usaha', compact('umkm'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images'   => ['required', 'array', 'min:1', 'max:10'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'images.required'  => 'Harap pilih minimal satu foto.',
            'images.*.image'   => 'File harus berupa gambar.',
            'images.*.mimes'   => 'Format harus JPG, PNG, atau WEBP.',
            'images.*.max'     => 'Ukuran tiap gambar maksimal 5 MB.',
        ]);

        $umkm = UmkmProfile::where('user_id', Auth::id())->first();

        if (!$umkm) {
            return redirect()->route('dashboard.profil-usaha')
                ->with('error', 'Profil usaha tidak ditemukan.');
        }

        $files = $request->file('images', []);
        $this->umkmService->uploadImages($umkm, $files);

        return back()->with('success', count($files) . ' foto berhasil diunggah ke galeri.');
    }

    public function destroy(UmkmImage $image)
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())->first();

        if (!$umkm || $image->umkm_profile_id !== $umkm->id) {
            abort(403, 'Anda tidak berwenang menghapus foto ini.');
        }

        $this->umkmService->deleteImage($image);

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function setCover(UmkmImage $image)
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())->first();

        if (!$umkm || $image->umkm_profile_id !== $umkm->id) {
            abort(403, 'Anda tidak berwenang mengatur foto ini.');
        }

        $this->umkmService->setCoverImage($image);

        return back()->with('success', 'Foto cover berhasil diatur.');
    }
}
