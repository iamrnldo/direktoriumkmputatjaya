<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('type')->default('string')->comment('string, boolean, integer, json, text');
            $table->string('group')->nullable()->comment('general, contact, social, appearance, map, feature_flags');
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
