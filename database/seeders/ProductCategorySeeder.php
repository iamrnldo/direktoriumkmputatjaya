<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan', 'slug' => 'makanan', 'icon' => 'utensils', 'sort_order' => 1],
            ['name' => 'Minuman', 'slug' => 'minuman', 'icon' => 'coffee', 'sort_order' => 2],
            ['name' => 'Pakaian', 'slug' => 'pakaian', 'icon' => 'shirt', 'sort_order' => 3],
            ['name' => 'Aksesori', 'slug' => 'aksesori', 'icon' => 'watch', 'sort_order' => 4],
            ['name' => 'Kerajinan', 'slug' => 'kerajinan', 'icon' => 'palette', 'sort_order' => 5],
            ['name' => 'Jasa & Layanan', 'slug' => 'jasa-layanan', 'icon' => 'wrench', 'sort_order' => 6],
            ['name' => 'Produk Segar', 'slug' => 'produk-segar', 'icon' => 'leaf', 'sort_order' => 7],
            ['name' => 'Olahan & Kemasan', 'slug' => 'olahan-kemasan', 'icon' => 'package', 'sort_order' => 8],
        ];

        foreach ($categories as $data) {
            ProductCategory::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
