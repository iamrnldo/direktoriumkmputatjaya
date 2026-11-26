<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;

class StatisticsController extends Controller
{
    public function __construct(private StatisticsService $statsService) {}

    public function index()
    {
        $stats = $this->statsService->getAdminDashboardStats();
        $growthData = $this->statsService->getUmkmGrowthByMonth(12);
        $categoryData = $this->statsService->getUmkmByCategory();
        $mostViewed = $this->statsService->getMostViewedUmkm(10);

        return view('admin.statistik', compact('stats', 'growthData', 'categoryData', 'mostViewed'));
    }
}
