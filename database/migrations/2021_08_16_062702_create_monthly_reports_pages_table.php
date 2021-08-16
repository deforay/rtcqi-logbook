<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyReportsPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_reports_pages', function (Blueprint $table) {
            $table->integer('mrp_id', true);
            $table->integer('mr_id')->index('mr_id');
            $table->string('page_no', 50)->nullable()->index('page_no');
            $table->date('start_test_date')->nullable();
            $table->date('end_test_date')->nullable();
            $table->string('lot_no_1', 200)->nullable();
            $table->date('expiry_date_1')->nullable();
            $table->integer('test_1_kit_id')->nullable();
            $table->integer('test_1_reactive')->nullable();
            $table->integer('test_1_nonreactive')->nullable();
            $table->integer('test_1_invalid')->nullable();
            $table->string('lot_no_2', 100)->nullable();
            $table->date('expiry_date_2')->nullable();
            $table->integer('test_2_kit_id')->nullable();
            $table->integer('test_2_reactive')->nullable();
            $table->integer('test_2_nonreactive')->nullable();
            $table->integer('test_2_invalid')->nullable();
            $table->integer('test_3_kit_id')->nullable();
            $table->string('lot_no_3', 200)->nullable();
            $table->date('expiry_date_3')->nullable();
            $table->integer('test_3_reactive')->nullable();
            $table->integer('test_3_nonreactive')->nullable();
            $table->integer('test_3_invalid')->nullable()->index('test_3_invalid');
            $table->string('lot_no_4', 200)->nullable();
            $table->date('expiry_date_4')->nullable();
            $table->integer('test_4_kit_id')->nullable();
            $table->integer('test_4_reactive')->nullable();
            $table->integer('test_4_nonreactive')->nullable();
            $table->integer('test_4_invalid')->nullable();
            $table->integer('final_positive')->nullable();
            $table->integer('final_negative')->nullable();
            $table->integer('final_undetermined')->nullable();
            $table->string('total_high_vl', 200)->nullable();
            $table->string('low_vl', 200)->nullable();
            $table->string('total_vl_not_reported', 200)->nullable();
            $table->string('recency_total_recent', 200)->nullable();
            $table->string('recency_total_negative', 100)->nullable();
            $table->string('recency_total_inconclusive', 200)->nullable();
            $table->string('recency_total_longterm', 200)->nullable();
            $table->integer('positive_percentage')->nullable();
            $table->string('positive_agreement', 11)->nullable();
            $table->string('overall_agreement', 200)->nullable();
            $table->integer('updated_by')->nullable()->index('updated_by');
            $table->dateTime('updated_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_reports_pages');
    }
}
