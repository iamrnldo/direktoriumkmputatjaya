<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\UmkmCategory;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private AnalyticsService $analytics) {}

    public function index(Request $request)
    {
        $query = Product::active()
            ->whereHas('umkmProfile', fn($q) => $q->active())
            ->with(['umkmProfile', 'category', 'images' => fn($q) => $q->where('is_cover', true)]);

        // Search
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter category
        if ($catSlug = $request->input('kategori')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $catSlug));
        }

        // Filter UMKM category
        if ($umkmCat = $request->input('kategori-umkm')) {
            $query->whereHas('umkmProfile.category', fn($q) => $q->where('slug', $umkmCat));
        }

        // Filter price range
        if ($minPrice = $request->input('harga-min')) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice = $request->input('harga-max')) {
            $query->where('price', '<=', $maxPrice);
        }

        // Filter availability
        if ($status = $request->input('status')) {
            $query->where('availability_status', $status);
        }

        // Filter featured
        if ($request->boolean('unggulan')) {
            $query->featured();
        }

        // Sort
        $sort = $request->input('urut', 'terbaru');
        match($sort) {
            'harga-asc' => $query->orderBy('price'),
            'harga-desc' => $query->orderByDesc('price'),
            'populer' => $query->orderByDesc('view_count'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $productCategories = ProductCategory::active()->orderBy('sort_order')->get();
        $umkmCategories = UmkmCategory::active()->orderBy('sort_order')->get();

        return view('public.produk', compact('products', 'productCategories', 'umkmCategories', 'sort'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->whereHas('umkmProfile', fn($q) => $q->active())
            ->with(['umkmProfile.category', 'category', 'images'])
            ->firstOrFail();

        $this->analytics->trackProductView($product->umkm_profile_id, $product->id);
        $product->increment('view_count');

        // Related products
        $relatedProducts = Product::active()
            ->whereHas('umkmProfile', fn($q) => $q->active())
            ->where('umkm_profile_id', $product->umkm_profile_id)
            ->where('id', '!=', $product->id)
            ->with(['images' => fn($q) => $q->where('is_cover', true)])
            ->limit(4)
            ->get();

        return view('public.produk-detail', compact('product', 'relatedProducts'));
    }
}
