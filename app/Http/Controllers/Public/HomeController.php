<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Event;
use App\Models\Product;
use App\Models\Review;
use App\Models\UmkmCategory;
use App\Models\UmkmProfile;
use App\Services\StatisticsService;

class HomeController extends Controller
{
    public function __construct(private StatisticsService $statsService) {}

    public function index()
    {
        $stats = $this->statsService->getPublicStats();

        $categories = UmkmCategory::active()
            ->withCount(['umkmProfiles' => fn($q) => $q->active()])
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $featuredUmkm = UmkmProfile::active()
            ->featured()
            ->with(['category', 'images' => fn($q) => $q->where('is_cover', true)])
            ->withCount('activeProducts')
            ->orderByDesc('view_count')
            ->limit(6)
            ->get();

        $featuredProducts = Product::active()
            ->featured()
            ->whereHas('umkmProfile', fn($q) => $q->active())
            ->with(['umkmProfile', 'images' => fn($q) => $q->where('is_cover', true)])
            ->orderByDesc('view_count')
            ->limit(8)
            ->get();

        $activeBanners = Banner::active()
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        $upcomingEvents = Event::active()
            ->upcoming()
            ->limit(3)
            ->get();

        $latestReviews = Review::approved()
            ->with(['user', 'umkmProfile'])
            ->latest()
            ->limit(4)
            ->get();

        $newestUmkm = UmkmProfile::active()
            ->with(['category', 'images' => fn($q) => $q->where('is_cover', true)])
            ->withCount('activeProducts')
            ->latest()
            ->limit(4)
            ->get();

        return view('public.home', compact(
            'stats',
            'categories',
            'featuredUmkm',
            'featuredProducts',
            'activeBanners',
            'upcomingEvents',
            'latestReviews',
            'newestUmkm'
        ));
    }

    public function registerUmkm()
    {
        return view('public.daftar-umkm');
    }
}
