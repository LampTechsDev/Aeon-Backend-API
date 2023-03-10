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
            $table->foreignId("po_id")->nullable()->references("id")->on("manual_pos")->cascadeOnDelete();
            $table->string("ship_method");
            $table->string("inco_terms");
            $table->string("landing_port");
            $table->string("discharge_port");
            $table->string("country_of_origin");
            $table->date("ex_factor_date");
            $table->date("care_label_date");
            $table->foreignId('created_by')->nullable()->references("id")->on("admins");
            $table->foreignId('updated_by')->nullable()->references("id")->on("admins");
            $table->foreignId('deleted_by')->nullable()->references("id")->on("admins");
            $table->timestamps();
            $table->softDeletes();
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
