<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMonthlyReportsPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_reports_pages', function (Blueprint $table) {
            $table->foreign('mr_id', 'monthly_reports_pages_ibfk_1')->references('mr_id')->on('monthly_reports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_reports_pages', function (Blueprint $table) {
            $table->dropForeign('monthly_reports_pages_ibfk_1');
        });
    }
}
