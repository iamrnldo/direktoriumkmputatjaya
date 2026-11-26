<?php

namespace App\Exports;

use App\Models\UmkmProfile;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UmkmExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Enumerable
    {
        return UmkmProfile::with(['category', 'user'])->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Nama Usaha', 'Nama Pemilik', 'Kategori', 'Alamat',
            'Kelurahan', 'Kecamatan', 'Kota', 'WhatsApp', 'Email',
            'Status Verifikasi', 'UMKM Unggulan', 'Aktif',
            'Latitude', 'Longitude', 'Jumlah Dilihat',
            'Tanggal Dibuat', 'Terakhir Diperbarui',
        ];
    }

    public function map(mixed $umkm): array
    {
        return [
            $umkm->id,
            $umkm->name,
            $umkm->owner_name,
            $umkm->category?->name ?? '-',
            $umkm->address,
            $umkm->village,
            $umkm->district,
            $umkm->city,
            $umkm->whatsapp_number,
            $umkm->business_email ?? '-',
            $umkm->status_label,
            $umkm->is_featured ? 'Ya' : 'Tidak',
            $umkm->is_active ? 'Ya' : 'Tidak',
            $umkm->latitude ?? '-',
            $umkm->longitude ?? '-',
            $umkm->view_count,
            $umkm->created_at->format('d/m/Y'),
            $umkm->updated_at->format('d/m/Y'),
        ];
    }
}
