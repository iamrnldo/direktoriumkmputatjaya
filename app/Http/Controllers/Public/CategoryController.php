<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\UmkmCategory;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(string $slug, Request $request)
    {
        $category = UmkmCategory::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $query = UmkmProfile::active()
            ->where('category_id', $category->id)
            ->with(['category', 'images' => fn($q) => $q->where('is_cover', true)])
            ->withCount('activeProducts');

        if ($search = $request->input('q')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $sort = $request->input('urut', 'terbaru');
        match($sort) {
            'az' => $query->orderBy('name'),
            'populer' => $query->orderByDesc('view_count'),
            default => $query->latest(),
        };

        $umkmList = $query->paginate(12)->withQueryString();
        $allCategories = UmkmCategory::active()->orderBy('sort_order')->get();

        return view('public.kategori', compact('category', 'umkmList', 'allCategories', 'sort'));
    }
}
