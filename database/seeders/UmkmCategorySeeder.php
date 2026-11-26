<?php

namespace Database\Seeders;

use App\Models\UmkmCategory;
use Illuminate\Database\Seeder;

class UmkmCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Kuliner', 'slug' => 'kuliner', 'icon' => 'utensils', 'color_code' => '#EF4444', 'marker_color' => 'red', 'sort_order' => 1, 'description' => 'Makanan, minuman, katering, dan usaha kuliner lainnya'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'icon' => 'shirt', 'color_code' => '#3B82F6', 'marker_color' => 'blue', 'sort_order' => 2, 'description' => 'Pakaian, hijab, aksesori, dan usaha fashion lainnya'],
            ['name' => 'Jasa', 'slug' => 'jasa', 'icon' => 'wrench', 'color_code' => '#22C55E', 'marker_color' => 'green', 'sort_order' => 3, 'description' => 'Jasa laundry, salon, reparasi, dan usaha jasa lainnya'],
            ['name' => 'Perdagangan', 'slug' => 'perdagangan', 'icon' => 'store', 'color_code' => '#EAB308', 'marker_color' => 'yellow', 'sort_order' => 4, 'description' => 'Toko kelontong, warung, dan usaha perdagangan lainnya'],
            ['name' => 'Kerajinan', 'slug' => 'kerajinan', 'icon' => 'palette', 'color_code' => '#A855F7', 'marker_color' => 'purple', 'sort_order' => 5, 'description' => 'Kerajinan tangan, batik, seni, dan usaha kreatif lainnya'],
            ['name' => 'Digital', 'slug' => 'digital', 'icon' => 'laptop', 'color_code' => '#06B6D4', 'marker_color' => 'cyan', 'sort_order' => 6, 'description' => 'Desain grafis, IT, media sosial, dan usaha digital lainnya'],
            ['name' => 'Pertanian', 'slug' => 'pertanian', 'icon' => 'sprout', 'color_code' => '#16A34A', 'marker_color' => 'darkgreen', 'sort_order' => 7, 'description' => 'Pertanian, hidroponik, perkebunan, dan usaha agribisnis lainnya'],
            ['name' => 'Usaha Rumahan', 'slug' => 'usaha-rumahan', 'icon' => 'home', 'color_code' => '#F97316', 'marker_color' => 'orange', 'sort_order' => 8, 'description' => 'Usaha rumahan, makanan rumahan, dan industri kecil lainnya'],
        ];

        foreach ($categories as $data) {
            UmkmCategory::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
