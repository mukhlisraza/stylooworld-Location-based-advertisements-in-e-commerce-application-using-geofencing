<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToReferrersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referrers', function (Blueprint $table) {
            //
            $table->string('shorter_link')->after('referrer_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referrers', function (Blueprint $table) {
            //
            $table->string('shorter_link')->after('referrer_link');
        });
    }
}
