<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWeightPoNoToManualPos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manual_pos', function (Blueprint $table) {
            $table->string("fabric_weight");
            $table->string("po_no")->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manual_pos', function (Blueprint $table) {
            Schema::dropIfExists('manual_pos');
        });
    }
}
