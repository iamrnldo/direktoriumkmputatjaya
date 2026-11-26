<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UmkmOwnerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereHas('roles', fn($q) => $q->where('name', 'umkm_owner'))
            ->with(['roles', 'umkmProfile.category']);

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $owners = $query->latest()->paginate(20)->withQueryString();
        return view('admin.pelaku-umkm.index', compact('owners'));
    }

    public function show(User $pelakuUmkm)
    {
        $pelakuUmkm->load('umkmProfile.category', 'umkmProfile.products');
        return view('admin.pelaku-umkm.show', ['owner' => $pelakuUmkm]);
    }

    public function destroy(User $pelakuUmkm)
    {
        if ($pelakuUmkm->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        $pelakuUmkm->delete();
        return redirect()->route('admin.pelaku-umkm.index')->with('success', 'Pelaku UMKM berhasil dihapus.');
    }
}
