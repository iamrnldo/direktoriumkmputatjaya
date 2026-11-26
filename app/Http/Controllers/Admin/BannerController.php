<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->paginate(20);
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(BannerRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }
        unset($data['image']);
        Banner::create($data);
        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image_path);
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }
        unset($data['image']);
        $banner->update($data);
        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->image_path);
        $banner->delete();
        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil dihapus.');
    }

    public function toggleActive(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        $status = $banner->fresh()->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Banner berhasil {$status}.");
    }
}
