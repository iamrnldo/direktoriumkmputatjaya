<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->string('price_label')->nullable()->comment('Contoh: Mulai dari, Hubungi kami');
            $table->enum('availability_status', ['available', 'out_of_stock', 'preorder', 'unavailable'])->default('available');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['umkm_profile_id', 'is_active']);
            $table->index('is_featured');
            $table->index('availability_status');
            // $table->fullText(['name', 'short_description', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
