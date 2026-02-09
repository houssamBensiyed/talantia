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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Job Seeker
            $table->foreignId('job_offer_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['pending', 'reviewed', 'accepted', 'rejected'])->default('pending');
            $table->text('cover_letter')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'job_offer_id']); // One application per job per user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
