<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UmkmCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = UmkmCategory::withCount(['umkmProfiles' => fn($q) => $q->active()])
            ->orderBy('sort_order')
            ->paginate(20);
        return view('admin.kategori-umkm.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.kategori-umkm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon' => ['nullable', 'string', 'max:50'],
            'color_code' => ['nullable', 'string', 'max:20'],
            'marker_color' => ['nullable', 'string', 'max:20'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slug = Str::slug($request->name);
        $base = $slug; $i = 1;
        while (UmkmCategory::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        UmkmCategory::create(array_merge($request->validated(), ['slug' => $slug, 'is_active' => true]));

        return redirect()->route('admin.kategori-umkm.index')
            ->with('success', 'Kategori UMKM berhasil ditambahkan.');
    }

    public function edit(UmkmCategory $kategoriUmkm)
    {
        return view('admin.kategori-umkm.edit', ['category' => $kategoriUmkm]);
    }

    public function update(Request $request, UmkmCategory $kategoriUmkm)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon' => ['nullable', 'string', 'max:50'],
            'color_code' => ['nullable', 'string', 'max:20'],
            'marker_color' => ['nullable', 'string', 'max:20'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $kategoriUmkm->update($request->validated());

        return redirect()->route('admin.kategori-umkm.index')
            ->with('success', 'Kategori UMKM berhasil diperbarui.');
    }

    public function destroy(UmkmCategory $kategoriUmkm)
    {
        if ($kategoriUmkm->umkmProfiles()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh UMKM.');
        }
        $kategoriUmkm->delete();
        return redirect()->route('admin.kategori-umkm.index')
            ->with('success', 'Kategori UMKM berhasil dihapus.');
    }
}
