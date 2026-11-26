<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Api;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Public as PublicCtrl;
use Illuminate\Support\Facades\Route;

// ==================================================
// PUBLIC ROUTES (no auth required)
// ==================================================
Route::get('/', [PublicCtrl\HomeController::class, 'index'])->name('home');
Route::get('/direktori-umkm', [PublicCtrl\UmkmController::class, 'index'])->name('direktori.umkm');
Route::get('/umkm/{slug}', [PublicCtrl\UmkmController::class, 'show'])->name('umkm.show');
Route::get('/kategori/{slug}', [PublicCtrl\CategoryController::class, 'show'])->name('kategori.show');
Route::get('/produk', [PublicCtrl\ProductController::class, 'index'])->name('produk.index');
Route::get('/produk/{slug}', [PublicCtrl\ProductController::class, 'show'])->name('produk.show');
Route::get('/kategori-produk/{slug}', [PublicCtrl\ProductCategoryController::class, 'show'])->name('kategori-produk.show');
Route::get('/umkm-unggulan', [PublicCtrl\FeaturedController::class, 'umkm'])->name('umkm-unggulan');
Route::get('/produk-unggulan', [PublicCtrl\FeaturedController::class, 'products'])->name('produk-unggulan');
Route::get('/peta-umkm', [PublicCtrl\MapController::class, 'index'])->name('peta-umkm');
Route::get('/event', [PublicCtrl\EventController::class, 'index'])->name('event.index');
Route::get('/event/{slug}', [PublicCtrl\EventController::class, 'show'])->name('event.show');
Route::get('/tentang', [PublicCtrl\StaticPageController::class, 'show'])->name('tentang')->defaults('slug', 'tentang');
Route::get('/kontak', [PublicCtrl\StaticPageController::class, 'show'])->name('kontak')->defaults('slug', 'kontak');
Route::get('/kebijakan-privasi', [PublicCtrl\StaticPageController::class, 'show'])->name('kebijakan-privasi')->defaults('slug', 'kebijakan-privasi');
Route::get('/syarat-ketentuan', [PublicCtrl\StaticPageController::class, 'show'])->name('syarat-ketentuan')->defaults('slug', 'syarat-ketentuan');
Route::get('/daftar-umkm', [PublicCtrl\HomeController::class, 'registerUmkm'])->name('daftar-umkm');
Route::get('/cari', [PublicCtrl\SearchController::class, 'index'])->name('cari');
Route::get('/sitemap.xml', [PublicCtrl\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [PublicCtrl\SitemapController::class, 'robots'])->name('robots');

// Reviews (public, auth required)
Route::post('/ulasan', [\App\Http\Controllers\Public\UmkmController::class, 'storeReview'])->name('ulasan.store')->middleware('auth');

// Favorite toggle
Route::post('/umkm/{umkm}/favorite', [\App\Http\Controllers\Public\UmkmController::class, 'toggleFavorite'])->name('umkm.favorite')->middleware('auth');

// Analytics tracking (POST, rate-limited)
Route::post('/api/analytics/track', [Api\AnalyticsController::class, 'track'])
    ->name('api.analytics.track-click')
    ->middleware('throttle:60,1');

// Map GeoJSON API
Route::get('/api/map/umkm', [Api\MapController::class, 'geojson'])
    ->name('api.map.umkm')
    ->middleware('throttle:60,1');

// ==================================================
// DASHBOARD ROUTES (UMKM Owner)
// ==================================================
Route::prefix('dashboard')
    ->name('dashboard.')
    ->middleware(['auth', 'role:umkm_owner'])
    ->group(function () {
        Route::get('/', [Dashboard\DashboardController::class, 'index'])->name('index');

        // Profile
        Route::get('/profil-usaha', [Dashboard\ProfileController::class, 'edit'])->name('profil-usaha');
        Route::post('/profil-usaha', [Dashboard\ProfileController::class, 'store'])->name('profil-usaha.store');
        Route::put('/profil-usaha', [Dashboard\ProfileController::class, 'update'])->name('profil-usaha.update');

        // Gallery
        Route::get('/galeri-usaha', [Dashboard\GalleryController::class, 'index'])->name('galeri-usaha');
        Route::post('/galeri-usaha', [Dashboard\GalleryController::class, 'store'])->name('galeri-usaha.store');
        Route::delete('/galeri-usaha/{image}', [Dashboard\GalleryController::class, 'destroy'])->name('galeri-usaha.destroy');
        Route::put('/galeri-usaha/{image}/cover', [Dashboard\GalleryController::class, 'setCover'])->name('galeri-usaha.set-cover');
        Route::patch('/galeri-usaha/{image}/cover', [Dashboard\GalleryController::class, 'setCover'])->name('galeri-usaha.cover');

        // Products
        Route::get('/produk/export', [Dashboard\ProductController::class, 'export'])->name('produk.export');
        Route::resource('produk', Dashboard\ProductController::class)->except(['show']);
        Route::post('/produk/{product}/gambar', [Dashboard\ProductController::class, 'uploadImages'])->name('produk.gambar.store');
        Route::delete('/produk/{product}/gambar/{image}', [Dashboard\ProductController::class, 'deleteImage'])->name('produk.gambar.destroy');

        // Reviews
        Route::get('/ulasan', [Dashboard\ReviewController::class, 'index'])->name('ulasan');

        // Business Hours
        Route::get('/jam-operasional', [Dashboard\BusinessHoursController::class, 'edit'])->name('jam-operasional');
        Route::put('/jam-operasional', [Dashboard\BusinessHoursController::class, 'update'])->name('jam-operasional.update');

        // Location
        Route::get('/lokasi', [Dashboard\LocationController::class, 'edit'])->name('lokasi');
        Route::put('/lokasi', [Dashboard\LocationController::class, 'update'])->name('lokasi.update');

        // Contact & Social Media
        Route::get('/kontak-media-sosial', [Dashboard\ContactController::class, 'edit'])->name('kontak-media-sosial');
        Route::put('/kontak-media-sosial', [Dashboard\ContactController::class, 'update'])->name('kontak-media-sosial.update');

        // Verification
        Route::get('/status-verifikasi', [Dashboard\VerificationController::class, 'index'])->name('status-verifikasi');
        Route::post('/ajukan-verifikasi', [Dashboard\VerificationController::class, 'submit'])->name('ajukan-verifikasi');

        // QR Code
        Route::get('/qr-code', [Dashboard\QrCodeController::class, 'index'])->name('qr-code');
        Route::get('/qr-code/download', [Dashboard\QrCodeController::class, 'download'])->name('qr-code.download');
        Route::get('/qr-code/download-svg', [Dashboard\QrCodeController::class, 'downloadSvg'])->name('qr-code.download-svg');

        // Statistics
        Route::get('/statistik', [Dashboard\StatisticsController::class, 'index'])->name('statistik');

        // Notifications
        Route::get('/notifikasi', [Dashboard\NotificationController::class, 'index'])->name('notifikasi');
        Route::post('/notifikasi/{id}/baca', [Dashboard\NotificationController::class, 'markRead'])->name('notifikasi.baca');

        // Account Settings
        Route::get('/pengaturan-akun', [Dashboard\AccountController::class, 'edit'])->name('pengaturan-akun');
        Route::put('/pengaturan-akun', [Dashboard\AccountController::class, 'update'])->name('pengaturan-akun.update');
        Route::delete('/pengaturan-akun', [Dashboard\AccountController::class, 'destroy'])->name('pengaturan-akun.destroy');
    });

// ==================================================
// ADMIN ROUTES
// ==================================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('index');

        // UMKM Management
        Route::resource('umkm', Admin\UmkmController::class);
        Route::post('/umkm/{umkm}/restore', [Admin\UmkmController::class, 'restore'])->name('umkm.restore');
        Route::post('/umkm/bulk-action', [Admin\UmkmController::class, 'bulkAction'])->name('umkm.bulk-action');

        // Verification
        Route::get('/verifikasi-umkm', [Admin\VerificationController::class, 'index'])->name('verifikasi-umkm.index');
        Route::get('/verifikasi-umkm/{umkm}', [Admin\VerificationController::class, 'show'])->name('verifikasi-umkm.show');
        Route::post('/verifikasi-umkm/{umkm}/approve', [Admin\VerificationController::class, 'approve'])->name('verifikasi-umkm.approve');
        Route::post('/verifikasi-umkm/{umkm}/reject', [Admin\VerificationController::class, 'reject'])->name('verifikasi-umkm.reject');
        Route::post('/verifikasi-umkm/{umkm}/revision', [Admin\VerificationController::class, 'requestRevision'])->name('verifikasi-umkm.request-revision');
        Route::post('/verifikasi-umkm/{umkm}/proses', [Admin\VerificationController::class, 'process'])->name('verifikasi-umkm.process');

        // UMKM Owners
        Route::resource('pelaku-umkm', Admin\UmkmOwnerController::class);

        // Categories
        Route::resource('kategori-umkm', Admin\UmkmCategoryController::class);
        Route::resource('kategori-produk', Admin\ProductCategoryController::class);

        // Products
        Route::resource('produk', Admin\ProductController::class);
        Route::post('/produk/{product}/toggle-featured', [Admin\ProductController::class, 'toggleFeatured'])->name('produk.toggle-featured');

        // Featured
        Route::get('/umkm-unggulan', [Admin\FeaturedUmkmController::class, 'index'])->name('umkm-unggulan');
        Route::post('/umkm-unggulan/{umkm}/toggle', [Admin\FeaturedUmkmController::class, 'toggle'])->name('umkm-unggulan.toggle');
        Route::get('/produk-unggulan', [Admin\FeaturedProductController::class, 'index'])->name('produk-unggulan');
        Route::post('/produk-unggulan/{product}/toggle', [Admin\FeaturedProductController::class, 'toggle'])->name('produk-unggulan.toggle');

        // Banners
        Route::resource('banner', Admin\BannerController::class);
        Route::post('/banner/{banner}/toggle-aktif', [Admin\BannerController::class, 'toggleActive'])->name('banner.toggle-aktif');

        // Events
        Route::resource('event', Admin\EventController::class);

        // Map
        Route::get('/peta-umkm', [Admin\MapController::class, 'index'])->name('peta-umkm');

        // Statistics
        Route::get('/statistik', [Admin\StatisticsController::class, 'index'])->name('statistik');

        // Export
        Route::get('/ekspor', [Admin\ExportController::class, 'index'])->name('ekspor');
        Route::get('/ekspor/umkm/excel', [Admin\ExportController::class, 'exportUmkmExcel'])->name('ekspor.umkm-excel');
        Route::get('/ekspor/umkm/csv', [Admin\ExportController::class, 'exportUmkm'])->name('ekspor.umkm-csv');
        Route::get('/ekspor/produk/excel', [Admin\ExportController::class, 'exportProductsExcel'])->name('ekspor.produk-excel');
        Route::get('/ekspor/produk/csv', [Admin\ExportController::class, 'exportProducts'])->name('ekspor.produk-csv');

        // Notifications
        Route::get('/notifikasi', [Admin\NotificationController::class, 'index'])->name('notifikasi');

        // Users & Roles
        Route::resource('pengguna', Admin\UserController::class);
        Route::get('/role-permission', [Admin\RoleController::class, 'index'])->name('role-permission');

        // Audit Log
        Route::get('/audit-log', [Admin\AuditLogController::class, 'index'])->name('audit-log');

        // Settings
        Route::get('/pengaturan', [Admin\SettingController::class, 'index'])->name('pengaturan');
        Route::put('/pengaturan', [Admin\SettingController::class, 'update'])->name('pengaturan.update');

        // Static Pages
        Route::resource('halaman-statis', Admin\StaticPageController::class);

        // Reviews moderation
        Route::get('/ulasan', [Admin\ReviewController::class, 'index'])->name('ulasan.index');
        Route::post('/ulasan/{review}/approve', [Admin\ReviewController::class, 'approve'])->name('ulasan.approve');
        Route::post('/ulasan/{review}/reject', [Admin\ReviewController::class, 'reject'])->name('ulasan.reject');
    });

require __DIR__.'/auth.php';
