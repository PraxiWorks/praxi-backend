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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->string('event_type');
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('professional_id')->constrained('users');
            $table->foreignId('event_procedure_id')->constrained('event_procedures');
            $table->foreignId('event_status_id')->constrained('event_status');
            $table->foreignId('event_color_id')->constrained('event_colors');
            $table->string('observation')->nullable();
            $table->integer('selected_day_index');
            $table->date('date');
            $table->time('start_event');
            $table->time('end_event');
            $table->foreignId('event_recurrence_id')->constrained('event_recurrences');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
