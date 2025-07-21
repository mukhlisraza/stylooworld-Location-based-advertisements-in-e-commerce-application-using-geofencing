<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopTimingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_timing', function (Blueprint $table) {
            $table->id();
            $table->time('sunday_from');
            $table->time('sunday_to');
            $table->time('monday_from');
            $table->time('monday_to');
            $table->time('tuesday_from');
            $table->time('tuesday_to');
            $table->time('wednesday_from');
            $table->time('wednesday_to');
            $table->time('thursday_from');
            $table->time('thursday_to');
            $table->time('friday_from');
            $table->time('friday_to');
            $table->time('saturday_from');
            $table->time('saturday_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_timing');
    }
}
