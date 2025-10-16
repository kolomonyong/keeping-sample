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
        // Modify the status enum to include 'Dibuang'
        DB::statement("ALTER TABLE stocks MODIFY COLUMN status ENUM('Dibuat', 'Di Keeping Sample', 'Di Dispose', 'Di Gudang', 'Dibuang') DEFAULT 'Dibuat'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original enum
        DB::statement("ALTER TABLE stocks MODIFY COLUMN status ENUM('Dibuat', 'Di Keeping Sample', 'Di Dispose') DEFAULT 'Dibuat'");
    }
};
