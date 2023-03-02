<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string("ctns")->nullable();
            $table->string("quantity")->nullable();
            $table->string("invoice_no")->nullable();
            $table->date("invoice_date")->nullable();
            $table->string("sales_con_no")->nullable();
            $table->date("sales_con_date")->nullable();
            $table->string("exp_no")->nullable();
            $table->date("exp_no_date")->nullable();
            $table->enum('status',["waiting","booking"]);
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
        Schema::dropIfExists('invoices');
    }
}
