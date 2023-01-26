<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriticalPathMasterFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('critical_path_master_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId("critical_path_id")->references("id")->on("critical_paths")->cascadeOnDelete();
            $table->foreignId("critical_path_departments_id")->nullable()->references("id")->on("critical_path_departments")->cascadeOnDelete();
            $table->string("file_name");
            $table->string("file_url");
            $table->string("type")->nullable();
            $table->foreignId('created_by')->nullable()->references("id")->on("admins");
            $table->foreignId('updated_by')->nullable()->references("id")->on("admins");
            $table->foreignId('deleted_by')->nullable()->references("id")->on("admins");
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
        Schema::dropIfExists('critical_path_master_files');
    }
}
