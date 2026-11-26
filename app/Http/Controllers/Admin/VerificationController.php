<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use App\Models\UmkmVerification;
use App\Services\UmkmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function __construct(private UmkmService $umkmService) {}

    public function index(Request $request)
    {
        $query = UmkmProfile::with(['category', 'user', 'latestVerification'])
            ->whereIn('verification_status', ['diajukan', 'perlu_revisi']);

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('verification_status', $status);
        }

        $pendingList = $query->latest()->paginate(20)->withQueryString();

        return view('admin.verifikasi-umkm.index', compact('pendingList'));
    }

    public function show(UmkmProfile $umkm)
    {
        $umkm->load(['category', 'user', 'images', 'businessHours', 'activeProducts.images', 'verifications.admin']);
        return view('admin.verifikasi-umkm.show', compact('umkm'));
    }

    public function approve(Request $request, UmkmProfile $umkm)
    {
        $request->validate(['notes' => 'nullable|string|max:1000']);

        $this->umkmService->approve($umkm, $request->notes);

        if ($request->boolean('is_featured')) {
            $umkm->update(['is_featured' => true]);
        }

        return redirect()->route('admin.verifikasi-umkm.index')
            ->with('success', "UMKM '{$umkm->name}' berhasil disetujui dan diaktifkan.");
    }

    public function reject(Request $request, UmkmProfile $umkm)
    {
        $request->validate(['notes' => 'required|string|max:1000']);

        $this->umkmService->reject($umkm, $request->notes);

        return redirect()->route('admin.verifikasi-umkm.index')
            ->with('success', "Pengajuan UMKM '{$umkm->name}' berhasil ditolak.");
    }

    public function requestRevision(Request $request, UmkmProfile $umkm)
    {
        $request->validate(['notes' => 'required|string|max:1000']);

        $this->umkmService->requestRevision($umkm, $request->notes);

        return redirect()->route('admin.verifikasi-umkm.index')
            ->with('success', "Permintaan revisi untuk UMKM '{$umkm->name}' berhasil dikirim.");
    }

    public function process(Request $request, UmkmProfile $umkm)
    {
        $action = $request->input('action');
        $notes  = $request->input('notes');

        match($action) {
            'approve'  => $this->umkmService->approve($umkm, $notes),
            'reject'   => $this->umkmService->reject($umkm, $notes),
            'revision' => $this->umkmService->requestRevision($umkm, $notes),
            default    => abort(422, 'Aksi tidak valid'),
        };

        $label = match($action) {
            'approve'  => 'disetujui',
            'reject'   => 'ditolak',
            'revision' => 'diminta revisi',
            default    => 'diproses',
        };

        return redirect()->route('admin.verifikasi-umkm.index')
            ->with('success', "UMKM '{$umkm->name}' berhasil {$label}.");
    }
}
