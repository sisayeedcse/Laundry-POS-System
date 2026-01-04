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
        Schema::table('services', function (Blueprint $table) {
            // Remove old pricing columns
            $table->dropColumn(['price_normal', 'price_urgent']);
        });

        Schema::table('services', function (Blueprint $table) {
            // Add new pricing columns based on service type
            $table->decimal('price_wash_iron', 10, 2)->default(0)->after('category')->comment('Washing & Ironing service price');
            $table->decimal('price_iron_only', 10, 2)->nullable()->after('price_wash_iron')->comment('Ironing only service price');
            $table->string('size_variant')->nullable()->after('name')->comment('Size: standard, big, medium, small');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['price_wash_iron', 'price_iron_only', 'size_variant']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->decimal('price_normal', 10, 2)->default(0)->after('category');
            $table->decimal('price_urgent', 10, 2)->default(0)->after('price_normal');
        });
    }
};
