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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'card'])->default('cash')->after('payment_status');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'card'])->default('cash')->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer', 'upi'])->nullable()->after('payment_status');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer', 'upi'])->default('cash')->after('amount');
        });
    }
};
