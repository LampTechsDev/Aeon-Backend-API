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
        Schema::dropIfExists('manual_po_item_details');
    }
}
