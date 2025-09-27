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
        Schema::table('videos', function (Blueprint $table) {
            $table->string('duration')->nullable()->after('correct_answers');
            $table->float('rating', 3, 2)->nullable()->after('duration');
            $table->text('feedback')->nullable()->after('rating');
            $table->unsignedBigInteger('likes')->nullable()->after('feedback');
            $table->unsignedBigInteger('views')->nullable()->after('likes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['duration', 'rating', 'feedback', 'likes', 'views']);
        });
    }
};
