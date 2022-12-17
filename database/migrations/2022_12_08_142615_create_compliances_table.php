<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompliancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compliances', function (Blueprint $table) {
            $table->id();
            $table->string('factory_name');
            $table->string('factory_concern_person_name');
            $table->enum('status',["new","existing"]);
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('audit_name');
            $table->string('vendor_name');
            $table->string('audit_conducted_by');
            $table->date('audit_request_date')->nullable();
            $table->date('requirement_date')->nullable();
            $table->text('requirement_details');
            $table->text('note_remarks')->nullable();
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
        Schema::dropIfExists('compliances');
    }
}
