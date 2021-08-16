<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAllowedTestkitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('allowed_testkits', function (Blueprint $table) {
            $table->foreign('testkit_id', 'allowed_testkits_ibfk_1')->references('tk_id')->on('test_kits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('allowed_testkits', function (Blueprint $table) {
            $table->dropForeign('allowed_testkits_ibfk_1');
        });
    }
}
