<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ពិនិត្យមើលថាតើមាន column 'image' ឬនៅ មុននឹងបន្ថែម ដើម្បីការពារ Error
            if (!Schema::hasColumn('users', 'image')) {
                $table->string('image')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};