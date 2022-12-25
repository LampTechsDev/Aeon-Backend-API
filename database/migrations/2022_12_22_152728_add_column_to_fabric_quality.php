<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToFabricQuality extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fabric_qualities', function (Blueprint $table) {
            $table->foreignId("fabric_content_id")->references("id")->on("fabric_contents");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fabric_qualities', function (Blueprint $table) {
            Schema::dropIfExists('fabric_qualities');
        });
    }
}
