<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualPoItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_po_item_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("po_id")->references("id")->on("manual_pos")->cascadeOnDelete();
            $table->string("plm");
            $table->string("style_no");
            $table->string("colour");
            $table->integer("item_no");
            $table->string("size");
            $table->integer("qty_order");
            $table->integer("inner_qty");
            $table->integer("outer_case_qty");
            $table->double("supplier_price");
            $table->string("value");
            $table->double("selling_price");
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
        Schema::dropIfExists('manual_po_item_details');
    }
}
