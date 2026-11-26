<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Product;
use App\Models\UmkmProfile;
use App\Services\StatisticsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function __construct(private StatisticsService $statsService) {}

    public function index()
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())
            ->with(['activeProducts'])
            ->first();

        if (!$umkm) {
            return redirect()->route('dashboard.profil-usaha')
                ->with('error', 'Silakan lengkapi profil usaha Anda terlebih dahulu.');
        }

        $stats = $this->statsService->getOwnerStats($umkm->id);

        // Views trend last 30 days
        $viewsTrend = AnalyticsEvent::where('umkm_profile_id', $umkm->id)
            ->where('event_type', 'profile_view')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill in missing dates
        $dates = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates[$date] = $viewsTrend[$date] ?? 0;
        }

        // Top products by view
        $topProducts = Product::where('umkm_profile_id', $umkm->id)
            ->orderByDesc('view_count')
            ->limit(5)
            ->get();

        return view('dashboard.statistik', compact('umkm', 'stats', 'dates', 'topProducts'));
    }
}
