<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StaticPageController extends Controller
{
    public function index()
    {
        $pages = StaticPage::orderBy('title')->paginate(15);
        return view('admin.halaman-statis.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.halaman-statis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);
        $slug = Str::slug($request->title);
        StaticPage::create(array_merge($request->validated(), ['slug' => $slug, 'is_active' => true, 'updated_by' => Auth::id()]));
        return redirect()->route('admin.halaman-statis.index')->with('success', 'Halaman berhasil ditambahkan.');
    }

    public function edit(StaticPage $halamanStatis)
    {
        return view('admin.halaman-statis.edit', ['page' => $halamanStatis]);
    }

    public function update(Request $request, StaticPage $halamanStatis)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $halamanStatis->update(array_merge($request->validated(), ['updated_by' => Auth::id()]));
        return redirect()->route('admin.halaman-statis.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(StaticPage $halamanStatis)
    {
        $halamanStatis->delete();
        return redirect()->route('admin.halaman-statis.index')->with('success', 'Halaman berhasil dihapus.');
    }
}
