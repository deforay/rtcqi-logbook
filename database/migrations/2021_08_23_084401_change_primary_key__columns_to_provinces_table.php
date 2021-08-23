<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePrimaryKeyColumnsToProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provinces', function (Blueprint $table) {
            $table->renameColumn('provincesss_id','province_id');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provinces', function (Blueprint $table) {
            //
            $table->integer('province_id','provincesss_id');
        });
    }
}
