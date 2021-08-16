<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_kits', function (Blueprint $table) {
            $table->integer('tk_id', true);
            $table->string('test_kit_name_id', 50)->nullable();
            $table->string('test_kit_name_id_1', 50);
            $table->string('test_kit_name_short', 100)->nullable();
            $table->string('test_kit_name', 100);
            $table->string('test_kit_comments', 50)->nullable();
            $table->string('test_kit_manufacturer', 100);
            $table->date('test_kit_expiry_date')->nullable();
            $table->string('Installation_id', 50)->nullable()->index('Installation_id');
            $table->string('test_kit_status', 100)->default('active');
            $table->dateTime('updated_on')->nullable();
            $table->integer('updated_by')->nullable();
            $table->date('created_on');
            $table->integer('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_kits');
    }
}
