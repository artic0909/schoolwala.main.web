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
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('fac_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->text('about_fac')->nullable();
            // assigned_classes in array store classes tables ids
            $table->json('assigned_classes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
