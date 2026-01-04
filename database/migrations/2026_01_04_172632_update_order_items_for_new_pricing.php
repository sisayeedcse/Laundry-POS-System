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
        Schema::table('order_items', function (Blueprint $table) {
            // Drop old service_type column
            $table->dropColumn('service_type');
        });

        Schema::table('order_items', function (Blueprint $table) {
            // Add new service_type column: wash_iron or iron_only
            $table->enum('service_type', ['wash_iron', 'iron_only'])->default('wash_iron')->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('service_type');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->enum('service_type', ['wash', 'iron', 'wash_and_iron'])->default('wash')->after('quantity');
        });
    }
};
