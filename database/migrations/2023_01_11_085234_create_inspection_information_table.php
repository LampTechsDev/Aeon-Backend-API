<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_information', function (Blueprint $table) {
            $table->id();
            $table->string("po_number");
            $table->integer("po_id");
            $table->date("sewing_inline_inspection_date_plan");
            $table->date("sewing_inline_inspection_date_plan_buyer");
            $table->date("sewing_inline_inspection_date_actual");
            $table->string("inline_inspection_schedule");
            $table->date("finishing_inline_inspection_date_plan");
            $table->date("finishing_inline_inspection_date_plan_buyer");
            $table->date("finishing_inline_inspection_date_actual");
            $table->string("finishing_inline_inspection_schedule");
            $table->date("pre_final_date_plan");
            $table->date("pre_final_date_plan_buyer");
            $table->date("pre_final_date_actual");
            $table->string("pre_final_aql_schedule");
            $table->date("final_aql_date_plan");
            $table->date("final_aql_date_plan_buyer");
            $table->date("final_aql_date_actual");
            $table->date("final_aql_meeting_schedule");
            $table->string("final_aql_schedule");
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
        Schema::dropIfExists('inspection_information');
    }
}
