<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Column already added in create_product_types_table migration
        // Keeping this empty to maintain migration history
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nothing to do, as the column was not added here
    }
};
