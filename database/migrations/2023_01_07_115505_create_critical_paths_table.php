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
