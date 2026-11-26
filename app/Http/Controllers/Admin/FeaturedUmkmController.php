<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use App\Services\UmkmService;
use Illuminate\Http\Request;

class FeaturedUmkmController extends Controller
{
    public function __construct(private UmkmService $umkmService) {}

    public function index(Request $request)
    {
        $featuredUmkm = UmkmProfile::active()->featured()
            ->with('category')
            ->orderByDesc('view_count')
            ->paginate(12);

        $availableUmkm = UmkmProfile::active()
            ->where('is_featured', false)
            ->with('category')
            ->orderBy('name')
            ->limit(50)
            ->get();

        return view('admin.umkm-unggulan', compact('featuredUmkm', 'availableUmkm'));
    }

    public function toggle(UmkmProfile $umkm)
    {
        $this->umkmService->toggleFeatured($umkm);
        $status = $umkm->fresh()->is_featured ? 'ditandai sebagai unggulan' : 'dihapus dari daftar unggulan';
        return back()->with('success', "{$umkm->name} berhasil {$status}.");
    }
}
