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
        Schema::create('clinical_admins', function (Blueprint $table) {
            $table->id();
            $table->string('clinic_name', 60);
            $table->string('mobile_number', 12);
            $table->string('city', 60)->nullable();
            $table->string('state', 60)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_admins');
    }
};
