<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MapService;
use Illuminate\Http\JsonResponse;

class MapController extends Controller
{
    public function __construct(private MapService $mapService) {}

    public function geojson(): JsonResponse
    {
        $geojson = $this->mapService->getGeoJson();
        return response()->json($geojson)
            ->header('Cache-Control', 'public, max-age=300'); // 5 min cache
    }
}
