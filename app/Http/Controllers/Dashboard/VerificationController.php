<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use App\Services\UmkmService;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function __construct(private UmkmService $umkmService) {}

    public function index()
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())
            ->with('verifications.admin')
            ->first();

        return view('dashboard.status-verifikasi', compact('umkm'));
    }

    public function submit()
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())->firstOrFail();

        if (!in_array($umkm->verification_status, [
            UmkmProfile::STATUS_DRAFT,
            UmkmProfile::STATUS_PERLU_REVISI,
            UmkmProfile::STATUS_DITOLAK,
        ])) {
            return back()->with('error', 'Status usaha Anda saat ini tidak dapat diajukan untuk verifikasi.');
        }

        if (!$umkm->name || !$umkm->whatsapp_number || !$umkm->address) {
            return back()->with('error', 'Harap lengkapi data usaha terlebih dahulu sebelum mengajukan verifikasi.');
        }

        $this->umkmService->submitForVerification($umkm);

        return back()->with('success', 'Pengajuan verifikasi berhasil dikirim. Admin akan meninjau data Anda.');
    }
}
