<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_profile_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('event_type', [
                'profile_view',
                'product_view',
                'whatsapp_click',
                'map_click',
                'search_query',
                'category_view',
                'banner_click',
                'event_view',
            ]);
            $table->string('session_hash', 64)->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['umkm_profile_id', 'event_type']);
            $table->index(['product_id', 'event_type']);
            $table->index('event_type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
    }
};
