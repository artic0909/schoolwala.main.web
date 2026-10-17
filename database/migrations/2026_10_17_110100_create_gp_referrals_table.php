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
        Schema::create('gp_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gp_id')->constrained('ground_partners')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('payment_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gp_referrals');
    }
};
