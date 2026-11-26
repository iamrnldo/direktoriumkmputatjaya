<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang',
                'meta_title' => 'Tentang Direktori UMKM Putat Jaya',
                'meta_description' => 'Mengenal Direktori UMKM Kelurahan Putat Jaya, platform digital untuk mendukung dan mempromosikan usaha lokal.',
                'content' => '<h2>Tentang Direktori UMKM Putat Jaya</h2><p>Direktori UMKM Putat Jaya adalah platform digital yang dikelola oleh Kelurahan Putat Jaya, Kecamatan Sawahan, Kota Surabaya untuk mendata, mempromosikan, dan menghubungkan Usaha Mikro, Kecil, dan Menengah (UMKM) di wilayah Kelurahan Putat Jaya dengan masyarakat luas.</p><h3>Visi</h3><p>Menjadi platform digital terdepan yang mendukung pertumbuhan ekonomi lokal Kelurahan Putat Jaya melalui digitalisasi UMKM.</p><h3>Misi</h3><ul><li>Mendata dan mendokumentasikan seluruh UMKM di Kelurahan Putat Jaya</li><li>Memfasilitasi promosi produk dan jasa UMKM secara digital</li><li>Menghubungkan pelaku UMKM dengan masyarakat dan konsumen</li><li>Mendukung pertumbuhan ekonomi lokal yang berkelanjutan</li></ul>',
            ],
            [
                'title' => 'Kontak',
                'slug' => 'kontak',
                'meta_title' => 'Kontak Direktori UMKM Putat Jaya',
                'meta_description' => 'Hubungi kami untuk informasi lebih lanjut tentang Direktori UMKM Kelurahan Putat Jaya.',
                'content' => '<h2>Hubungi Kami</h2><p>Untuk informasi lebih lanjut, pertanyaan, atau saran, silakan hubungi kami melalui:</p>',
            ],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'kebijakan-privasi',
                'meta_title' => 'Kebijakan Privasi Direktori UMKM Putat Jaya',
                'meta_description' => 'Kebijakan privasi penggunaan Direktori UMKM Kelurahan Putat Jaya.',
                'content' => '<h2>Kebijakan Privasi</h2><p>Kebijakan privasi ini menjelaskan bagaimana Direktori UMKM Putat Jaya mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.</p><h3>Informasi yang Dikumpulkan</h3><p>Kami hanya mengumpulkan informasi yang diperlukan untuk menjalankan layanan, termasuk nama, email, dan informasi usaha untuk pelaku UMKM yang mendaftar.</p><h3>Penggunaan Informasi</h3><p>Informasi yang dikumpulkan digunakan untuk mengelola profil UMKM, memberikan layanan kepada pengguna, dan meningkatkan kualitas platform.</p><h3>Perlindungan Data</h3><p>Kami berkomitmen untuk melindungi data pribadi Anda dan tidak akan menjual atau berbagi data kepada pihak ketiga tanpa izin Anda.</p>',
            ],
            [
                'title' => 'Syarat dan Ketentuan',
                'slug' => 'syarat-ketentuan',
                'meta_title' => 'Syarat dan Ketentuan Direktori UMKM Putat Jaya',
                'meta_description' => 'Syarat dan ketentuan penggunaan Direktori UMKM Kelurahan Putat Jaya.',
                'content' => '<h2>Syarat dan Ketentuan</h2><p>Dengan menggunakan Direktori UMKM Putat Jaya, Anda setuju untuk mematuhi syarat dan ketentuan berikut.</p><h3>Penggunaan Platform</h3><p>Platform ini diperuntukkan bagi masyarakat umum dan pelaku UMKM di Kelurahan Putat Jaya. Pengguna dilarang menggunakan platform untuk kegiatan yang melanggar hukum.</p><h3>Akurasi Data</h3><p>Pelaku UMKM bertanggung jawab atas keakuratan informasi yang diberikan. Kelurahan berhak memverifikasi dan menolak data yang tidak sesuai.</p><h3>Hak dan Kewajiban</h3><p>Kelurahan berhak memperbarui, menangguhkan, atau menghapus konten yang melanggar kebijakan platform.</p>',
            ],
        ];

        foreach ($pages as $page) {
            StaticPage::firstOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
