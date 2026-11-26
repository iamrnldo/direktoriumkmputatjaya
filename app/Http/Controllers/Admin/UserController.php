<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->input('role')) {
            $query->whereHas('roles', fn($q) => $q->where('name', $role));
        }

        $users = $query->latest()->paginate(20)->withQueryString();
        $roles = Role::all();

        return view('admin.pengguna.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.pengguna.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $user->assignRole($request->role);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $pengguna)
    {
        $pengguna->load('roles', 'umkmProfile');
        return view('admin.pengguna.show', ['user' => $pengguna]);
    }

    public function edit(User $pengguna)
    {
        $roles = Role::all();
        return view('admin.pengguna.edit', ['user' => $pengguna, 'roles' => $roles]);
    }

    public function update(Request $request, User $pengguna)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $pengguna->id],
            'role' => ['required', 'exists:roles,name'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $pengguna->update(['name' => $request->name, 'email' => $request->email, 'is_active' => $request->boolean('is_active')]);
        $pengguna->syncRoles([$request->role]);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        $pengguna->delete();
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
