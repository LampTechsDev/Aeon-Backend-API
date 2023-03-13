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
            $table->string("po_number");
            $table->integer("po_id");
            $table->date("development_photo_sample_sent_plan");
            $table->date("development_photo_sample_sent_plan_buyer");
            $table->date("development_photo_sample_sent_actual");
            $table->text("development_photo_sample_dispatch_details")->nullable();
            $table->date("development_photo_sample_dispatch_sending_date")->nullable();
            $table->string("development_photo_sample_dispatch_awb_number")->nullable();
            $table->date("development_photo_sample_dispatch_review_meeting")->nullable();
            $table->date("fit_sample_review_meeting")->nullable();
            $table->date("size_set_sample_review_meeting")->nullable();
            $table->date("pp_sample_review_meeting")->nullable();
            $table->date("fit_approval_plan");
            $table->date("fit_approval_plan_buyer");
            $table->date("fit_approval_actual");
            $table->text("fit_sample_dispatch_details")->nullable();
            $table->date("fit_sample_dispatch_sending_date")->nullable();
            $table->string("fit_sample_dispatch_aob_number")->nullable();
            $table->date("size_set_approval_plan");
            $table->date("size_set_approval_plan_buyer");
            $table->date("size_set_approval_actual");
            $table->text("size_set_sample_dispatch_details")->nullable();
            $table->date("size_set_sample_dispatch_sending_date")->nullable();
            $table->string("size_set_sample_dispatch_aob_number")->nullable();
            $table->date("pp_approval_plan");
            $table->date("pp_approval_plan_buyer");
            $table->date("pp_approval_actual");
            $table->text("pp_sample_dispatch_details")->nullable();
            $table->date("pp_sample_sending_date")->nullable();
            $table->date("pp_sample_courier_aob_number")->nullable();
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
