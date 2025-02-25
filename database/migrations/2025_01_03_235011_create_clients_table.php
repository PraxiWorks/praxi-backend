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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('cpf_number')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('send_notification_email')->default(false);
            $table->boolean('send_notification_sms')->default(false);
            $table->boolean('send_notification_whatsapp')->default(false);
            $table->string('path_image')->nullable();
            $table->string('password')->nullable();
            $table->boolean('has_access_to_the_system')->default(false);
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
