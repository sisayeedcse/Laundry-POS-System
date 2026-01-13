<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing delivered orders to set delivered_at to their updated_at timestamp
        // This is a reasonable approximation since we don't have the exact delivery timestamp
        DB::table('orders')
            ->where('status', 'delivered')
            ->whereNull('delivered_at')
            ->update(['delivered_at' => DB::raw('updated_at')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set delivered_at back to null for orders that were backfilled
        DB::table('orders')
            ->where('status', 'delivered')
            ->update(['delivered_at' => null]);
    }
};
