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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique()->nullable();
            $table->text('description')->nullable();
            $table->enum('category', [
                'Detergent',
                'Softener',
                'Stain Remover',
                'Hangers',
                'Packaging',
                'Tags',
                'Supplies',
                'Other'
            ]);
            $table->string('unit')->default('pcs'); // pcs, kg, liters, boxes
            $table->decimal('current_stock', 10, 2)->default(0);
            $table->decimal('min_stock', 10, 2)->default(0);
            $table->decimal('max_stock', 10, 2)->nullable();
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->string('supplier')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
