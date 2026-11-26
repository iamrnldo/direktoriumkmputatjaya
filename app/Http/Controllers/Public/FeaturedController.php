<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UmkmProfile;

class FeaturedController extends Controller
{
    public function umkm()
    {
        $featuredUmkm = UmkmProfile::active()
            ->featured()
            ->with(['category', 'images' => fn($q) => $q->where('is_cover', true)])
            ->withCount('activeProducts')
            ->paginate(12);

        return view('public.umkm-unggulan', compact('featuredUmkm'));
    }

    public function products()
    {
        $featuredProducts = Product::active()
            ->featured()
            ->whereHas('umkmProfile', fn($q) => $q->active())
            ->with(['umkmProfile', 'category', 'images' => fn($q) => $q->where('is_cover', true)])
            ->paginate(12);

        return view('public.produk-unggulan', compact('featuredProducts'));
    }
}
