<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAndDropAndOrderColumnsToFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropForeign('facilities_ibfk_1');
            $table->dropColumn('provincesss_id');
            $table->dropForeign('facilities_ibfk_2');
            $table->dropColumn('district_id');
            $table->dropColumn('facility_state');
            $table->dropColumn('facility_region');
            $table->integer('facility_province')->nullable()->after('facility_address2');        
            $table->integer('facility_district')->nullable()->after('facility_province');
            $table->foreign('facility_province')->references('province_id')->on('provinces');
            $table->foreign('facility_district')->references('district_id')->on('districts');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facilities', function (Blueprint $table) {
            
        });
    }
}
