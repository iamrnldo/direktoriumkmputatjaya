<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Existing accounts remain usable; only new UMKM registrations are set to pending.
            $table->string('account_status', 20)->default('approved')->after('is_active');
            $table->text('account_review_note')->nullable()->after('account_status');
            $table->timestamp('account_reviewed_at')->nullable()->after('account_review_note');
            $table->index('account_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['account_status']);
            $table->dropColumn(['account_status', 'account_review_note', 'account_reviewed_at']);
        });
    }
};
