<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')->orderBy('sort_order')->paginate(20);
        return view('admin.kategori-produk.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.kategori-produk.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'max:100'], 'description' => ['nullable', 'string', 'max:500']]);
        $slug = Str::slug($request->name);
        $base = $slug; $i = 1;
        while (ProductCategory::where('slug', $slug)->exists()) { $slug = $base . '-' . $i++; }
        ProductCategory::create(['name' => $request->name, 'slug' => $slug, 'description' => $request->description, 'is_active' => true]);
        return redirect()->route('admin.kategori-produk.index')->with('success', 'Kategori produk berhasil ditambahkan.');
    }

    public function edit(ProductCategory $kategoriProduk)
    {
        return view('admin.kategori-produk.edit', ['category' => $kategoriProduk]);
    }

    public function update(Request $request, ProductCategory $kategoriProduk)
    {
        $request->validate(['name' => ['required', 'string', 'max:100'], 'is_active' => ['nullable', 'boolean']]);
        $kategoriProduk->update($request->validated());
        return redirect()->route('admin.kategori-produk.index')->with('success', 'Kategori produk berhasil diperbarui.');
    }

    public function destroy(ProductCategory $kategoriProduk)
    {
        if ($kategoriProduk->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
        }
        $kategoriProduk->delete();
        return redirect()->route('admin.kategori-produk.index')->with('success', 'Kategori produk berhasil dihapus.');
    }
}
