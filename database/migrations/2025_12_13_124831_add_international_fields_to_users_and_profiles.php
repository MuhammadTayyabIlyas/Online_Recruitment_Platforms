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
        // Add country code to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('country_code', 5)->nullable()->after('phone')->comment('ISO country code for phone, e.g., US, GB, PK');
        });

        // Add country_iso to user_profiles table
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('country_iso', 2)->nullable()->after('location')->comment('ISO 3166-1 alpha-2 country code');
            $table->string('city')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('country_code');
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('country_iso');
        });
    }
};
