<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId("po_id")->references("id")->on("manual_pos");
            $table->string("total_order_qty")->nullable();
            $table->string("total_value")->nullable();
            $table->string("final_total_ship_qty")->nullable();
            $table->string("final_total_invoice_value")->nullable();
            $table->string("total_commission")->nullable();
            $table->string("aeon_benefit")->nullable();
            $table->string("remarks")->nullable();
            $table->enum('status',["Active","Inactive","Pending","Cencle","Delete"]);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_summaries');
    }
}
