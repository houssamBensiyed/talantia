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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['recruiter', 'job_seeker'])->after('email');
            $table->string('company')->nullable()->after('user_type');
            $table->string('specialty')->nullable()->after('company');
            $table->text('bio')->nullable()->after('specialty');
            $table->string('photo')->nullable()->after('bio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'company', 'specialty', 'bio', 'photo']);
        });
    }
};
