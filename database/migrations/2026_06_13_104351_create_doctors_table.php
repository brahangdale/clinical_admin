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
      Schema::create('doctors', function (Blueprint $table) {
        $table->id();
        $table->string('doctor_name');
        $table->string('mobile_number');
        $table->foreignId('clinical_admin_id')->constrained('clinical_admins')->onDelete('cascade');
        $table->string('email');
        $table->enum('gender', ['M','F', 'O'])->nullable();
        $table->date('dob')->nullable();
        $table->string('specialization')->nullable();
        $table->string('qualification')->nullable();
        $table->integer('experience')->default(0)->nullable(); 
        $table->decimal('consultation_fee', 10, 2)->nullable(); 
        $table->string('profile_photo')->nullable();
        $table->boolean('status')->default(1)->nullable();
        $table->text('address')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
