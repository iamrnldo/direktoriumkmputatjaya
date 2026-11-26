<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmCategory;
use App\Services\MapService;
use App\Services\StatisticsService;

class MapController extends Controller
{
    public function __construct(private MapService $mapService, private StatisticsService $stats) {}

    public function index()
    {
        $center = $this->mapService->getDefaultCenter();
        $categories = UmkmCategory::active()->orderBy('sort_order')->get();
        $stats = $this->stats->getAdminDashboardStats();

        return view('admin.peta-umkm', compact('center', 'categories', 'stats'));
    }
}
