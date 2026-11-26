<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\UmkmProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ProductService
{
    public function create(UmkmProfile $umkm, array $data): Product
    {
        return DB::transaction(function () use ($umkm, $data) {
            $slug = $this->generateUniqueSlug($data['name'], $umkm->slug);

            $product = Product::create([
                'umkm_profile_id' => $umkm->id,
                'product_category_id' => $data['product_category_id'] ?? null,
                'name' => $data['name'],
                'slug' => $slug,
                'short_description' => $data['short_description'] ?? null,
                'description' => $data['description'] ?? null,
                'price' => $data['price'] ?? 0,
                'price_label' => $data['price_label'] ?? null,
                'availability_status' => $data['availability_status'] ?? Product::STATUS_AVAILABLE,
                'is_featured' => $data['is_featured'] ?? false,
                'is_active' => $data['is_active'] ?? true,
            ]);

            return $product;
        });
    }

    public function update(Product $product, array $data): Product
    {
        unset($data['images']);
        $product->update($data);
        return $product->fresh();
    }

    public function uploadImages(Product $product, array $files): void
    {
        $hasExisting = $product->images()->count() > 0;
        $sortOrder = $product->images()->max('sort_order') ?? 0;

        foreach ($files as $index => $file) {
            if (!$file instanceof UploadedFile) continue;

            try {
                $path = $file->store('products/' . $product->id . '/images', 'public');
            } catch (\Throwable $exception) {
                report($exception);
                throw ValidationException::withMessages(['images' => 'Foto gagal disimpan. Periksa izin tulis pada storage/app/public.']);
            }
            if (! $path) {
                throw ValidationException::withMessages(['images' => 'Foto gagal disimpan ke penyimpanan publik.']);
            }
            $sortOrder++;

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'alt_text' => $product->name,
                'sort_order' => $sortOrder,
                'is_cover' => (!$hasExisting && $index === 0),
            ]);
        }
    }

    public function deleteImage(ProductImage $image): void
    {
        $wasCover = $image->is_cover;
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        if ($wasCover) {
            $first = $image->product->images()->first();
            $first?->update(['is_cover' => true]);
        }
    }

    public function toggleFeatured(Product $product): void
    {
        $product->update(['is_featured' => !$product->is_featured]);
    }

    public function softDelete(Product $product): void
    {
        Storage::disk('public')->delete($product->images->pluck('image_path')->toArray());
        $product->images()->delete();
        $product->delete();
    }

    private function generateUniqueSlug(string $name, string $umkmSlug): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $i = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++ . '-' . $umkmSlug;
        }
        return $slug;
    }
}
