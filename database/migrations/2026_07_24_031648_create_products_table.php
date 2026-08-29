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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('SKU')->unique()->nullable(); // SKU ជាទូទៅគួរតែជា string និងអាចធ្វើ unique
            $table->decimal('Cost', 10, 2); // ប្រើ decimal ជំនួស float សម្រាប់តម្លៃលុយ ដើម្បីការពារបញ្ហាគណនេយ្យ
            $table->decimal('Price', 10, 2); // ប្រើ decimal សម្រាប់តម្លៃលក់
            $table->string('image')->nullable(); // កែពី image() មក string() វិញ
            $table->text('description')->nullable();
            $table->text('Note')->nullable(); // Note គួរតែជា text ឬ string ជំនួសឱ្យ integer
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};