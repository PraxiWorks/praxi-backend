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
            $table->foreignId('category_id')->constrained('product_categories');
            $table->string('sku_code');
            $table->float('price')->nullable();
            $table->string('path_image')->nullable();
            $table->boolean('status');
            $table->integer('current_stock')->nullable();
            $table->integer('minimum_stock_level')->nullable();
            $table->integer('maximum_stock_level')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
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
