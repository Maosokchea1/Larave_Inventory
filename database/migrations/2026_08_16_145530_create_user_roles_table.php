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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            // ភ្ជាប់ទៅកាន់តារាង users (user_id)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // ឈ្មោះសិទ្ធិ ឬ Role (ឧទាហរណ៍៖ Admin, Staff, ...)
            $table->string('role_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
    
};