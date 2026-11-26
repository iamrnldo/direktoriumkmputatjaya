<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UmkmCategory;
use App\Models\UmkmProfile;
use App\Models\User;
use App\Services\StatisticsService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(private StatisticsService $statsService) {}

    public function index()
    {
        // Stats summary for cards
        $stats = [
            'total_umkm'         => UmkmProfile::count(),
            'umkm_aktif'         => UmkmProfile::where('verification_status', 'aktif')->count(),
            'pending_verifikasi' => UmkmProfile::whereIn('verification_status', ['diajukan'])->count(),
            'total_produk'       => Product::count(),
            'produk_aktif'       => Product::where('is_active', true)->count(),
            'total_pengguna'     => User::count(),
        ];

        // Pending verifications for dashboard list
        $pendingVerifications = UmkmProfile::with(['category', 'user'])
            ->where('verification_status', 'diajukan')
            ->latest()
            ->limit(5)
            ->get();

        // Recently registered UMKM
        $recentUmkm = UmkmProfile::with('category')
            ->latest()
            ->limit(7)
            ->get();

        // UMKM count per category (for doughnut chart)
        $categoryStats = UmkmCategory::withCount([
                'umkmProfiles' => fn($q) => $q->where('verification_status', 'aktif'),
            ])
            ->having('umkm_profiles_count', '>', 0)
            ->orderByDesc('umkm_profiles_count')
            ->get();

        // Registration trend last 30 days (for bar chart)
        $registrationTrend = UmkmProfile::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(29))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill missing dates with 0
        $trend = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $trend[$date] = $registrationTrend[$date] ?? 0;
        }
        $registrationTrend = $trend;

        return view('admin.dashboard', compact(
            'stats',
            'pendingVerifications',
            'recentUmkm',
            'categoryStats',
            'registrationTrend'
        ));
    }
}
