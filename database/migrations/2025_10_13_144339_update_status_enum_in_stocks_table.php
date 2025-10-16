<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First create a temporary column
        DB::statement("ALTER TABLE stocks ADD COLUMN status_new ENUM('Dibuat', 'Di Keeping Sample', 'Di Dispose') DEFAULT 'Dibuat'");

        // Map old values to new ones
        DB::statement("UPDATE stocks SET status_new = CASE
            WHEN status = 'in_storage' THEN 'Di Keeping Sample'
            WHEN status = 'defective' THEN 'Di Dispose'
            WHEN status = 'removed' THEN 'Di Dispose'
            ELSE 'Dibuat' END");

        // Drop the old status column
        DB::statement("ALTER TABLE stocks DROP COLUMN status");

        // Rename the new column to status
        DB::statement("ALTER TABLE stocks CHANGE status_new status ENUM('Dibuat', 'Di Keeping Sample', 'Di Dispose') DEFAULT 'Dibuat'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the process to revert back to original enum values
        DB::statement("ALTER TABLE stocks ADD COLUMN status_old ENUM('in_storage', 'defective', 'removed') DEFAULT 'in_storage'");

        DB::statement("UPDATE stocks SET status_old = CASE
            WHEN status = 'Di Keeping Sample' THEN 'in_storage'
            WHEN status = 'Di Dispose' THEN 'defective'
            ELSE 'in_storage' END");

        DB::statement("ALTER TABLE stocks DROP COLUMN status");

        DB::statement("ALTER TABLE stocks CHANGE status_old status ENUM('in_storage', 'defective', 'removed') DEFAULT 'in_storage'");
    }
};
