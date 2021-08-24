<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestSitesRenameAndDropOrderColumnsToTestSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_sites', function (Blueprint $table) {
            $table->dropForeign('test_sites_ibfk_2');
            $table->dropColumn('provincesss_id');
            $table->dropForeign('test_sites_ibfk_3');
            $table->dropColumn('district_id');
            $table->dropColumn('site_state');
            $table->dropColumn('new field');
            $table->integer('site_province')->nullable()->after('site_postal_code');        
            $table->integer('site_district')->nullable()->after('site_province');
            $table->foreign('site_province')->references('province_id')->on('provinces');
            $table->foreign('site_district')->references('district_id')->on('districts');
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
            //
        });
    }
}
