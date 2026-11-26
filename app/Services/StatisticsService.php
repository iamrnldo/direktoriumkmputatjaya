<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use App\Models\Product;
use App\Models\UmkmProfile;
use Illuminate\Support\Facades\DB;

class StatisticsService
{
    public function getPublicStats(): array
    {
        return [
            'total_umkm_aktif' => UmkmProfile::active()->count(),
            'total_kategori' => \App\Models\UmkmCategory::active()->count(),
            'total_produk' => Product::where('is_active', true)->whereHas('umkmProfile', fn($q) => $q->active())->count(),
            'total_umkm_unggulan' => UmkmProfile::active()->featured()->count(),
        ];
    }

    public function getAdminDashboardStats(): array
    {
        $statusCounts = UmkmProfile::withTrashed()
            ->select('verification_status', DB::raw('count(*) as total'))
            ->whereNull('deleted_at')
            ->groupBy('verification_status')
            ->pluck('total', 'verification_status')
            ->toArray();

        return [
            'total_umkm' => UmkmProfile::count(),
            'umkm_aktif' => $statusCounts['aktif'] ?? 0,
            'umkm_menunggu' => $statusCounts['diajukan'] ?? 0,
            'umkm_perlu_revisi' => $statusCounts['perlu_revisi'] ?? 0,
            'umkm_ditolak' => $statusCounts['ditolak'] ?? 0,
            'umkm_draft' => $statusCounts['draft'] ?? 0,
            'umkm_featured' => UmkmProfile::where('is_featured', true)->count(),
            'total_produk' => Product::count(),
            'produk_tersedia' => Product::where('availability_status', 'available')->count(),
            'produk_featured' => Product::where('is_featured', true)->count(),
        ];
    }

    public function getUmkmGrowthByMonth(int $months = 12): array
    {
        $data = UmkmProfile::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subMonths($months))
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        $result = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->year . '-' . $date->month;
            $label = $date->translatedFormat('M Y');
            $found = $data->first(fn($d) => $d->year == $date->year && $d->month == $date->month);
            $result[] = ['label' => $label, 'count' => $found ? $found->count : 0];
        }

        return $result;
    }

    public function getUmkmByCategory(): array
    {
        return UmkmProfile::active()
            ->select('category_id', DB::raw('count(*) as total'))
            ->with('category')
            ->groupBy('category_id')
            ->get()
            ->map(fn($item) => [
                'label' => $item->category?->name ?? 'Tanpa Kategori',
                'count' => $item->total,
                'color' => $item->category?->color_code ?? '#6B7280',
            ])
            ->toArray();
    }

    public function getMostViewedUmkm(int $limit = 10): array
    {
        return UmkmProfile::active()
            ->orderByDesc('view_count')
            ->limit($limit)
            ->with('category')
            ->get()
            ->toArray();
    }

    public function getOwnerStats(int $umkmProfileId): array
    {
        $base = AnalyticsEvent::where('umkm_profile_id', $umkmProfileId);

        return [
            'profile_views' => (clone $base)->where('event_type', 'profile_view')->count(),
            'whatsapp_clicks' => (clone $base)->where('event_type', 'whatsapp_click')->count(),
            'map_clicks' => (clone $base)->where('event_type', 'map_click')->count(),
            'product_views' => (clone $base)->where('event_type', 'product_view')->count(),
            'views_last_30_days' => (clone $base)
                ->where('event_type', 'profile_view')
                ->where('created_at', '>=', now()->subDays(30))
                ->count(),
        ];
    }
}
