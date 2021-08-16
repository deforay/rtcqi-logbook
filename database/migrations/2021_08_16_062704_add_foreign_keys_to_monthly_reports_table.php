<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMonthlyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_reports', function (Blueprint $table) {
            $table->foreign('ts_id', 'monthly_reports_ibfk_1')->references('ts_id')->on('test_sites');
            $table->foreign('st_id', 'monthly_reports_ibfk_2')->references('st_id')->on('site_types');
            $table->foreign('provincesss_id', 'monthly_reports_ibfk_3')->references('provincesss_id')->on('provinces');
            $table->foreign('district_id', 'monthly_reports_ibfk_4')->references('district_id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_reports', function (Blueprint $table) {
            $table->dropForeign('monthly_reports_ibfk_1');
            $table->dropForeign('monthly_reports_ibfk_2');
            $table->dropForeign('monthly_reports_ibfk_3');
            $table->dropForeign('monthly_reports_ibfk_4');
        });
    }
}
