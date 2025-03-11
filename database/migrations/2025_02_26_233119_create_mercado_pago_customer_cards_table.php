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
        Schema::create('stripe_customer_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('stripe_customers');
            $table->string('card_id')->unique(); // ID do cartão salvo no Stripe
            $table->string('last4'); // Últimos 4 dígitos do cartão
            $table->integer('exp_month');
            $table->integer('exp_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_customer_cards');
    }
};
