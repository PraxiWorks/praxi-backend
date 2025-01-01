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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('cpf_number')->nullable();
            $table->string('rg_number')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('send_notification_email')->nullable();
            $table->boolean('send_notification_sms')->nullable();
            $table->boolean('send_notification_whatsapp')->nullable();
            $table->string('path_image');
            $table->string('password');
            $table->boolean('is_professional');
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
        Schema::dropIfExists('users');
    }
};
