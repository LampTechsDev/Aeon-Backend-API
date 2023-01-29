<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadPosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_pos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("supplier_id")->nullable()->references("id")->on("suppliers");
            $table->foreignId("customer_id")->nullable()->references("id")->on("customers");
            $table->boolean("is_read")->default(false);
            $table->date("issue_date")->nullable();
            $table->date("due_date")->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('upload_pos');
    }
}
