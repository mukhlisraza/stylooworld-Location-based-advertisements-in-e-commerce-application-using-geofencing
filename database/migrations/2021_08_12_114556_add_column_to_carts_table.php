<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            //
            $table->integer('vendor_id')->after('user_id');
            $table->text('vendor_name')->after('vendor_id');
            $table->text('business_name')->after('vendor_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            //
            $table->integer('vendor_id')->after('user_id');
            $table->text('vendor_name')->after('vendor_id');
            $table->text('business_name')->after('vendor_name');
        });
    }
}
