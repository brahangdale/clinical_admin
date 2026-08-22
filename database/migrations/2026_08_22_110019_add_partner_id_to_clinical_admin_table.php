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
        Schema::table('clinical_admins', function (Blueprint $table) {
            $table->foreignId('partner_id')->after('clinic_name')->nullable()->constrained('partners')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_admin', function (Blueprint $table) {
            //
        });
    }
};
