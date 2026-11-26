<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\UmkmProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ProductCategory::all()->keyBy('slug');

        $products = [
            // Kedai Kopi Putat Jaya
            ['umkm' => 'kedai-kopi-putat-jaya', 'name' => 'Kopi Hitam Tubruk', 'price' => 8000, 'cat' => 'minuman', 'featured' => true, 'desc' => 'Kopi hitam tubruk khas Jawa dengan aroma kuat dan cita rasa pahit yang khas'],
            ['umkm' => 'kedai-kopi-putat-jaya', 'name' => 'Kopi Susu Gula Aren', 'price' => 15000, 'cat' => 'minuman', 'featured' => true, 'desc' => 'Perpaduan sempurna kopi arabika dengan susu segar dan gula aren asli'],
            ['umkm' => 'kedai-kopi-putat-jaya', 'name' => 'Es Kopi Vietnam', 'price' => 18000, 'cat' => 'minuman', 'featured' => false, 'desc' => 'Kopi robusta kental dengan susu kental manis disajikan dingin'],
            ['umkm' => 'kedai-kopi-putat-jaya', 'name' => 'Roti Bakar Cokelat', 'price' => 12000, 'cat' => 'makanan', 'featured' => false, 'desc' => 'Roti bakar dengan topping cokelat lembut dan keju'],

            // Warung Bu Sari
            ['umkm' => 'warung-bu-sari', 'name' => 'Nasi Rawon Spesial', 'price' => 20000, 'cat' => 'makanan', 'featured' => true, 'desc' => 'Rawon khas Surabaya dengan daging sapi empuk dan kuah hitam legit'],
            ['umkm' => 'warung-bu-sari', 'name' => 'Lontong Balap', 'price' => 15000, 'cat' => 'makanan', 'featured' => true, 'desc' => 'Lontong balap Surabaya asli dengan tahu goreng, tauge, dan lentho'],
            ['umkm' => 'warung-bu-sari', 'name' => 'Es Dawet Ayu', 'price' => 8000, 'cat' => 'minuman', 'featured' => false, 'desc' => 'Dawet ayu segar dengan santan kelapa muda dan gula aren'],

            // Keripik Bu Ani
            ['umkm' => 'keripik-bu-ani', 'name' => 'Keripik Singkong Balado', 'price' => 15000, 'cat' => 'makanan', 'featured' => true, 'desc' => 'Keripik singkong renyah dengan bumbu balado pedas manis'],
            ['umkm' => 'keripik-bu-ani', 'name' => 'Keripik Pisang Keju', 'price' => 12000, 'cat' => 'makanan', 'featured' => false, 'desc' => 'Keripik pisang renyah dengan taburan keju cheddar'],
            ['umkm' => 'keripik-bu-ani', 'name' => 'Keripik Tempe Original', 'price' => 10000, 'cat' => 'olahan-kemasan', 'featured' => false, 'desc' => 'Keripik tempe tipis renyah dengan bumbu bawang gurih'],
            ['umkm' => 'keripik-bu-ani', 'name' => 'Paket Mix Keripik 3 Varian', 'price' => 35000, 'cat' => 'olahan-kemasan', 'featured' => true, 'desc' => 'Paket hemat 3 bungkus keripik varian pilihan'],

            // Batik Putat Jaya
            ['umkm' => 'batik-putat-jaya', 'name' => 'Kain Batik Tulis Motif Sekar Jagad', 'price' => 350000, 'cat' => 'kerajinan', 'featured' => true, 'desc' => 'Kain batik tulis tangan dengan motif Sekar Jagad khas Jawa Timur'],
            ['umkm' => 'batik-putat-jaya', 'name' => 'Baju Batik Pria Lengan Panjang', 'price' => 250000, 'cat' => 'pakaian', 'featured' => true, 'desc' => 'Kemeja batik cap pria dengan bahan katun halus dan motif modern'],
            ['umkm' => 'batik-putat-jaya', 'name' => 'Dompet Batik Wanita', 'price' => 85000, 'cat' => 'aksesori', 'featured' => false, 'desc' => 'Dompet wanita berbahan batik dengan desain elegan'],

            // Hijab Cantik Surabaya
            ['umkm' => 'hijab-cantik-surabaya', 'name' => 'Hijab Segiempat Voal Premium', 'price' => 85000, 'cat' => 'pakaian', 'featured' => true, 'desc' => 'Hijab segiempat bahan voal premium anti kerut dan nyaman dipakai'],
            ['umkm' => 'hijab-cantik-surabaya', 'name' => 'Gamis Syari Daily Wear', 'price' => 185000, 'cat' => 'pakaian', 'featured' => false, 'desc' => 'Gamis syari bahan jersey premium untuk pemakaian sehari-hari'],
            ['umkm' => 'hijab-cantik-surabaya', 'name' => 'Inner Hijab Bergo', 'price' => 35000, 'cat' => 'aksesori', 'featured' => false, 'desc' => 'Inner bergo berbahan kaos yang nyaman dan menyerap keringat'],

            // Laundry Bersih Jaya
            ['umkm' => 'laundry-bersih-jaya', 'name' => 'Laundry Kilogram Regular', 'price' => 7000, 'cat' => 'jasa-layanan', 'featured' => false, 'desc' => 'Layanan cuci, kering, dan lipat per kilogram. Estimasi 2-3 hari.', 'price_label' => 'Rp7.000/kg'],
            ['umkm' => 'laundry-bersih-jaya', 'name' => 'Laundry Express 1 Hari', 'price' => 12000, 'cat' => 'jasa-layanan', 'featured' => true, 'desc' => 'Layanan laundry kilogram dengan penyelesaian 1 hari', 'price_label' => 'Rp12.000/kg'],

            // Salon Cantik Putat
            ['umkm' => 'salon-cantik-putat', 'name' => 'Creambath + Blow Dry', 'price' => 75000, 'cat' => 'jasa-layanan', 'featured' => true, 'desc' => 'Perawatan rambut creambath dengan produk premium dan blow dry styling'],
            ['umkm' => 'salon-cantik-putat', 'name' => 'Facial Wajah Basic', 'price' => 95000, 'cat' => 'jasa-layanan', 'featured' => false, 'desc' => 'Perawatan wajah dasar: cleansing, toning, masker, dan moisturizer'],
            ['umkm' => 'salon-cantik-putat', 'name' => 'Manicure + Pedicure', 'price' => 65000, 'cat' => 'jasa-layanan', 'featured' => false, 'desc' => 'Perawatan kuku tangan dan kaki lengkap dengan cat kuku pilihan'],

            // Kerajinan Daur Ulang
            ['umkm' => 'kerajinan-daur-ulang-putat', 'name' => 'Pot Tanaman Botol Plastik', 'price' => 25000, 'cat' => 'kerajinan', 'featured' => true, 'desc' => 'Pot tanaman unik dari botol plastik daur ulang dengan cat warna-warni'],
            ['umkm' => 'kerajinan-daur-ulang-putat', 'name' => 'Tas Anyam Plastik Premium', 'price' => 85000, 'cat' => 'aksesori', 'featured' => true, 'desc' => 'Tas anyaman dari plastik daur ulang yang kuat dan modis'],

            // Jasa Desain Kreatif
            ['umkm' => 'jasa-desain-kreatif-putat', 'name' => 'Desain Logo Bisnis', 'price' => 150000, 'cat' => 'jasa-layanan', 'featured' => true, 'desc' => 'Pembuatan logo profesional untuk bisnis dengan 3 konsep pilihan dan revisi', 'price_label' => 'Mulai Rp150.000'],
            ['umkm' => 'jasa-desain-kreatif-putat', 'name' => 'Desain Banner/Spanduk', 'price' => 75000, 'cat' => 'jasa-layanan', 'featured' => false, 'desc' => 'Desain banner, spanduk, atau backdrop untuk acara dan promosi'],

            // Kebun Hidroponik
            ['umkm' => 'kebun-hidroponik-jaya', 'name' => 'Selada Hidroponik Segar', 'price' => 15000, 'cat' => 'produk-segar', 'featured' => false, 'desc' => 'Selada segar dari kebun hidroponik tanpa pestisida, berat 250 gram', 'price_label' => 'Rp15.000/250gr'],
            ['umkm' => 'kebun-hidroponik-jaya', 'name' => 'Paket Sayur Mix Hidroponik', 'price' => 35000, 'cat' => 'produk-segar', 'featured' => true, 'desc' => 'Paket sayuran segar campuran: selada, kangkung, bayam, dan sawi'],
            ['umkm' => 'kebun-hidroponik-jaya', 'name' => 'Bayam Hijau Organik', 'price' => 8000, 'cat' => 'produk-segar', 'featured' => false, 'desc' => 'Bayam hijau segar organik, bebas pestisida, cocok untuk berbagai masakan'],

            // Es Krim Palopo
            ['umkm' => 'es-krim-palopo-surabaya', 'name' => 'Es Krim Durian Premium', 'price' => 25000, 'cat' => 'makanan', 'featured' => true, 'desc' => 'Es krim durian dengan buah durian pilihan tanpa pengawet, 1 cup'],
            ['umkm' => 'es-krim-palopo-surabaya', 'name' => 'Paket 6 Es Krim Pilihan', 'price' => 125000, 'cat' => 'makanan', 'featured' => false, 'desc' => 'Paket hemat 6 cup es krim dengan varian rasa sesuai pilihan'],

            // Kue Basah
            ['umkm' => 'kue-basah-bu-endang', 'name' => 'Klepon Pandan 1 Dus', 'price' => 20000, 'cat' => 'makanan', 'featured' => true, 'desc' => 'Klepon pandan isi gula merah, 1 dus isi 20 pcs, manis dan kenyal'],
            ['umkm' => 'kue-basah-bu-endang', 'name' => 'Onde-onde Wijen 1 Dos', 'price' => 25000, 'cat' => 'makanan', 'featured' => false, 'desc' => 'Onde-onde berbalut wijen dengan isian kacang hijau manis'],
            ['umkm' => 'kue-basah-bu-endang', 'name' => 'Paket Jajanan Pasar 5 Macam', 'price' => 75000, 'cat' => 'olahan-kemasan', 'featured' => true, 'desc' => 'Paket jajanan pasar tradisional 5 macam kue untuk 20 orang'],

            // Catering
            ['umkm' => 'catering-rasa-nusantara', 'name' => 'Nasi Kotak Ayam Bakar', 'price' => 25000, 'cat' => 'makanan', 'featured' => true, 'desc' => 'Nasi kotak lengkap dengan ayam bakar bumbu rujak, lalapan, dan sambal'],
            ['umkm' => 'catering-rasa-nusantara', 'name' => 'Prasmanan Paket Standar', 'price' => 45000, 'cat' => 'jasa-layanan', 'featured' => false, 'desc' => 'Paket prasmanan untuk berbagai acara. Harga per pax', 'price_label' => 'Mulai Rp45.000/pax']
        ];

        foreach ($products as $p) {
            $umkm = UmkmProfile::where('slug', $p['umkm'])->first();
            $catId = $categories[$p['cat']]->id ?? null;

            if ($umkm) {
                Product::firstOrCreate([
                    'umkm_profile_id' => $umkm->id,
                    'name' => $p['name'],
                ], [
                    'product_category_id' => $catId,
                    'description' => $p['desc'],
                    'price' => $p['price'],
                    'price_label' => $p['price_label'] ?? null,
                    'is_featured' => $p['featured'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
