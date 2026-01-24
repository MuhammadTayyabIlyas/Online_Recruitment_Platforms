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
            // Add user_type column with enum values
            $table->enum('user_type', ['admin', 'employer', 'job_seeker'])
                  ->default('job_seeker')
                  ->after('id');

            // Add phone column
            $table->string('phone', 20)->nullable()->after('email');

            // Add avatar column for profile image path
            $table->string('avatar')->nullable()->after('phone');

            // Add is_active column for account status
            $table->boolean('is_active')->default(true)->after('avatar');

            // Add last login timestamp
            $table->timestamp('last_login_at')->nullable()->after('remember_token');

            // Add indexes for performance
            $table->index('user_type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['user_type']);
            $table->dropIndex(['is_active']);

            $table->dropColumn([
                'user_type',
                'phone',
                'avatar',
                'is_active',
                'last_login_at'
            ]);
        });
    }
};
