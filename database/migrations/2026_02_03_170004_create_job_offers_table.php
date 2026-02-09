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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Recruiter
            $table->string('title');
            $table->text('description');
            $table->string('company');
            $table->enum('contract_type', ['CDI', 'CDD', 'Full-time', 'Stage', 'Freelance']);
            $table->string('image'); // Required image
            $table->string('specialty')->nullable(); // For job search by métier
            $table->string('location')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
