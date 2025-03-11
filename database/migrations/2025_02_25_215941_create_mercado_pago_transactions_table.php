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
        Schema::create('stripe_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('stripe_subscriptions');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('user_id')->constrained('users');
            $table->string('transaction_id')->unique(); // ID da transação do Stripe
            $table->string('status'); // succeeded, pending, failed
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_transactions');
    }
};
