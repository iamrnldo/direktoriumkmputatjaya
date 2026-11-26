<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UmkmProfileRequest;
use App\Models\BusinessHour;
use App\Models\UmkmCategory;
use App\Models\UmkmProfile;
use App\Services\UmkmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmController extends Controller
{
    public function __construct(private UmkmService $umkmService) {}

    public function index(Request $request)
    {
        $query = UmkmProfile::with(['category', 'user'])
            ->withCount('products');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('verification_status', $status);
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        $sort = $request->input('urut', 'terbaru');
        match($sort) {
            'az' => $query->orderBy('name'),
            'views' => $query->orderByDesc('view_count'),
            default => $query->latest(),
        };

        $umkmList = $query->paginate(20)->withQueryString();
        $categories = UmkmCategory::active()->orderBy('name')->get();

        return view('admin.umkm.index', compact('umkmList', 'categories'));
    }

    public function create()
    {
        $categories = UmkmCategory::active()->orderBy('sort_order')->get();
        return view('admin.umkm.create', compact('categories'));
    }

    public function store(UmkmProfileRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['verification_status'] = $request->input('verification_status', 'draft');
        $data['is_active'] = $data['verification_status'] === 'aktif';

        $umkm = $this->umkmService->create($data);

        return redirect()->route('admin.umkm.show', $umkm)
            ->with('success', 'Data UMKM berhasil ditambahkan.');
    }

    public function show(UmkmProfile $umkm)
    {
        $umkm->load(['category', 'user', 'images', 'businessHours', 'products', 'verifications.admin']);
        return view('admin.umkm.show', compact('umkm'));
    }

    public function edit(UmkmProfile $umkm)
    {
        $categories = UmkmCategory::active()->orderBy('sort_order')->get();
        $umkm->load('category', 'images');
        return view('admin.umkm.edit', compact('umkm', 'categories'));
    }

    public function update(UmkmProfileRequest $request, UmkmProfile $umkm)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::id();

        $this->umkmService->update($umkm, $data);

        return redirect()->route('admin.umkm.show', $umkm)
            ->with('success', 'Data UMKM berhasil diperbarui.');
    }

    public function destroy(UmkmProfile $umkm)
    {
        $this->umkmService->softDelete($umkm);
        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil dihapus.');
    }

    public function restore(int $id)
    {
        $umkm = UmkmProfile::withTrashed()->findOrFail($id);
        $umkm->restore();
        return back()->with('success', 'UMKM berhasil dipulihkan.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => ['required', 'in:activate,deactivate,delete,feature,unfeature'],
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:umkm_profiles,id'],
        ]);

        $umkmList = UmkmProfile::whereIn('id', $request->ids)->get();

        foreach ($umkmList as $umkm) {
            match($request->action) {
                'activate' => $umkm->update(['is_active' => true, 'verification_status' => 'aktif']),
                'deactivate' => $umkm->update(['is_active' => false, 'verification_status' => 'nonaktif']),
                'delete' => $umkm->delete(),
                'feature' => $umkm->update(['is_featured' => true]),
                'unfeature' => $umkm->update(['is_featured' => false]),
            };
        }

        return back()->with('success', count($umkmList) . ' UMKM berhasil diproses.');
    }
}
