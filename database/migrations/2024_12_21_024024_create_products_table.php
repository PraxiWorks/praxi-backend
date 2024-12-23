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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->string('name');
            $table->foreignId('category_id')->nullable()->constrained('product_categories');
            $table->string('sku_code');
            $table->float('price')->nullable();
            $table->string('path_image')->nullable();
            $table->boolean('status');
            $table->string('current_stock')->nullable();
            $table->string('minimum_stock_level')->nullable();
            $table->string('maximum_stock_level')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
