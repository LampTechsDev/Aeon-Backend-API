<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pp_meetings', function (Blueprint $table) {
            $table->id();
            $table->string("po_number");
            $table->integer("po_id");
            $table->date("care_label_approval_plan");
            $table->date("care_label_approval_plan_buyer");
            $table->date("care_label_approval_actual");
            $table->date("material_inhouse_date_plan");
            $table->date("material_inhouse_date_plan_buyer");
            $table->date("material_inhouse_date_actual");
            $table->date("pp_meeting_date_plan");
            $table->date("pp_meeting_date_plan_buyer");
            $table->date("pp_meeting_date_actual");
            $table->date("pp_meeting_schedule");
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
        Schema::dropIfExists('pp_meetings');
    }
}
