<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bunches', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('subscribers', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('templates', function (Blueprint $table) {
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
        //
    }
}
