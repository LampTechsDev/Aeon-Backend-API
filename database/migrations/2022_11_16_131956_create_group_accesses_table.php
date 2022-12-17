<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->longText('group_access');

            $table->string('remarks')->nullable();
            $table->enum('status',["Active","Inactive","Pending","Cencle","Delete"]);
            $table->string('create_by')->nullable();
            $table->date('create_date')->nullable();
            $table->string('modified_by')->nullable();
            $table->date('modified_date')->nullable();
            $table->string('deleted_by')->nullable();
            $table->date('deleted_date')->nullable();
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
        Schema::dropIfExists('group_accesses');
    }
}
