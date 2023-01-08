<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleApprovalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_approval_information', function (Blueprint $table) {
            $table->id();
            $table->date("development_photo_sample_sent_plan");
            $table->date("development_photo_sample_sent_actual");
            $table->text("development_photo_sample_dispatch_details");
            $table->date("fit_approval_plan");
            $table->date("fit_approval_actual");
            $table->text("fit_sample_dispatch_details");
            $table->date("fit_sample_dispatch_sending_date");
            $table->string("fit_sample_dispatch_aob_number");
            $table->date("size_set_approval_plan");
            $table->date("size_set_approval_actual");
            $table->text("size_set_sample_dispatch_details");
            $table->date("size_set_sample_dispatch_sending_date");
            $table->string("size_set_sample_dispatch_aob_number");
            $table->date("pp_approval_plan");
            $table->date("pp_approval_actual");
            $table->text("pp_sample_dispatch_details");
            $table->date("pp_sample_sending_date");
            $table->date("pp_sample_courier_aob_number");
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
        Schema::dropIfExists('sample_approval_information');
    }
}
