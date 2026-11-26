<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct(private AnalyticsService $analytics) {}

    public function track(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'event_type' => ['required', 'string', 'in:profile_view,product_view,whatsapp_click,map_click,banner_click'],
            'umkm_profile_id' => ['nullable', 'integer', 'exists:umkm_profiles,id'],
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
        ]);

        $this->analytics->track(
            $validated['event_type'],
            $validated['umkm_profile_id'] ?? null,
            $validated['product_id'] ?? null
        );

        return response()->json(['success' => true]);
    }
}
