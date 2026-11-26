<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\UmkmProfile;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index(Request $request)
    {
        $query = Product::with(['umkmProfile', 'category'])
            ->withCount('images');

        if ($search = $request->input('q')) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($status = $request->input('status')) {
            $query->where('availability_status', $status);
        }
        if ($catId = $request->input('category_id')) {
            $query->where('product_category_id', $catId);
        }

        $products = $query->latest()->paginate(20)->withQueryString();
        $categories = ProductCategory::active()->get();

        return view('admin.produk.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::active()->orderBy('sort_order')->get();
        $umkmList = UmkmProfile::active()->orderBy('name')->get();
        return view('admin.produk.create', compact('categories', 'umkmList'));
    }

    public function store(ProductRequest $request)
    {
        $umkm = UmkmProfile::findOrFail($request->umkm_profile_id);
        $product = $this->productService->create($umkm, $request->validated());
        if ($request->hasFile('images')) {
            $this->productService->uploadImages($product, $request->file('images'));
        }
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $produk)
    {
        $produk->load(['umkmProfile', 'category', 'images']);
        return view('admin.produk.show', ['product' => $produk]);
    }

    public function edit(Product $produk)
    {
        $categories = ProductCategory::active()->orderBy('sort_order')->get();
        return view('admin.produk.edit', ['product' => $produk, 'categories' => $categories]);
    }

    public function update(ProductRequest $request, Product $produk)
    {
        $this->productService->update($produk, $request->validated());
        if ($request->hasFile('images')) {
            $this->productService->uploadImages($produk, $request->file('images'));
        }
        return redirect()->route('admin.produk.index')->with('success', 'Produk dan foto berhasil diperbarui.');
    }

    public function destroy(Product $produk)
    {
        $this->productService->softDelete($produk);
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleFeatured(Product $product)
    {
        $this->productService->toggleFeatured($product);
        $status = $product->fresh()->is_featured ? 'ditandai sebagai unggulan' : 'dihapus dari unggulan';
        return back()->with('success', "Produk berhasil {$status}.");
    }
}
