<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoPictureGarmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_picture_garments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("po_id")->references("id")->on("manual_pos")->cascadeOnDelete();
            $table->string("file_name");
            $table->string("file_url");
            $table->enum('type',["mannual","po_conversion"]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('po_picture_garments');
    }
}
