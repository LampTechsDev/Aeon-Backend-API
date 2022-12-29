<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorProfileAttachFileUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_profile_attach_file_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId("vendor_profile_id")->references("id")->on("vendor_profiles");
            $table->string("file_name");
            $table->string("file_url");

            $table->string('remarks')->nullable();
            $table->enum('status',["Active","Inactive","Pending","Cencle","Delete"]);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

            $table->timestamps();
            $table->string('deleted_by')->nullable();
            $table->date('deleted_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_profile_attach_file_uploads');
    }
}
