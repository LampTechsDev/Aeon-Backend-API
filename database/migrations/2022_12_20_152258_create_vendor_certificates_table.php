<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId("vendor_id")->nullable()->references("id")->on("vendors");
            $table->foreignId("global_certificate_id")->nullable()->references("id")->on("global_certificates");
            $table->string('certificate_name')->nullable();
            $table->string('certificate_logo')->nullable();
            $table->date('issue_date')->nullable();
            $table->dateTime('validity_start_date')->nullable();
            $table->dateTime('validity_end_date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->string('attachment')->nullable();
            $table->string('score')->nullable();


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
        Schema::dropIfExists('vendor_certificates');
    }
}
