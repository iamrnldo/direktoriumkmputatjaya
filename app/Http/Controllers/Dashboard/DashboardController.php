<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use App\Services\StatisticsService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(private StatisticsService $statsService) {}

    public function index()
    {
        $user = Auth::user();
        $umkm = UmkmProfile::where('user_id', $user->id)
            ->with(['category', 'images', 'activeProducts'])
            ->first();

        $stats = [];
        if ($umkm) {
            $stats = $this->statsService->getOwnerStats($umkm->id);
        }

        return view('dashboard.index', compact('umkm', 'stats'));
    }
}
