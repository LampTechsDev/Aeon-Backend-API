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
            $table->foreignId("vendor_id")->references("id")->on("vendors")->cascadeOnDelete();
            $table->foreignId("buyer_id")->references("id")->on("customers")->cascadeOnDelete();
            $table->foreignId("supplier_id")->references("id")->on("suppliers")->cascadeOnDelete();
            $table->foreignId("manufacturer_id")->references("id")->on("vendor_manufacturers")->cascadeOnDelete();
            $table->foreignId("customer_department_id")->references("id")->on("customer_departments")->cascadeOnDelete();
            $table->foreignId("season_id")->nullable()->references("id")->on("seasons")->cascadeOnDelete();
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
        Schema::dropIfExists('manual_pos');
    }
}
