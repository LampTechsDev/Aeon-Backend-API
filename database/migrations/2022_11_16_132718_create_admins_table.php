<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            
            $table->id();
            $table->string('name');
            $table->string('bio')->nullable();
            $table->string('email')->unique();
            $table->foreignId("group_id")->references("id")->on("groups");
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('status')->default(true);
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();

            $table->string('remarks')->nullable();
            $table->enum('admin_status',["Active","Inactive","Pending","Cencle","Delete"]);
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
        Schema::dropIfExists('admins');
    }
}
