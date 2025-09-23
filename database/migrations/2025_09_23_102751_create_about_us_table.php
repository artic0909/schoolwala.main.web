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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('happy_kids');
            $table->string('fun_lessons');
            $table->string('satisfaction');
            $table->string('cm_email');
            $table->string('cm_mobile');
            $table->text('cm_address');
            $table->text('our_story');
            $table->text('our_vision');
            $table->text('bold_message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
