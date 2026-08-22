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
        Schema::create('about_clinics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinical_admin_id')->constrained('clinical_admins')->onDelete('cascade');
            $table->string('logo')->nullable();
            $table->string('name')->nullable();
            $table->string('tagline')->nullable();
            $table->text('about_clinic')->nullable();
            $table->text('experience')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_clinics');
    }
};
