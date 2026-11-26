<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UmkmCategory;
use App\Models\UmkmProfile;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(private AnalyticsService $analytics) {}

    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $type = $request->input('type', 'semua'); // semua, umkm, produk

        $umkmResults = collect();
        $productResults = collect();

        if ($query && in_array($type, ['semua', 'umkm'])) {
            $umkmResults = UmkmProfile::active()
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('owner_name', 'like', "%{$query}%")
                      ->orWhere('business_description', 'like', "%{$query}%");
                })
                ->with(['category', 'images' => fn($q) => $q->where('is_cover', true)])
                ->limit(10)
                ->get();
        }

        if ($query && in_array($type, ['semua', 'produk'])) {
            $productResults = Product::active()
                ->whereHas('umkmProfile', fn($q) => $q->active())
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('short_description', 'like', "%{$query}%");
                })
                ->with(['umkmProfile', 'images' => fn($q) => $q->where('is_cover', true)])
                ->limit(10)
                ->get();
        }

        if ($query) {
            $this->analytics->trackSearch($query);
        }

        $categories = UmkmCategory::active()->orderBy('sort_order')->get();

        return view('public.cari', compact('query', 'type', 'umkmResults', 'productResults', 'categories'));
    }
}
