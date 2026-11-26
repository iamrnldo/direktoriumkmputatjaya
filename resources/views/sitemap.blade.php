<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ route('home') }}</loc><changefreq>daily</changefreq><priority>1.0</priority></url>
    <url><loc>{{ route('direktori.umkm') }}</loc><changefreq>daily</changefreq><priority>0.9</priority></url>
    <url><loc>{{ route('produk.index') }}</loc><changefreq>daily</changefreq><priority>0.8</priority></url>
    <url><loc>{{ route('peta-umkm') }}</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>
    @if(isset($umkmList))
    @foreach($umkmList as $umkm)
    <url>
        <loc>{{ route('umkm.show', $umkm->slug) }}</loc>
        <lastmod>{{ $umkm->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @endif
    @if(isset($products))
    @foreach($products as $product)
    <url>
        <loc>{{ route('produk.show', $product->slug) }}</loc>
        <lastmod>{{ $product->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
    @endif
</urlset>
