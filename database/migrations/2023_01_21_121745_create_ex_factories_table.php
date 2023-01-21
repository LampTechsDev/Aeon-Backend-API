<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExFactoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ex_factories', function (Blueprint $table) {
            $table->id();
            $table->string("po_number");
            $table->integer("po_id");
            $table->date("ex_factory_date_po");
            $table->date("revised_ex_factory_date");
            $table->date("actual_ex_factory_date");
            $table->string("shipped_units");
            $table->date("original_eta_sa_date");
            $table->date("revised_eta_sa_date");
            $table->string("forwarded_ref_vessel_name");
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
        Schema::dropIfExists('ex_factories');
    }
}
