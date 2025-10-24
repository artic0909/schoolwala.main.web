<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('waver_requests', function (Blueprint $table) {
            $table->tinyInteger('mail_status')->default(0)->after('address');
            $table->string('status')->default('pending')->after('mail_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waver_requests', function (Blueprint $table) {
            $table->dropColumn(['mail_status', 'status']);
        });
    }
};
