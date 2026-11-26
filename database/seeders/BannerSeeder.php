<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->first();

        $banners = [
            [
                'title' => 'Selamat Datang di Direktori UMKM Putat Jaya',
                'slug' => 'selamat-datang',
                'description' => 'Temukan ratusan UMKM lokal terbaik di Kelurahan Putat Jaya. Dukung produk dan jasa lokal!',
                'image_path' => 'banners/banner-1.jpg',
                'cta_label' => 'Jelajahi UMKM',
                'cta_url' => '/direktori-umkm',
                'sort_order' => 1,
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'title' => 'Daftarkan UMKM Anda Sekarang',
                'slug' => 'daftarkan-umkm',
                'description' => 'Punya usaha di Putat Jaya? Daftarkan sekarang dan jangkau lebih banyak pelanggan!',
                'image_path' => 'banners/banner-2.jpg',
                'cta_label' => 'Daftar Sekarang',
                'cta_url' => '/daftar-umkm',
                'sort_order' => 2,
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'title' => 'Belanja Produk Lokal Putat Jaya',
                'slug' => 'belanja-produk-lokal',
                'description' => 'Temukan produk-produk unggulan dari UMKM Putat Jaya. Belanja lokal, bangga lokal!',
                'image_path' => 'banners/banner-3.jpg',
                'cta_label' => 'Lihat Produk',
                'cta_url' => '/produk',
                'sort_order' => 3,
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::firstOrCreate(['slug' => $banner['slug']], $banner);
        }
    }
}
