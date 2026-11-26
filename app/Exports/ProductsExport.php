<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Enumerable
    {
        return Product::with(['umkmProfile', 'category'])->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Nama Produk', 'UMKM', 'Kategori', 'Harga',
            'Label Harga', 'Status Ketersediaan', 'Unggulan', 'Aktif',
            'Jumlah Dilihat', 'Tanggal Dibuat',
        ];
    }

    public function map(mixed $product): array
    {
        return [
            $product->id,
            $product->name,
            $product->umkmProfile?->name ?? '-',
            $product->category?->name ?? '-',
            $product->price,
            $product->price_label ?? '-',
            $product->availability_label,
            $product->is_featured ? 'Ya' : 'Tidak',
            $product->is_active ? 'Ya' : 'Tidak',
            $product->view_count,
            $product->created_at->format('d/m/Y'),
        ];
    }
}
