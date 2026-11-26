<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\UmkmProfile;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    private function getOwnerUmkm(): UmkmProfile
    {
        return UmkmProfile::where('user_id', Auth::id())->firstOrFail();
    }

    public function index()
    {
        $umkm = $this->getOwnerUmkm();
        $products = Product::where('umkm_profile_id', $umkm->id)
            ->with(['category', 'images' => fn($q) => $q->where('is_cover', true)])
            ->latest()
            ->paginate(15);

        return view('dashboard.produk.index', compact('umkm', 'products'));
    }

    public function create()
    {
        $umkm = $this->getOwnerUmkm();
        $categories = ProductCategory::active()->orderBy('sort_order')->get();
        return view('dashboard.produk.create', compact('umkm', 'categories'));
    }

    public function store(ProductRequest $request)
    {
        $umkm = $this->getOwnerUmkm();
        $product = $this->productService->create($umkm, $request->validated());

        if ($request->hasFile('images')) {
            $this->productService->uploadImages($product, $request->file('images'));
        }

        return redirect()->route('dashboard.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $umkm = $this->getOwnerUmkm();
        abort_unless($product->umkm_profile_id === $umkm->id, 403, 'Akses ditolak.');

        $categories = ProductCategory::active()->orderBy('sort_order')->get();
        return view('dashboard.produk.edit', compact('product', 'umkm', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $umkm = $this->getOwnerUmkm();
        abort_unless($product->umkm_profile_id === $umkm->id, 403, 'Akses ditolak.');

        $this->productService->update($product, $request->validated());

        return redirect()->route('dashboard.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $umkm = $this->getOwnerUmkm();
        abort_unless($product->umkm_profile_id === $umkm->id, 403, 'Akses ditolak.');

        $this->productService->softDelete($product);

        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function uploadImages(Product $product, ImageUploadRequest $request)
    {
        $umkm = $this->getOwnerUmkm();
        abort_unless($product->umkm_profile_id === $umkm->id, 403);

        $this->productService->uploadImages($product, $request->file('images'));

        return back()->with('success', 'Foto produk berhasil diunggah.');
    }

    public function deleteImage(Product $product, ProductImage $image)
    {
        $umkm = $this->getOwnerUmkm();
        abort_unless($product->umkm_profile_id === $umkm->id && $image->product_id === $product->id, 403);

        $this->productService->deleteImage($image);

        return back()->with('success', 'Foto produk berhasil dihapus.');
    }

    public function export(): StreamedResponse
    {
        $umkm = $this->getOwnerUmkm();
        $products = Product::where('umkm_profile_id', $umkm->id)
            ->with('category')
            ->orderBy('name')
            ->get();

        $filename = 'produk-' . $umkm->slug . '-' . date('Y-m-d') . '.csv';

        return new StreamedResponse(function () use ($products) {
            $handle = fopen('php://output', 'w');
            // BOM for Excel UTF-8 compatibility
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Nama Produk', 'Kategori', 'Harga', 'Status', 'Deskripsi']);

            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->name,
                    $product->category?->name ?? '-',
                    $product->price > 0 ? $product->price : ($product->price_label ?? '-'),
                    $product->is_active ? 'Aktif' : 'Nonaktif',
                    strip_tags($product->description ?? ''),
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
