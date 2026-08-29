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
        Schema::table('stock_transactions', function (Blueprint $table) {
            // ប្រសិនបើជួរឈរ type របស់អ្នកជា ENUM សូមកែវាឡើងវិញឱ្យមាន 'transfer'
            $table->enum('type', ['in', 'out', 'adjustment', 'transfer'])->change();
            
            // ឬបើអ្នកចង់ប្រើ stringធម្មតា អាចប្រើកូដនេះជំនួសវិញ:
            // $table->string('type', 30)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->enum('type', ['in', 'out', 'adjustment'])->change();
        });
    }
};