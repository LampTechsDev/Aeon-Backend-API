<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoofworthsPtyLtdBuyerPdfOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('woofworths_pty_ltd_buyer_pdf_orders', function (Blueprint $table) {

            $table->id();
            $table->integer('order_line')->nullable();
            $table->string('quest_ref_no')->nullable();
            $table->string('tlevel_1_item')->nullable();
            $table->string('diff_1_name')->nullable();
            $table->integer('diff_1_total')->nullable();
            $table->string('item_no')->nullable();
            $table->string('item_description')->nullable();
            $table->string('vendor_product_no/ref_item_no')->nullable();
            $table->integer('qty_ordered')->nullable();
            $table->integer('inner_qty')->nullable();
            $table->integer('outer_case_qty')->nullable();
            $table->decimal('supplier_foreign_cost_price')->nullable();
            $table->decimal('local_guranteed_landed_cost_price')->nullable();
            $table->decimal('selling_price')->nullable();

            $table->string('remarks')->nullable();
            $table->enum('status',["Active","Inactive","Pending","Cencle","Delete"]);
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
        Schema::dropIfExists('woofworths_pty_ltd_buyer_pdf_orders');
    }
}
