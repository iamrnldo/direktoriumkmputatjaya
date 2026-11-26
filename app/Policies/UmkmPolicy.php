<?php

namespace App\Policies;

use App\Models\UmkmProfile;
use App\Models\User;

class UmkmPolicy
{
    public function viewAny(?User $user): bool
    {
        return true; // Public
    }

    public function view(?User $user, UmkmProfile $umkm): bool
    {
        // Public can only see active UMKM
        if (!$user) {
            return $umkm->verification_status === 'aktif' && $umkm->is_active;
        }
        if ($user->isAdmin()) return true;
        if ($user->isUmkmOwner()) {
            return $umkm->user_id === $user->id || ($umkm->verification_status === 'aktif' && $umkm->is_active);
        }
        return $umkm->verification_status === 'aktif' && $umkm->is_active;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isUmkmOwner();
    }

    public function update(User $user, UmkmProfile $umkm): bool
    {
        if ($user->isAdmin()) return true;
        return $user->isUmkmOwner() && $umkm->user_id === $user->id;
    }

    public function delete(User $user, UmkmProfile $umkm): bool
    {
        return $user->isAdmin();
    }

    public function verify(User $user, UmkmProfile $umkm): bool
    {
        return $user->isAdmin();
    }

    public function manageFeatured(User $user): bool
    {
        return $user->isAdmin();
    }

    public function manageImages(User $user, UmkmProfile $umkm): bool
    {
        if ($user->isAdmin()) return true;
        return $user->isUmkmOwner() && $umkm->user_id === $user->id;
    }
}
