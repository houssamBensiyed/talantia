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
            $table->string('slug')->unique()->after('name');
        });

        // Generate slugs for existing users
        \DB::statement('UPDATE users SET slug = LOWER(REPLACE(LOWER(name), " ", "-")) WHERE slug IS NULL');
        
        // Ensure uniqueness by appending ID if needed
        \DB::statement('UPDATE users u1 
            SET slug = CONCAT(slug, "-", id)
            WHERE id < (
                SELECT MIN(id) FROM users u2 WHERE u2.slug = u1.slug
            )');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
