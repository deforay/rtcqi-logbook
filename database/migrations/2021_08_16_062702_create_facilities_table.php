<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->integer('facility_id', true);
            $table->string('facility_name', 50)->nullable();
            $table->string('facility_latitude', 50)->nullable();
            $table->string('facility_longitude', 50)->nullable();
            $table->string('facility_address1')->nullable();
            $table->string('facility_address2', 50)->nullable();
            $table->string('facility_city', 20)->nullable();
            $table->string('facility_state', 20)->nullable();
            $table->string('facility_postal_code', 20)->nullable();
            $table->string('facility_country', 20)->nullable();
            $table->string('facility_region', 20)->nullable();
            $table->string('contact_name', 50)->nullable();
            $table->string('contact_email', 20)->nullable();
            $table->string('contact_phoneno', 20)->nullable();
            $table->string('facility_status', 20)->default('active')->comment('1 = Site is active, 0 deleted but present in database as som');
            $table->dateTime('updated_on')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('created_on');
            $table->integer('created_by');
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
        Schema::dropIfExists('facilities');
    }
}
