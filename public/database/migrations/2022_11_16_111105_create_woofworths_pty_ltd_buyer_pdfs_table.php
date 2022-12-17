<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoofworthsPtyLtdBuyerPdfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('woofworths_pty_ltd_buyer_pdfs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_no')->nullable();
            $table->string('supplier_name')->nullable();
            $table->bigInteger('supplier_referense_number')->nullable();
            $table->string('currency')->nullable();
            $table->string('terms')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('ship_method')->nullable();
            $table->string('inco_terms')->nullable();
            $table->string('lading_port')->nullable();
            $table->string('discharge_port')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->date('earliset_ship_date')->nullable();
            $table->date('latest_ship_date')->nullable();
            $table->bigInteger('ww_po_no')->nullable();
            $table->date('po_approval_date')->nullable();
            $table->date('print_date')->nullable();
            $table->string('department')->nullable();
            $table->string('comments')->nullable();
            $table->date('intro_store_date')->nullable();
            $table->date('chain_intake_date_nbd')->nullable();
            $table->string('initial_destination')->nullable();
            $table->string('final_destination')->nullable();
            $table->string('delivery_address')->nullable();
            $table->bigInteger('total_po_units')->nullable();
            $table->decimal('total_cost_value')->nullable();
            $table->decimal('total_selling_value_excl_vat')->nullable();
            $table->decimal('total_supplier_cost')->nullable();
            $table->decimal('average_cost_price')->nullable();
            $table->decimal('average_selling_price')->nullable();
            $table->double('margin_excl_vat')->nullable();
            $table->string('staff_number')->nullable();
            $table->string('user_name')->nullable();
            $table->dateTime('date')->nullable();


            $table->string('remarks')->nullable();
            $table->enum('status',["Active","Inactive","Pending","Cencle","Delete"]);
            $table->string('create_by')->nullable();
            $table->date('create_date')->nullable();
            $table->string('modified_by')->nullable();
            $table->date('modified_date')->nullable();
            $table->string('deleted_by')->nullable();
            $table->date('deleted_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('woofworths_pty_ltd_buyer_pdfs');
    }
}
