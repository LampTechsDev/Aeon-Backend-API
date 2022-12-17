<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFabricContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabric_contents', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("details");
            $table->string("status");
            $table->foreignId('created_by')->nullable()->references("id")->on("admins");
            $table->foreignId('updated_by')->nullable()->references("id")->on("admins");
            $table->foreignId('deleted_by')->nullable()->references("id")->on("admins");
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
        Schema::dropIfExists('fabric_contents');
    }
}
