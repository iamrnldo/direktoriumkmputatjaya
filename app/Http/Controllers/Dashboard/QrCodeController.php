<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function index()
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())->first();

        if (!$umkm) {
            return redirect()->route('dashboard.profil-usaha')
                ->with('error', 'Silakan lengkapi profil usaha Anda terlebih dahulu sebelum mengakses QR Code.');
        }

        $profileUrl = route('umkm.show', $umkm->slug);

        // Always use SVG — works on all servers including Windows (no Imagick needed)
        $qrCode = QrCode::format('svg')
            ->size(250)
            ->margin(1)
            ->errorCorrection('H')
            ->color(15, 23, 42)      // slate-900
            ->backgroundColor(255, 255, 255)
            ->generate($profileUrl);

        return view('dashboard.qr-code', compact('umkm', 'qrCode', 'profileUrl'));
    }

    public function download()
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())->first();

        if (!$umkm) {
            return redirect()->route('dashboard.profil-usaha')
                ->with('error', 'Profil usaha tidak ditemukan.');
        }

        $profileUrl = route('umkm.show', $umkm->slug);

        // Try PNG first, fallback to SVG if Imagick not available
        try {
            $qrCode = QrCode::format('png')
                ->size(600)
                ->margin(2)
                ->errorCorrection('H')
                ->color(15, 23, 42)
                ->backgroundColor(255, 255, 255)
                ->generate($profileUrl);

            return response($qrCode, 200, [
                'Content-Type'        => 'image/png',
                'Content-Disposition' => 'attachment; filename="qr-code-' . $umkm->slug . '.png"',
                'Cache-Control'       => 'no-store',
            ]);
        } catch (\Exception $e) {
            // PNG failed (Imagick not installed) — fallback to SVG
            return $this->downloadSvg();
        }
    }

    public function downloadSvg()
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())->first();

        if (!$umkm) {
            return redirect()->route('dashboard.profil-usaha')
                ->with('error', 'Profil usaha tidak ditemukan.');
        }

        $profileUrl = route('umkm.show', $umkm->slug);

        $qrCode = QrCode::format('svg')
            ->size(600)
            ->margin(2)
            ->errorCorrection('H')
            ->color(15, 23, 42)
            ->backgroundColor(255, 255, 255)
            ->generate($profileUrl);

        return response($qrCode, 200, [
            'Content-Type'        => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="qr-code-' . $umkm->slug . '.svg"',
            'Cache-Control'       => 'no-store',
        ]);
    }
}
