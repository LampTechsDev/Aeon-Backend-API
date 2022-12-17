<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualPosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_pos', function (Blueprint $table) {
            $table->id();
            $table->integer("buyer_id");
            $table->integer("vendor_id");
            $table->text("note");
            $table->text("terms_conditions");
            $table->date("first_delivery_date");
            $table->date("second_shipment_date");
            $table->date("vendor_po_date");
            $table->double("current_buyer_po_price");
            $table->double("vendor_po_price");
            $table->double("accessorize_price");
            $table->string("plm_no");
            $table->text("description");
            $table->string("fabric_quality");
            $table->string("fabric_content");
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
        Schema::dropIfExists('manual_pos');
    }
}
