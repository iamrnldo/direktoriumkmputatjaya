<?php

namespace Database\Seeders;

use App\Models\BusinessHour;
use App\Models\UmkmCategory;
use App\Models\UmkmProfile;
use App\Models\UmkmVerification;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UmkmProfileSeeder extends Seeder
{
    // Putat Jaya area coordinates (around -7.2804, 112.7079)
    private function randomCoord(): array
    {
        return [
            'lat' => -7.2804 + (rand(-50, 50) / 1000),
            'lng' => 112.7079 + (rand(-50, 50) / 1000),
        ];
    }

    public function run(): void
    {
        $admin = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->first();
        $owners = User::whereHas('roles', fn($q) => $q->where('name', 'umkm_owner'))->get();

        $categories = UmkmCategory::all()->keyBy('slug');

        $umkmData = [
            [
                'user' => 'budi@putatjaya.test',
                'name' => 'Kedai Kopi Putat Jaya',
                'owner_name' => 'Budi Santoso',
                'category' => 'kuliner',
                'description' => 'Kedai kopi lokal dengan suasana hangat dan nyaman. Menyajikan berbagai jenis kopi Nusantara, dari Aceh hingga Papua. Tersedia tempat nongkrong yang nyaman untuk kerja atau bersantai.',
                'address' => 'Jl. Putat Jaya III No. 12, Surabaya',
                'whatsapp' => '08112345601',
                'email' => 'kedaikopi.putatjaya@gmail.com',
                'instagram' => 'https://instagram.com/kedaikopi.putatjaya',
                'is_featured' => true,
                'status' => 'aktif',
                'hours' => ['open' => '07:00', 'close' => '22:00'],
            ],
            [
                'user' => 'sari@putatjaya.test',
                'name' => 'Warung Bu Sari',
                'owner_name' => 'Sari Wulandari',
                'category' => 'kuliner',
                'description' => 'Warung makan sederhana dengan masakan rumahan khas Surabaya. Menu andalan: nasi rawon, lontong balap, dan semanggi Surabaya. Buka setiap hari dari pagi hingga malam.',
                'address' => 'Jl. Putat Jaya Barat No. 45, Surabaya',
                'whatsapp' => '08112345602',
                'is_featured' => true,
                'status' => 'aktif',
                'hours' => ['open' => '06:00', 'close' => '21:00'],
            ],
            [
                'user' => 'rini@putatjaya.test',
                'name' => 'Catering Rasa Nusantara',
                'owner_name' => 'Rini Handayani',
                'category' => 'kuliner',
                'description' => 'Jasa catering profesional untuk berbagai acara: pernikahan, arisan, ulang tahun, dan acara kantor. Menyajikan masakan Jawa, Sunda, dan Nusantara. Harga terjangkau, rasa bintang lima.',
                'address' => 'Jl. Putat Jaya Timur No. 8, Surabaya',
                'whatsapp' => '08112345603',
                'email' => 'catering.rasa.nusantara@gmail.com',
                'instagram' => 'https://instagram.com/catering.rasanusantara',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '08:00', 'close' => '20:00'],
            ],
            [
                'user' => 'ahmad@putatjaya.test',
                'name' => 'Keripik Bu Ani',
                'owner_name' => 'Ahmad Fauzi',
                'category' => 'usaha-rumahan',
                'description' => 'Produksi keripik singkong, keripik pisang, dan aneka camilan khas Surabaya yang renyah dan lezat. Tersedia dalam berbagai varian rasa: original, balado, keju, dan pedas manis.',
                'address' => 'Jl. Putat Jaya IV No. 23, Surabaya',
                'whatsapp' => '08112345604',
                'instagram' => 'https://instagram.com/keripikbuani',
                'shopee' => 'https://shopee.co.id/keripikbuani',
                'is_featured' => true,
                'status' => 'aktif',
                'hours' => ['open' => '08:00', 'close' => '17:00'],
            ],
            [
                'user' => 'dewi@putatjaya.test',
                'name' => 'Batik Putat Jaya',
                'owner_name' => 'Dewi Lestari',
                'category' => 'kerajinan',
                'description' => 'Pengrajin batik tulis dan batik cap khas Surabaya. Memproduksi kain batik, baju batik, dan aksesori batik dengan motif-motif lokal yang unik dan khas Jawa Timur.',
                'address' => 'Jl. Putat Jaya No. 56, Surabaya',
                'whatsapp' => '08112345605',
                'email' => 'batik.putatjaya@gmail.com',
                'instagram' => 'https://instagram.com/batik.putatjaya',
                'tokopedia' => 'https://tokopedia.com/batikpuatjaya',
                'is_featured' => true,
                'status' => 'aktif',
                'hours' => ['open' => '09:00', 'close' => '17:00'],
            ],
            [
                'user' => 'hendra@putatjaya.test',
                'name' => 'Hijab Cantik Surabaya',
                'owner_name' => 'Hendra Wijaya',
                'category' => 'fashion',
                'description' => 'Toko hijab dan busana muslim wanita dengan koleksi terkini. Menyediakan berbagai pilihan hijab, gamis, dan aksesori fashion muslim dengan harga terjangkau dan kualitas premium.',
                'address' => 'Jl. Putat Jaya Selatan No. 34, Surabaya',
                'whatsapp' => '08112345606',
                'instagram' => 'https://instagram.com/hijabcantiksby',
                'shopee' => 'https://shopee.co.id/hijabcantiksby',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '09:00', 'close' => '20:00'],
            ],
            [
                'user' => 'eka@putatjaya.test',
                'name' => 'Laundry Bersih Jaya',
                'owner_name' => 'Eka Prasetyo',
                'category' => 'jasa',
                'description' => 'Laundry kilogram dan laundry satuan dengan penanganan profesional. Menggunakan detergen berkualitas dan pengharum premium. Antar jemput tersedia untuk wilayah Putat Jaya dan sekitarnya.',
                'address' => 'Jl. Putat Jaya II No. 7, Surabaya',
                'whatsapp' => '08112345607',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '07:00', 'close' => '21:00'],
            ],
            [
                'user' => 'fitri@putatjaya.test',
                'name' => 'Salon Cantik Putat',
                'owner_name' => 'Fitri Rahayu',
                'category' => 'jasa',
                'description' => 'Salon kecantikan wanita lengkap dengan layanan hair treatment, creambath, rebonding, coloring, manicure, pedicure, dan facial. Ditangani oleh tenaga profesional berpengalaman.',
                'address' => 'Jl. Putat Jaya Utara No. 19, Surabaya',
                'whatsapp' => '08112345608',
                'instagram' => 'https://instagram.com/saloncantikputat',
                'is_featured' => true,
                'status' => 'aktif',
                'hours' => ['open' => '08:00', 'close' => '19:00'],
            ],
            [
                'user' => 'agus@putatjaya.test',
                'name' => 'Toko Kelontong Jaya Makmur',
                'owner_name' => 'Agus Suryanto',
                'category' => 'perdagangan',
                'description' => 'Toko kelontong lengkap menyediakan kebutuhan sehari-hari dengan harga terjangkau. Tersedia berbagai produk sembako, camilan, minuman, dan kebutuhan rumah tangga lainnya.',
                'address' => 'Jl. Putat Jaya V No. 3, Surabaya',
                'whatsapp' => '08112345609',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '06:00', 'close' => '22:00'],
            ],
            [
                'user' => 'ani@putatjaya.test',
                'name' => 'Kerajinan Daur Ulang Putat',
                'owner_name' => 'Ani Setyaningrum',
                'category' => 'kerajinan',
                'description' => 'Kerajinan kreatif berbahan daur ulang. Mengubah botol plastik, kardus, dan limbah rumah tangga menjadi produk bernilai tinggi seperti pot tanaman, aksesori rumah, dan tas.',
                'address' => 'Jl. Putat Jaya VI No. 11, Surabaya',
                'whatsapp' => '08112345610',
                'instagram' => 'https://instagram.com/kerajinan.daur.ulang.putat',
                'is_featured' => true,
                'status' => 'aktif',
                'hours' => ['open' => '09:00', 'close' => '17:00'],
            ],
            [
                'user' => 'yanto@putatjaya.test',
                'name' => 'Jasa Desain Kreatif Putat',
                'owner_name' => 'Yanto Kusuma',
                'category' => 'digital',
                'description' => 'Jasa desain grafis profesional untuk kebutuhan bisnis Anda: logo, banner, spanduk, kartu nama, brosur, dan konten media sosial. Hasil berkualitas dengan harga bersahabat.',
                'address' => 'Jl. Putat Jaya VII No. 15, Surabaya',
                'whatsapp' => '08112345611',
                'email' => 'desainkreatifputat@gmail.com',
                'instagram' => 'https://instagram.com/desainkreatifputat',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '09:00', 'close' => '21:00'],
            ],
            [
                'user' => 'lia@putatjaya.test',
                'name' => 'Kebun Hidroponik Jaya',
                'owner_name' => 'Lia Permatasari',
                'category' => 'pertanian',
                'description' => 'Budidaya sayuran segar dengan sistem hidroponik. Menghasilkan selada, kangkung, bayam, dan berbagai sayuran lainnya tanpa pestisida. Tersedia layanan antar ke rumah.',
                'address' => 'Jl. Putat Jaya VIII No. 20, Surabaya',
                'whatsapp' => '08112345612',
                'instagram' => 'https://instagram.com/kebunhidroponik.jaya',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '07:00', 'close' => '18:00'],
            ],
            // Additional UMKM for variety
            [
                'user' => null,
                'name' => 'Bakso Bakar Pak Min',
                'owner_name' => 'Sumin Haryadi',
                'category' => 'kuliner',
                'description' => 'Bakso bakar dengan bumbu kacang spesial resep turun temurun. Tersedia bakso goreng, bakso bakar, dan es campur segar.',
                'address' => 'Jl. Putat Jaya IX No. 5, Surabaya',
                'whatsapp' => '08112345613',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '10:00', 'close' => '21:00'],
            ],
            [
                'user' => null,
                'name' => 'Bengkel Motor Jaya Abadi',
                'owner_name' => 'Slamet Riyadi',
                'category' => 'jasa',
                'description' => 'Bengkel motor terpercaya dengan teknisi berpengalaman. Melayani servis rutin, ganti oli, perbaikan mesin, dan modifikasi ringan untuk semua merk motor.',
                'address' => 'Jl. Putat Jaya X No. 28, Surabaya',
                'whatsapp' => '08112345614',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '08:00', 'close' => '18:00'],
            ],
            [
                'user' => null,
                'name' => 'Toko Sepatu Murah Putat',
                'owner_name' => 'Bambang Setiawan',
                'category' => 'perdagangan',
                'description' => 'Toko sepatu dan sandal dengan harga murah dan kualitas terjamin. Tersedia berbagai pilihan model untuk pria, wanita, dan anak-anak.',
                'address' => 'Jl. Putat Jaya XI No. 13, Surabaya',
                'whatsapp' => '08112345615',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '09:00', 'close' => '20:00'],
            ],
            [
                'user' => null,
                'name' => 'Konveksi Sinar Baru',
                'owner_name' => 'Wahyu Priyatno',
                'category' => 'fashion',
                'description' => 'Konveksi pakaian untuk seragam sekolah, seragam kerja, kaos polo, dan pakaian olahraga. Menerima pesanan partai dan satuan dengan kualitas jahitan rapi.',
                'address' => 'Jl. Putat Jaya XII No. 9, Surabaya',
                'whatsapp' => '08112345616',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '08:00', 'close' => '17:00'],
            ],
            [
                'user' => null,
                'name' => 'Es Krim Palopo Surabaya',
                'owner_name' => 'Ratna Dewi',
                'category' => 'kuliner',
                'description' => 'Produksi es krim artisan dengan bahan-bahan lokal pilihan. Tersedia berbagai rasa unik khas Nusantara: durian, pandan, cokelat Sulawesi, dan mangga harum manis.',
                'address' => 'Jl. Putat Jaya XIII No. 6, Surabaya',
                'whatsapp' => '08112345617',
                'instagram' => 'https://instagram.com/eskrimpalopo',
                'shopee' => 'https://shopee.co.id/eskrimpalopo',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '10:00', 'close' => '22:00'],
            ],
            [
                'user' => null,
                'name' => 'Tempe & Tahu Bu Rohani',
                'owner_name' => 'Rohani Susanti',
                'category' => 'usaha-rumahan',
                'description' => 'Produksi tempe dan tahu segar setiap hari dari kedelai pilihan. Tanpa bahan pengawet, sehat, dan bergizi. Tersedia dalam berbagai ukuran untuk kebutuhan rumah tangga dan warung.',
                'address' => 'Jl. Putat Jaya XIV No. 17, Surabaya',
                'whatsapp' => '08112345618',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '05:00', 'close' => '12:00'],
            ],
            [
                'user' => null,
                'name' => 'Studio Foto Mini Putat',
                'owner_name' => 'Doni Prasetya',
                'category' => 'digital',
                'description' => 'Studio foto mini untuk kebutuhan foto KTP, paspor, SKCK, ijazah, dan foto keluarga. Juga melayani cetak foto kilat dan fotografi produk untuk UMKM.',
                'address' => 'Jl. Putat Jaya XV No. 22, Surabaya',
                'whatsapp' => '08112345619',
                'instagram' => 'https://instagram.com/studiofoto.putat',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '09:00', 'close' => '18:00'],
            ],
            [
                'user' => null,
                'name' => 'Kue Basah Bu Endang',
                'owner_name' => 'Endang Sulistyowati',
                'category' => 'usaha-rumahan',
                'description' => 'Pembuatan kue basah tradisional: klepon, onde-onde, nagasari, lemper, dan aneka jajanan pasar lainnya. Cocok untuk arisan, selamatan, dan acara keluarga.',
                'address' => 'Jl. Putat Jaya XVI No. 4, Surabaya',
                'whatsapp' => '08112345620',
                'is_featured' => false,
                'status' => 'aktif',
                'hours' => ['open' => '06:00', 'close' => '15:00'],
            ],
            [
                'user' => null,
                'name' => 'Warung Soto Madura Putat',
                'owner_name' => 'Abdurrahman',
                'category' => 'kuliner',
                'description' => 'Warung soto Madura dengan kuah bening yang segar dan kaya rempah. Disajikan dengan daging sapi empuk, tauge, kubis, dan pelengkap lainnya.',
                'address' => 'Jl. Putat Jaya XVII No. 1, Surabaya',
                'whatsapp' => '08112345621',
                'is_featured' => false,
                'status' => 'diajukan',
                'hours' => ['open' => '06:00', 'close' => '14:00'],
            ],
            [
                'user' => null,
                'name' => 'Toko ATK & Fotokopi Cahaya',
                'owner_name' => 'Cahyono Budiyanto',
                'category' => 'perdagangan',
                'description' => 'Toko alat tulis kantor dan jasa fotokopi lengkap. Menyediakan berbagai kebutuhan ATK, penjilidan, laminating, cetak dokumen, dan perlengkapan sekolah.',
                'address' => 'Jl. Putat Jaya XVIII No. 31, Surabaya',
                'whatsapp' => '08112345622',
                'is_featured' => false,
                'status' => 'perlu_revisi',
                'hours' => ['open' => '08:00', 'close' => '20:00'],
            ],
        ];

        foreach ($umkmData as $data) {
            $user = null;
            if ($data['user']) {
                $user = User::where('email', $data['user'])->first();
            }

            $coord = $this->randomCoord();
            $categoryId = $categories[$data['category']]->id ?? null;

            $slug = \Illuminate\Support\Str::slug($data['name']);
            $slugBase = $slug;
            $i = 1;
            while (UmkmProfile::where('slug', $slug)->exists()) {
                $slug = $slugBase . '-' . $i;
                $i++;
            }

            $profile = UmkmProfile::firstOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $user?->id,
                    'category_id' => $categoryId,
                    'name' => $data['name'],
                    'slug' => $slug,
                    'owner_name' => $data['owner_name'],
                    'business_description' => $data['description'],
                    'address' => $data['address'],
                    'village' => 'Putat Jaya',
                    'district' => 'Sawahan',
                    'city' => 'Surabaya',
                    'province' => 'Jawa Timur',
                    'postal_code' => '60252',
                    'whatsapp_number' => $data['whatsapp'],
                    'business_email' => $data['email'] ?? null,
                    'instagram_url' => $data['instagram'] ?? null,
                    'shopee_url' => $data['shopee'] ?? null,
                    'tokopedia_url' => $data['tokopedia'] ?? null,
                    'latitude' => $coord['lat'],
                    'longitude' => $coord['lng'],
                    'verification_status' => $data['status'],
                    'is_featured' => $data['is_featured'],
                    'is_active' => $data['status'] === 'aktif',
                    'verified_at' => $data['status'] === 'aktif' ? now() : null,
                    'activated_at' => $data['status'] === 'aktif' ? now() : null,
                    'view_count' => rand(10, 500),
                    'whatsapp_click_count' => rand(5, 100),
                    'map_click_count' => rand(2, 50),
                    'created_by' => $admin?->id,
                ]
            );

            // Create business hours (Mon-Sat open, Sun closed by default)
            for ($day = 0; $day <= 6; $day++) {
                BusinessHour::firstOrCreate(
                    ['umkm_profile_id' => $profile->id, 'day_of_week' => $day],
                    [
                        'is_closed' => ($day === 0), // Sunday closed
                        'open_time' => ($day !== 0) ? $data['hours']['open'] : null,
                        'close_time' => ($day !== 0) ? $data['hours']['close'] : null,
                    ]
                );
            }

            // Create verification record for active profiles
            if (in_array($data['status'], ['aktif', 'terverifikasi'])) {
                UmkmVerification::firstOrCreate(
                    ['umkm_profile_id' => $profile->id],
                    [
                        'admin_id' => $admin?->id,
                        'status' => 'approved',
                        'notes' => 'Data telah diverifikasi dan disetujui oleh admin kelurahan.',
                        'verified_at' => now(),
                    ]
                );
            }
        }
    }
}
