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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinical_admin_id')->constrained('clinical_admins')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time')->nullable();
            $table->string('department')->nullable();
            $table->string('token_number')->nullable();
            $table->string('shift_name')->nullable();
            $table->string('shift_time')->nullable();
            $table->enum('status', [
                'pending','in_consultation','completed', 'cancelled'
            ])->default('pending');
            $table->string('reffered_by')->nullable();
            $table->string('visit_type')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->text('reason')->nullable();
            $table->text('chief_complaint')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('prescription')->nullable();
            $table->text('test_recommended')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
