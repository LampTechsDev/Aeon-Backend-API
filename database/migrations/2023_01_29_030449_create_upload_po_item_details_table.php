<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadPoItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_po_item_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("upload_po_id")->nullable()->references("id")->on("upload_pos");
            $table->string("order_ln")->nullable();
            $table->string("ref_no")->nullable();
            $table->string("level_item")->nullable();
            $table->string("diff_name")->nullable();
            $table->string("diff_total")->nullable();
            $table->string("iten_no")->nullable();
            $table->string("item_description")->nullable();
            $table->string("vendor_ref_no")->nullable();
            $table->string("order_qty")->nullable();
            $table->string("inner_qty")->nullable();
            $table->string("outer_qty")->nullable();
            $table->string("supplier_cost")->nullable();
            $table->string("local_guarented_cost")->nullable();
            $table->string("selling_price")->nullable();
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
        Schema::dropIfExists('upload_po_item_details');
    }
}
