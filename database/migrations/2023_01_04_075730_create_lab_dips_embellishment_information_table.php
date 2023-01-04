<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabDipsEmbellishmentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_dips_embellishment_information', function (Blueprint $table) {
            $table->id();
            $table->string("po_number");
            $table->integer("po_id");
            $table->date("colour_std_print_artwork_sent_to_supplier_plan");
            $table->date("colour_std_print_artwork_sent_to_supplier_actual");
            $table->date("lab_dip_approval_plan");
            $table->date("lab_dip_approval_actual");
            $table->text("lab_dip_dispatch_details");
            $table->date("lab_dip_dispatch_sending_date");
            $table->string("lab_dip_dispatch_aob_number");
            $table->date("embellishment_so_approval_plan");
            $table->date("embellishment_so_approval_actual");
            $table->text("embellishment_so_dispatch_details");
            $table->date("embellishment_so_dispatch_sending_date");
            $table->string("embellishment_so_dispatch_aob_number");
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
        Schema::dropIfExists('lab_dips_embellishment_information');
    }
}
