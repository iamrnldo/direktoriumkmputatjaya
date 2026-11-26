<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'Direktori UMKM Putat Jaya', 'type' => 'string', 'group' => 'general', 'label' => 'Nama Website'],
            ['key' => 'site_tagline', 'value' => 'Temukan, Dukung, dan Banggakan UMKM Lokal Putat Jaya', 'type' => 'string', 'group' => 'general', 'label' => 'Tagline'],
            ['key' => 'kelurahan_name', 'value' => 'Kelurahan Putat Jaya', 'type' => 'string', 'group' => 'general', 'label' => 'Nama Kelurahan'],
            ['key' => 'kecamatan_name', 'value' => 'Kecamatan Sawahan', 'type' => 'string', 'group' => 'general', 'label' => 'Nama Kecamatan'],
            ['key' => 'city_name', 'value' => 'Kota Surabaya', 'type' => 'string', 'group' => 'general', 'label' => 'Nama Kota'],
            // Contact
            ['key' => 'contact_address', 'value' => 'Jl. Putat Jaya No. 1, Kecamatan Sawahan, Kota Surabaya, Jawa Timur 60252', 'type' => 'string', 'group' => 'contact', 'label' => 'Alamat'],
            ['key' => 'contact_phone', 'value' => '031-5678901', 'type' => 'string', 'group' => 'contact', 'label' => 'Telepon'],
            ['key' => 'contact_email', 'value' => 'kelurahan.putatjaya@surabaya.go.id', 'type' => 'string', 'group' => 'contact', 'label' => 'Email'],
            ['key' => 'contact_hours', 'value' => 'Senin - Jumat: 08.00 - 16.00 WIB', 'type' => 'string', 'group' => 'contact', 'label' => 'Jam Pelayanan'],
            // Social Media
            ['key' => 'social_instagram', 'value' => '', 'type' => 'string', 'group' => 'social', 'label' => 'Instagram'],
            ['key' => 'social_facebook', 'value' => '', 'type' => 'string', 'group' => 'social', 'label' => 'Facebook'],
            ['key' => 'social_youtube', 'value' => '', 'type' => 'string', 'group' => 'social', 'label' => 'YouTube'],
            // Map defaults (Putat Jaya, Surabaya coordinates)
            ['key' => 'map_default_lat', 'value' => '-7.2804', 'type' => 'string', 'group' => 'map', 'label' => 'Latitude Default Peta'],
            ['key' => 'map_default_lng', 'value' => '112.7079', 'type' => 'string', 'group' => 'map', 'label' => 'Longitude Default Peta'],
            ['key' => 'map_default_zoom', 'value' => '15', 'type' => 'integer', 'group' => 'map', 'label' => 'Zoom Default Peta'],
            // Feature flags
            ['key' => 'feature_reviews', 'value' => '1', 'type' => 'boolean', 'group' => 'feature_flags', 'label' => 'Aktifkan Ulasan & Rating'],
            ['key' => 'feature_favorites', 'value' => '1', 'type' => 'boolean', 'group' => 'feature_flags', 'label' => 'Aktifkan Favorit'],
            ['key' => 'feature_qr_code', 'value' => '1', 'type' => 'boolean', 'group' => 'feature_flags', 'label' => 'Aktifkan QR Code'],
            ['key' => 'max_featured_umkm', 'value' => '6', 'type' => 'integer', 'group' => 'general', 'label' => 'Maksimal UMKM Unggulan'],
            ['key' => 'max_featured_products', 'value' => '12', 'type' => 'integer', 'group' => 'general', 'label' => 'Maksimal Produk Unggulan'],
            ['key' => 'max_upload_size_mb', 'value' => '2', 'type' => 'integer', 'group' => 'general', 'label' => 'Maksimal Ukuran Upload (MB)'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
