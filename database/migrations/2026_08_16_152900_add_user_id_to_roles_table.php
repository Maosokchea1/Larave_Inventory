<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // ពិនិត្យមើលសិន ក្រែងលោមានរួចហើយ ការពារការ Error
            if (!Schema::hasColumn('roles', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('name')->constrained()->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            if (Schema::hasColumn('roles', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};