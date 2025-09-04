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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('chapter_id')->constrained()->onDelete('cascade');
            $table->string('video_title');
            $table->string('slug'); //video ttile slug
            $table->enum('video_type', ['paid', 'free']);
            $table->string('video_link')->nullable();
            $table->text('video_description')->nullable();
            $table->string('video_thumbnail')->nullable();
            $table->json('questions')->nullable(); // store multiple questions
            $table->json('answers')->nullable();   // store multiple answers
            $table->json('correct_answers')->nullable(); // store correct answers
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
