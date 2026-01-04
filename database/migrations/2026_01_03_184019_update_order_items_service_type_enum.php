<?php

declare(strict_types=1);

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
        // Drop the existing column and recreate with new enum values
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('service_type');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->enum('service_type', ['wash', 'iron', 'wash_and_iron'])->default('wash')->after('quantity');
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
            $table->enum('service_type', ['normal', 'urgent'])->default('normal')->after('quantity');
        });
    }
};
