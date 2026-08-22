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
        Schema::create('clinic_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinical_admin_id')->constrained('clinical_admins')->onDelete('cascade');
            $table->text('address')->nullable();
            $table->string('google_map_link')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('emergency_contact', 20)->nullable();

            $table->timestamps();

            // One contact setting record per clinic
            $table->unique('clinical_admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_contacts');
    }
};
