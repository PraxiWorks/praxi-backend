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
        Schema::create('stripe_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('stripe_transactions');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('user_id')->constrained('users');
            $table->string('refund_id')->unique(); // ID do reembolso no Stripe
            $table->decimal('amount', 10, 2);
            $table->string('status'); // succeeded, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_refunds');
    }
};
