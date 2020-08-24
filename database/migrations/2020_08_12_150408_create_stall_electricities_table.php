<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStallElectricitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stall_electricities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stall_id');
            $table->foreignId('electricity_id');
            $table->bigInteger('meter_before');
            $table->bigInteger('meter_after');
            $table->bigInteger('kva_price');
            $table->bigInteger('kwh_price');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stall_electricities');
    }
}
