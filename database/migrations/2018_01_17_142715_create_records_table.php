<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_id')->unsigned();
            $table->foreign('report_id')->references('id')->on('reports');
            $table->string('email');
            $table->string('mail_id')->nullable();

            // Status
            $table->boolean('queued')->default(false);
            $table->boolean('sended')->default(false);
            $table->boolean('accepted')->default(false);
            $table->boolean('delivered')->default(false);
            $table->boolean('failed')->default(false);
            $table->boolean('opened')->default(false);
            $table->boolean('unsubscribed')->default(false);
            $table->string('unsubscribe_reason')->nullable();

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
        Schema::dropIfExists('records');
    }
}
