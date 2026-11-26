<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsExport;
use App\Exports\UmkmExport;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function index()
    {
        return view('admin.ekspor');
    }

    public function exportUmkm(): BinaryFileResponse
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'export_umkm_csv',
            'created_at' => now(),
        ]);
        return Excel::download(new UmkmExport, 'umkm-putat-jaya-' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportUmkmExcel(): BinaryFileResponse
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'export_umkm_excel',
            'created_at' => now(),
        ]);
        return Excel::download(new UmkmExport, 'umkm-putat-jaya-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportProducts(): BinaryFileResponse
    {
        return Excel::download(new ProductsExport, 'produk-putat-jaya-' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportProductsExcel(): BinaryFileResponse
    {
        return Excel::download(new ProductsExport, 'produk-putat-jaya-' . now()->format('Y-m-d') . '.xlsx');
    }
}
