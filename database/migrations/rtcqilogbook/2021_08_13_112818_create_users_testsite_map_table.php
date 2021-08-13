<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTestsiteMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_testsite_map', function (Blueprint $table) {
            $table->integer('ufm_id')->autoIncrement();
            $table->integer('user_id')->nullable();
            $table->integer('ts_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('ts_id')->references('ts_id')->on('test_sites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_testsite_map');
    }
}
