<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Models\UmkmProfile;

class MapService
{
    public function getGeoJson(): array
    {
        $umkmList = UmkmProfile::active()
            ->withValidCoordinates()
            ->with(['category', 'images' => fn($q) => $q->where('is_cover', true)])
            ->get();

        $features = $umkmList->map(function (UmkmProfile $umkm) {
            return [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [(float) $umkm->longitude, (float) $umkm->latitude],
                ],
                'properties' => [
                    'id' => $umkm->id,
                    'name' => $umkm->name,
                    'slug' => $umkm->slug,
                    'category' => $umkm->category?->name,
                    'category_slug' => $umkm->category?->slug,
                    'marker_color' => $umkm->category?->marker_color ?? 'blue',
                    'address' => $umkm->address,
                    'whatsapp_link' => $umkm->whatsapp_link,
                    'cover_image' => $umkm->cover_image_url,
                    'profile_url' => route('umkm.show', $umkm->slug),
                    'is_featured' => $umkm->is_featured,
                    'is_open' => $umkm->isOpenNow(),
                ],
            ];
        });

        return [
            'type' => 'FeatureCollection',
            'features' => $features->toArray(),
        ];
    }

    public function getDefaultCenter(): array
    {
        return [
            'lat' => (float) SiteSetting::get('map_default_lat', -7.2804),
            'lng' => (float) SiteSetting::get('map_default_lng', 112.7079),
            'zoom' => (int) SiteSetting::get('map_default_zoom', 15),
        ];
    }

    /**
     * Google Maps abstraction — swap this implementation to switch from Leaflet/OSM to Google Maps
     */
    public function getGoogleMapsLink(float $lat, float $lng): string
    {
        return "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";
    }

    public function getGoogleMapsDirectionLink(float $lat, float $lng): string
    {
        return "https://www.google.com/maps/dir/?api=1&destination={$lat},{$lng}";
    }
}
