<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         // Ensure all likes are numeric first
        DB::table('videos')->update([
            'likes' => DB::raw('IF(likes REGEXP "^[0-9]+$", likes, 0)')
        ]);

        Schema::table('videos', function (Blueprint $table) {
            $table->integer('likes')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('likes')->nullable()->change();
        });
    }
};
