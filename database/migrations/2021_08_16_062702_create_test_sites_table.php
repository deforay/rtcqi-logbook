<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_sites', function (Blueprint $table) {
            $table->integer('ts_id', true);
            $table->string('site_id', 100)->nullable();
            $table->string('site_name', 50)->nullable();
            $table->string('site_latitude', 100)->nullable();
            $table->string('site_longitude', 100)->nullable();
            $table->string('site_address1', 50)->nullable();
            $table->string('site_address2', 50)->nullable();
            $table->string('site_postal_code', 20)->nullable()->index('site_postal_code');
            $table->string('site_city', 20)->nullable();
            $table->string('site_state', 20)->nullable();
            $table->string('site_country', 20)->nullable();
            $table->integer('updated_by');
            $table->dateTime('updated_on')->nullable();
            $table->string('test_site_status', 10)->nullable()->default('active')->comment('1 = Site is active, 0 deleted but present in database as som');
            $table->date('created_on')->nullable();
            $table->integer('created_by');
            $table->integer('new field')->nullable();
            $table->integer('facility_id')->nullable()->index('facility_id');
            $table->integer('provincesss_id')->nullable()->index('provincesss_id');
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
        Schema::dropIfExists('test_sites');
    }
}
