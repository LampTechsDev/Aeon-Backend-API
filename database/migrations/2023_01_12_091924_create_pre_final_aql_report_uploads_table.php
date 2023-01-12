<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreFinalAqlReportUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_final_aql_report_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId("inspection_information_id")->references("id")->on("inspection_information")->cascadeOnDelete();
            $table->string("file_name");
            $table->string("file_url");
            $table->string("type");
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
        Schema::dropIfExists('pre_final_aql_report_uploads');
    }
}
