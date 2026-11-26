<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->first();

        $events = [
            [
                'title' => 'Bazar UMKM Putat Jaya 2024',
                'slug' => 'bazar-umkm-putat-jaya-2024',
                'description' => 'Bazar UMKM tahunan Kelurahan Putat Jaya yang menampilkan produk-produk terbaik dari pelaku UMKM lokal. Acara ini terbuka untuk umum dan gratis.',
                'event_date' => now()->addDays(30),
                'start_time' => '08:00:00',
                'end_time' => '16:00:00',
                'location_name' => 'Lapangan Kelurahan Putat Jaya',
                'address' => 'Jl. Putat Jaya, Kecamatan Sawahan, Surabaya',
                'latitude' => -7.2804,
                'longitude' => 112.7079,
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'title' => 'Pelatihan Digital Marketing UMKM',
                'slug' => 'pelatihan-digital-marketing-umkm',
                'description' => 'Pelatihan gratis digital marketing untuk pelaku UMKM Putat Jaya. Pelajari cara memasarkan produk secara online dan meningkatkan penjualan.',
                'event_date' => now()->addDays(15),
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
                'location_name' => 'Balai Kelurahan Putat Jaya',
                'address' => 'Jl. Putat Jaya No. 1, Surabaya',
                'latitude' => -7.2804,
                'longitude' => 112.7079,
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
        ];

        foreach ($events as $event) {
            Event::firstOrCreate(['slug' => $event['slug']], $event);
        }
    }
}
