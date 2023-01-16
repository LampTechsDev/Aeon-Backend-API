<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_information', function (Blueprint $table) {
            $table->id();
            $table->string("po_number");
            $table->integer("po_id");
            $table->date("cutting_date_plan");
            $table->date("cutting_date_actual");
            $table->date("embellishment_plan");
            $table->date("embellishment_actual");
            $table->date("sewing_start_date_plan");
            $table->date("sewing_start_date_actual");
            $table->date("sewing_complete_date_plan");
            $table->date("sewing_complete_date_actual");
            $table->date("washing_complete_date_plan");
            $table->date("washing_complete_date_actual");
            $table->date("finishing_complete_date_plan");
            $table->date("finishing_complete_date_actual");
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
        Schema::dropIfExists('production_information');
    }
}
