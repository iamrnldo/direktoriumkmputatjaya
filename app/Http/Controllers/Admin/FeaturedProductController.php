<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;

class FeaturedProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index()
    {
        $featuredProducts = Product::active()->featured()
            ->whereHas('umkmProfile', fn($q) => $q->active())
            ->with('umkmProfile')
            ->paginate(12);

        $availableProducts = Product::active()
            ->where('is_featured', false)
            ->whereHas('umkmProfile', fn($q) => $q->active())
            ->with('umkmProfile')
            ->orderBy('name')
            ->limit(50)
            ->get();

        return view('admin.produk-unggulan', compact('featuredProducts', 'availableProducts'));
    }

    public function toggle(Product $product)
    {
        $this->productService->toggleFeatured($product);
        $status = $product->fresh()->is_featured ? 'ditandai sebagai unggulan' : 'dihapus dari daftar unggulan';
        return back()->with('success', "Produk berhasil {$status}.");
    }
}
