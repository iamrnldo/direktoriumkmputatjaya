<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\UmkmCategory;
use App\Services\MapService;

class MapController extends Controller
{
    public function __construct(private MapService $mapService) {}

    public function index()
    {
        $center = $this->mapService->getDefaultCenter();
        $categories = UmkmCategory::active()->orderBy('sort_order')->get();

        return view('public.peta-umkm', compact('center', 'categories'));
    }
}
