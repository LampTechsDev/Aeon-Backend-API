<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleShippingApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_shipping_approvals', function (Blueprint $table) {
            $table->id();
            $table->string("po_number");
            $table->integer("po_id");
            $table->date("production_sample_approval_plan");
            $table->date("production_sample_approval_actual");
            $table->text("production_sample_dispatch_details")->nullable();
            $table->date("production_sample_dispatch_sending_date")->nullable();
            $table->string("production_sample_dispatch_aob_number")->nullable();
            $table->date("shipment_booking_with_acs_plan");
            $table->date("shipment_booking_with_acs_actual");
            $table->date("sa_approval_plan");
            $table->date("sa_approval_actual");
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
        Schema::dropIfExists('sample_shipping_approvals');
    }
}
