<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId("critical_path_id")->references("id")->on("critical_paths")->cascadeOnDelete();
            $table->date("booking_date");
            $table->date("cargo_delivery_date");
            $table->string("so_number");
            $table->foreignId("bank_id")->references("id")->on("banks")->cascadeOnDelete();
            $table->text("cf_agent_details");
            $table->string("lc_no");
            $table->string("invoice_no");
            $table->string("exp_no");
            $table->text("description_goods");
            $table->foreignId("freight_id")->references("id")->on("freight_management")->cascadeOnDelete();
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
        Schema::dropIfExists('shipping_books');
    }
}
