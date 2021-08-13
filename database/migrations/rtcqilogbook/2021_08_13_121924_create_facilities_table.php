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
            $table->integer('facility_id')->autoIncrement();
            $table->string('facility_name')->nullable();
            $table->string('facility_latitude')->nullable();
            $table->string('facility_longitude')->nullable();
            $table->string('facility_address1')->nullable();
            $table->string('facility_address2')->nullable();
            $table->string('facility_city')->nullable();
            $table->string('facility_state')->nullable();
            $table->string('facility_postal_code')->nullable();
            $table->string('facility_country')->nullable();
            $table->string('facility_region')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phoneno')->nullable();
            $table->string('facility_status')->default('active')->comment('1 = Site is active, 0 deleted but present in database as som');
            $table->dateTime('created_on')->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('updated_on')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('provincesss_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->foreign('provincesss_id')->references('provincesss_id')->on('provinces');
            $table->foreign('district_id')->references('district_id')->on('districts');
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
