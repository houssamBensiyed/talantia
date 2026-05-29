<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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

        $usedSlugs = [];

        DB::table('users')
            ->orderBy('id')
            ->get(['id', 'name'])
            ->each(function (object $user) use (&$usedSlugs): void {
                $baseSlug = Str::slug($user->name) ?: 'user';
                $slug = isset($usedSlugs[$baseSlug]) ? "{$baseSlug}-{$user->id}" : $baseSlug;

                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['slug' => $slug]);

                $usedSlugs[$slug] = true;
            });
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
