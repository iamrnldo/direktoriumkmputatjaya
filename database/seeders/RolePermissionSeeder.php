<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // UMKM
            'view umkm', 'create umkm', 'edit umkm', 'delete umkm', 'verify umkm',
            'manage featured umkm',
            // Products
            'view product', 'create product', 'edit product', 'delete product',
            'manage featured product',
            // Categories
            'manage umkm category', 'manage product category',
            // Users
            'view users', 'manage users',
            // Content
            'manage banner', 'manage event', 'manage static page',
            // Analytics
            'view analytics', 'export data',
            // Settings
            'manage settings',
            // Audit
            'view audit log',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $umkmOwner = Role::firstOrCreate(['name' => 'umkm_owner']);
        $visitor = Role::firstOrCreate(['name' => 'visitor']);

        // Assign all permissions to admin
        $admin->syncPermissions(Permission::all());

        // UMKM owner permissions
        $umkmOwner->syncPermissions([
            'view umkm', 'create umkm', 'edit umkm',
            'view product', 'create product', 'edit product', 'delete product',
            'view analytics',
        ]);

        // Visitor permissions (minimal)
        $visitor->syncPermissions(['view umkm', 'view product']);
    }
}
