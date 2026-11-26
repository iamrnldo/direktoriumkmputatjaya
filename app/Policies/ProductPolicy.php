<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Product $product): bool
    {
        if (!$user) {
            return $product->is_active && $product->umkmProfile?->is_active;
        }
        if ($user->isAdmin()) return true;
        if ($user->isUmkmOwner()) {
            return $product->umkmProfile?->user_id === $user->id || ($product->is_active && $product->umkmProfile?->is_active);
        }
        return $product->is_active && $product->umkmProfile?->is_active;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isUmkmOwner();
    }

    public function update(User $user, Product $product): bool
    {
        if ($user->isAdmin()) return true;
        return $user->isUmkmOwner() && $product->umkmProfile?->user_id === $user->id;
    }

    public function delete(User $user, Product $product): bool
    {
        if ($user->isAdmin()) return true;
        return $user->isUmkmOwner() && $product->umkmProfile?->user_id === $user->id;
    }

    public function manageFeatured(User $user): bool
    {
        return $user->isAdmin();
    }
}
