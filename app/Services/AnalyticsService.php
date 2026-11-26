<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use Illuminate\Support\Facades\Auth;

class AnalyticsService
{
    public function track(
        string $eventType,
        ?int $umkmProfileId = null,
        ?int $productId = null,
        array $metadata = []
    ): void {
        try {
            AnalyticsEvent::create([
                'umkm_profile_id' => $umkmProfileId,
                'product_id' => $productId,
                'event_type' => $eventType,
                'session_hash' => $this->getSessionHash(),
                'user_id' => Auth::id(),
                'metadata' => !empty($metadata) ? $metadata : null,
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Fail silently — analytics should never break the app
            logger()->error('Analytics tracking failed: ' . $e->getMessage());
        }
    }

    public function trackProfileView(int $umkmProfileId): void
    {
        $this->track('profile_view', $umkmProfileId);
    }

    public function trackProductView(int $umkmProfileId, int $productId): void
    {
        $this->track('product_view', $umkmProfileId, $productId);
    }

    public function trackWhatsappClick(int $umkmProfileId): void
    {
        $this->track('whatsapp_click', $umkmProfileId);
    }

    public function trackMapClick(int $umkmProfileId): void
    {
        $this->track('map_click', $umkmProfileId);
    }

    public function trackSearch(string $query, ?string $category = null): void
    {
        $this->track('search_query', null, null, [
            'query' => $query,
            'category' => $category,
        ]);
    }

    private function getSessionHash(): string
    {
        return md5(session()->getId() . request()->ip());
    }
}
