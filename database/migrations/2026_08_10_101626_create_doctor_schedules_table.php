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
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->string('day');
            $table->boolean('is_off')->default(false);
            $table->string('morning_start')->nullable();
            $table->string('morning_end')->nullable();
            $table->string('evening_start')->nullable();
            $table->string('evening_end')->nullable();
            $table->string('general_start')->nullable();
            $table->string('general_end')->nullable();
            $table->unique(['doctor_id', 'day']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
