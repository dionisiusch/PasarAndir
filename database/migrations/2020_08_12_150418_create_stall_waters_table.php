<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStallWatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stall_waters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stall_id');
            $table->bigInteger('meter_before');
            $table->bigInteger('meter_after');
            $table->bigInteger('price');
            $table->bigInteger('fixed_price'); //BIAYA TETAP
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
        Schema::dropIfExists('stall_waters');
    }
}
