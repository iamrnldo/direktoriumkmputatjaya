<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            UmkmCategorySeeder::class,
            ProductCategorySeeder::class,
            UmkmProfileSeeder::class,
            ProductSeeder::class,
            BannerSeeder::class,
            EventSeeder::class,
            SiteSettingSeeder::class,
            StaticPageSeeder::class,
        ]);
    }
}
