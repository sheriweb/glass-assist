<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddWindscreenLookupIdToVehiclesHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles_history', function (Blueprint $table) {
            // Update expiry_date
            DB::table('vehicles_history')
                ->where('expiry_date', '0000-00-00')
                ->update(['expiry_date' => null]);

            // Update datetime
            DB::table('vehicles_history')
                ->where('datetime', '0000-00-00 00:00:00')
                ->update(['datetime' => null]);
            
            $table->bigInteger('windscreen_lookup_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicles_history', function (Blueprint $table) {
            $table->dropColumn('windscreen_lookup_id');
        });
    }
}
