<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'user_type')) {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('admin','employer','job_seeker','student','educational_institution') DEFAULT 'job_seeker'");
    }

    public function down(): void
    {
        if (!Schema::hasColumn('users', 'user_type')) {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('admin','employer','job_seeker') DEFAULT 'job_seeker'");
    }
};
