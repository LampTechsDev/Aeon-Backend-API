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

            $table->string('remarks')->nullable();
            $table->enum('admin_status',["Active","Inactive","Pending","Cencle","Delete"]);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('admins');
    }
}
