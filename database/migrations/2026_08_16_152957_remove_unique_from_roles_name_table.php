<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            Schema::table('roles', function (Blueprint $table) {
                // លុប Unique Constraint ចេញពី column 'name'
                $table->dropUnique(['name']);
            });
        } catch (\Throwable $e) {
            // លោតរំលង ប្រសិនបើ Index នោះមិនទាន់មាន ឬត្រូវគេលុបរួចហើយ
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE `roles` ADD UNIQUE `roles_name_unique`(`name`)');
        } catch (\Throwable $e) {
            // លោតរំលង Error ប្រសិនបើមាន Data 'Admin' ស្ទួនក្នុង DB ពេល Rollback
        }
    }
};