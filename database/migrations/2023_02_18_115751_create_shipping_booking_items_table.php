<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingBookingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_booking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("shipping_booking_id")->references("id")->on("shipping_books")->cascadeOnDelete();
            $table->string("line_code");
            $table->string("no_of_packages");
            $table->string("no_of_pieces");
            $table->string("gross_wt");
            $table->string("authorized");
            $table->string("status");
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
        Schema::dropIfExists('shipping_booking_items');
    }
}
