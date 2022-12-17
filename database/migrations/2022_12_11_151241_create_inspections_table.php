<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->text("meeting_name");
            $table->integer("po_number");
            $table->integer("vendor_id");
            $table->integer("factory_id");
            $table->integer("buyer_id");
            $table->integer("style_name_id");
            $table->integer("department_id");
            $table->string("inspection_name");
            $table->date("inspection_date");
            $table->date("inspection_time");
            $table->text("inspection_note");
            $table->string("status");
            $table->string("remarks")->nullable();
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
        Schema::dropIfExists('inspections');
    }
}
