<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use App\Models\Product;
use App\Models\UmkmCategory;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $umkmList = UmkmProfile::active()->select('slug', 'updated_at')->get();
        $products = Product::active()->select('slug', 'updated_at')->get();
        $categories = UmkmCategory::active()->select('slug', 'updated_at')->get();

        $content = view('sitemap', compact('umkmList', 'products', 'categories'))->render();

        return response($content, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /dashboard\nSitemap: " . route('sitemap');
        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
