<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerContactPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_contact_people', function (Blueprint $table) {
            $table->id('customer_id');
            $table->integer('employee_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('category')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->string('remarks')->nullable();
            $table->enum('status',["Active","Inactive","Pending","Cencle","Delete"]);
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
        Schema::dropIfExists('customer_contact_people');
    }
}
