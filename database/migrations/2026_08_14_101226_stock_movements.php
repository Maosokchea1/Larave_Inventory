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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            
            // ទំនាក់ទំនងទៅ Product និង User
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // ប្រភេទចលនាស្តុក (គាំទ្រទាំង ៤ Option: in, out, adjustment, transfer)
            $table->enum('type', ['in', 'out', 'adjustment', 'transfer']);

            // ចំនួនស្តុកដែលត្រូវកែប្រែ
            $table->integer('quantity');

            // ស្តុកមុន និងក្រោយពេលធ្វើប្រតិបត្តិការ (សម្រាប់ Audit Log ដឹងពីសមតុល្យ)
            $table->integer('old_quantity')->default(0);
            $table->integer('new_quantity')->default(0);

            // ទីតាំងដើម និងទីតាំងគោលដៅ (ប្រើសម្រាប់មុខងារ Transfer)
            $table->foreignId('from_warehouse_id')->nullable()->constrained('warehouses')->onDelete('set null');
            $table->foreignId('to_warehouse_id')->nullable()->constrained('warehouses')->onDelete('set null');

            // Polymorphic relation (សម្រាប់ភ្ជាប់ទៅកាន់ Invoice, Sale, Purchase, ល)
            $table->nullableMorphs('reference');

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};