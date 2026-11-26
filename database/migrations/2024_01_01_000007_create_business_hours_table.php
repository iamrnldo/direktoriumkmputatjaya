<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_profile_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('day_of_week')->comment('0=Minggu, 1=Senin, ..., 6=Sabtu');
            $table->boolean('is_closed')->default(false);
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->timestamps();

            $table->unique(['umkm_profile_id', 'day_of_week']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_hours');
    }
};
