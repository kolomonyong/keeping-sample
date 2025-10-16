<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('unique_sample_id')->unique()->nullable()->comment('ID unik untuk barcode');
            $table->foreignId('product_type_id')->constrained('product_types')->onDelete('cascade');
            $table->foreignId('rack_id')->nullable()->constrained('racks')->onDelete('set null');
            $table->string('production_code');
            $table->string('batch')->nullable();
            $table->integer('quantity')->default(1);
            $table->date('production_date');
            $table->date('expiration_date');
            $table->text('remark')->nullable();
            $table->enum('status', ['Dibuat', 'Di Keeping Sample', 'Di Dispose'])->default('Dibuat');
            $table->timestamps();

            // Indexing
            $table->index('production_code');
            $table->index('batch');
            $table->index('expiration_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
