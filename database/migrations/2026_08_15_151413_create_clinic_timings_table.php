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
        Schema::create('clinic_timings', function (Blueprint $table) {
            $table->id();
             $table->foreignId('clinical_admin_id')->constrained('clinical_admins')->onDelete('cascade');
            $table->string('day');
            $table->time('morning_time')->nullable();
            $table->time('evening_time')->nullable();
            $table->unique(['clinical_admin_id', 'day']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_timings');
    }
};
