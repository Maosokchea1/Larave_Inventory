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
            // ពិនិត្យមើលសិន ក្រែងលោ index នោះមិនមាន ដើម្បីការពារការ Error
            // ឬប្រើ try-catch block 
        });

        // ប្រើវិធីសាស្ត្រផ្ទៀងផ្ទាត់ដោយកូដ PHP សុទ្ធ ឬរ้ามពេលគ្មាន
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['name']); // ឬប្រើ $table->dropUnique('users_name_unique');
            });
        } catch (\Exception $e) {
            // ប្រសិនបើគ្មាន index នេះទេ វា會រំលងការ Error ចោល ធ្វើឱ្យ migrate ដំណើរការបានចប់សព្វគ្រប់
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unique('name');
        });
    }
};