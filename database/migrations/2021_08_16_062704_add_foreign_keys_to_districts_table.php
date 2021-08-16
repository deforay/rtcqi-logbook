<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->foreign('provincesss_id', 'districts_ibfk_1')->references('provincesss_id')->on('provinces');
            $table->foreign('provincesss_id', 'districts_ibfk_2')->references('provincesss_id')->on('provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->dropForeign('districts_ibfk_1');
            $table->dropForeign('districts_ibfk_2');
        });
    }
}
