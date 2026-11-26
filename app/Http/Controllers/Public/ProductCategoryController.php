<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function show(string $slug, Request $request)
    {
        $category = ProductCategory::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $products = Product::active()
            ->where('product_category_id', $category->id)
            ->whereHas('umkmProfile', fn($q) => $q->active())
            ->with(['umkmProfile', 'images' => fn($q) => $q->where('is_cover', true)])
            ->paginate(12)->withQueryString();

        return view('public.kategori-produk', compact('category', 'products'));
    }
}
