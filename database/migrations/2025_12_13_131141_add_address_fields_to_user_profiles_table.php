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
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('address', 500)->nullable()->after('country_iso')->comment('Street address');
            $table->string('postal_code', 20)->nullable()->after('address')->comment('ZIP/Postal code');
            $table->string('province_state', 100)->nullable()->after('postal_code')->comment('Province/State name');
            $table->string('province_state_code', 10)->nullable()->after('province_state')->comment('Province/State ISO code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn(['address', 'postal_code', 'province_state', 'province_state_code']);
        });
    }
};
