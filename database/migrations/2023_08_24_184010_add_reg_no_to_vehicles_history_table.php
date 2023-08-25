<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegNoToVehiclesHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles_history', function (Blueprint $table) {
            $table->string('vehicle_reg')->nullable();
            $table->string('vin_number')->nullable();
            $table->string('vehicle_year_manufacture')->nullable();
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->integer('glass_position')->nullable();
            $table->string('argic_no')->nullable();
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
           $table->dropColumn('vehicle_reg');
           $table->dropColumn('vin_number');
           $table->dropColumn('vehicle_year_manufacture');
           $table->dropColumn('vehicle_make');
           $table->dropColumn('vehicle_model');
           $table->dropColumn('glass_position');
           $table->dropColumn('argic_no');
        });
    }
}
