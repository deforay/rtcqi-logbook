<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllowedTestkitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allowed_testkits', function (Blueprint $table) {
            $table->integer('test_kit_no');
            $table->integer('testkit_id')->index('testkit_id');
            $table->primary(['test_kit_no', 'testkit_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allowed_testkits');
    }
}
