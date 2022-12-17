<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualPoDeliveryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_po_delivery_details', function (Blueprint $table) {
            $table->id();
            $table->string("ship_method");
            $table->string("inco_terms");
            $table->string("landing_port");
            $table->string("discharge_port");
            $table->string("country_of_origin");
            $table->date("ex_factor_date");
            $table->date("care_label_date");
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
        Schema::dropIfExists('manual_po_delivery_details');
    }
}
