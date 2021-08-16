<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTestSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_sites', function (Blueprint $table) {
            $table->foreign('facility_id', 'test_sites_ibfk_1')->references('facility_id')->on('facilities');
            $table->foreign('provincesss_id', 'test_sites_ibfk_2')->references('provincesss_id')->on('provinces');
            $table->foreign('district_id', 'test_sites_ibfk_3')->references('district_id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_sites', function (Blueprint $table) {
            $table->dropForeign('test_sites_ibfk_1');
            $table->dropForeign('test_sites_ibfk_2');
            $table->dropForeign('test_sites_ibfk_3');
        });
    }
}
