<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackAnalytics
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Increment view_count for UMKM profile pages
        if ($request->route() && $request->route()->getName() === 'umkm.show') {
            $umkm = $request->route('umkmProfile');
            if ($umkm) {
                $umkm->increment('view_count');
            }
        }

        // Increment view_count for product pages
        if ($request->route() && $request->route()->getName() === 'produk.show') {
            $product = $request->route('product');
            if ($product) {
                $product->increment('view_count');
            }
        }

        return $response;
    }
}
