<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_departments', function (Blueprint $table) {
            $table->id('customer_id');
            $table->string('department_name')->nullable();
            $table->string('image')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();

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
        Schema::dropIfExists('customer_departments');
    }
}
