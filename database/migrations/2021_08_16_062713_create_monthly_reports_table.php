<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->integer('mr_id', true);
            $table->integer('ts_id')->index('ts_id')->comment('Site Name');
            $table->integer('st_id')->index('st_id');
            $table->string('site_unique_id', 100)->nullable();
            $table->integer('provincesss_id')->index('provincesss_id');
            $table->string('site_manager', 100)->nullable();
            $table->string('is_flc', 10)->default('no');
            $table->string('is_recency', 20)->default('no');
            $table->string('contact_no', 100)->nullable();
            $table->string('latitude', 100);
            $table->string('longitude', 200);
            $table->string('algorithm_type')->nullable();
            $table->date('date_of_data_collection');
            $table->string('reporting_month', 100);
            $table->integer('book_no')->default(0);
            $table->string('name_of_data_collector', 100)->nullable();
            $table->mediumText('signature')->nullable();
            $table->string('source', 100)->nullable();
            $table->string('added_by', 100)->nullable();
            $table->date('added_on')->nullable();
            $table->dateTime('last_modified_on')->nullable();
            $table->integer('district_id')->nullable()->index('district_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_reports');
    }
}
