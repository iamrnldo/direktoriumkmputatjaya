<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->string('owner_nik', 16)->nullable()->after('owner_name');
            $table->string('owner_rt', 3)->nullable()->after('owner_nik');
            $table->string('owner_rw', 3)->nullable()->after('owner_rt');
        });
    }

    public function down(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->dropColumn(['owner_nik', 'owner_rt', 'owner_rw']);
        });
    }
};
