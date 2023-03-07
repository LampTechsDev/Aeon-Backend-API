<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkFabricInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_fabric_information', function (Blueprint $table) {
            $table->id();
            $table->string("po_number");
            $table->integer("po_id");
            $table->date("fabric_ordered_plan");
            $table->date("fabric_ordered_plan_buyer");
            $table->date("fabric_ordered_actual");
            $table->date("bulk_fabric_knit_down_approval_plan");
            $table->date("bulk_fabric_knit_down_approval_plan_buyer");
            $table->date("bulk_fabric_knit_down_approval_actual");
            $table->text("bulk_fabric_knit_down_dispatch_details")->nullable();
            $table->date("bulk_fabric_knit_down_dispatch_sending_date")->nullable();
            $table->string("bulk_fabric_knit_down_dispatch_aob_number")->nullable();
            $table->date("bulk_yarn_fabric_inhouse_plan");
            $table->date("bulk_yarn_fabric_inhouse_plan_buyer");
            $table->date("bulk_yarn_fabric_inhouse_actual");
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
        Schema::dropIfExists('bulk_fabric_information');
    }
}
