<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BunchSubscriber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bunch_subscriber', function (Blueprint $table) {
            $table->integer('bunch_id')->unsigned();
            $table->integer('subscriber_id')->unsigned();
            $table->primary(array('bunch_id', 'subscriber_id'));
            $table->foreign('bunch_id')->references('id')->on('bunches');
            $table->foreign('subscriber_id')->references('id')->on('subscribers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
