<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriticalPathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('critical_paths', function (Blueprint $table) {
            $table->id();
            $table->foreignId("po_id")->references("id")->on("manual_pos")->cascadeOnDelete();
            $table->foreignId("labdips_embellishment_id")->references("id")->on("lab_dips_embellishment_information")->cascadeOnDelete();
            $table->foreignId("bulk_fabric_information_id")->references("id")->on("bulk_fabric_information")->cascadeOnDelete();
            $table->foreignId("fabric_mill_id")->references("id")->on("mills")->cascadeOnDelete();
            $table->foreignId("sample_approval_id")->references("id")->on("sample_approval_information")->cascadeOnDelete();
            $table->foreignId("pp_meeting_id")->references("id")->on("pp_meetings")->cascadeOnDelete();
            $table->foreignId("production_information_id")->references("id")->on("production_information")->cascadeOnDelete();
            $table->foreignId("inspection_information_id")->references("id")->on("inspection_information")->cascadeOnDelete();
            $table->foreignId("sample_shipping_approvals_id")->references("id")->on("sample_shipping_approvals")->cascadeOnDelete();
            $table->foreignId("ex_factories_id")->references("id")->on("ex_factories")->cascadeOnDelete();
            $table->foreignId("payments_id")->references("id")->on("payments")->cascadeOnDelete();
            $table->string("lead_times");
            $table->enum('lead_type',["Regular","Short"]);
            $table->date("official_po_plan");
            $table->date("official_po_actual");
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
        Schema::dropIfExists('critical_paths');
    }
}
