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
                $table->string("vendor_name")->nullable();
                $table->string("manufacture_unit")->nullable();
                $table->foreignId("vendor_id")->nullable()->references("id")->on("vendors")->cascadeOnDelete();
                $table->foreignId("manufacturer_id")->nullable()->references("id")->on("vendor_manufacturers")->cascadeOnDelete();
                $table->string('factory_concern_name');
                $table->string('audit_name');
                $table->foreignId('audit_conducted_by')->nullable()->references("id")->on("admins");
                $table->text('audit_requirement_details');
                $table->date('audit_date');
                $table->date('audit_time');
                $table->string('email')->unique();
                $table->string('phone');
                $table->text('note')->nullable();
                $table->enum('type',["new","existing"]);
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
