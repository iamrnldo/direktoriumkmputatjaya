<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkm_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('umkm_categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('owner_name');
            $table->text('business_description')->nullable();
            $table->string('address');
            $table->string('village')->default('Putat Jaya');
            $table->string('district')->default('Sawahan');
            $table->string('city')->default('Surabaya');
            $table->string('province')->default('Jawa Timur');
            $table->string('postal_code', 10)->nullable();
            $table->string('whatsapp_number');
            $table->string('business_email')->nullable();
            $table->string('website_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('shopee_url')->nullable();
            $table->string('tokopedia_url')->nullable();
            $table->string('marketplace_url')->nullable()->comment('Other marketplace');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('verification_status', [
                'draft',
                'diajukan',
                'perlu_revisi',
                'terverifikasi',
                'aktif',
                'ditolak',
                'nonaktif'
            ])->default('draft');
            $table->text('verification_notes')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(false);
            $table->integer('view_count')->default(0);
            $table->integer('whatsapp_click_count')->default(0);
            $table->integer('map_click_count')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['verification_status', 'is_active']);
            $table->index('category_id');
            $table->index('is_featured');
            // $table->fullText(['name', 'owner_name', 'business_description', 'address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm_profiles');
    }
};
