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
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_name', 60)->after('name');
            $table->unsignedBigInteger('clinical_admin_id')->nullable()->after('id');
            $table->boolean('status')->default(0)->after('remember_token');
            $table->enum('role', ['super_admin','clinic_admin'])->default('clinic_admin')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
