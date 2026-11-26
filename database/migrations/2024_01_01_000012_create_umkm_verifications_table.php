<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkm_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status');
            $table->text('notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index('umkm_profile_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm_verifications');
    }
};
