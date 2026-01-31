<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'user_type')) {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('admin','employer','job_seeker','student','educational_institution','service_user') DEFAULT 'job_seeker'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('users', 'user_type')) {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('admin','employer','job_seeker','student','educational_institution') DEFAULT 'job_seeker'");
    }
};
