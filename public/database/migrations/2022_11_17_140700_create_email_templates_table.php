<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string("email_type");
            $table->string("subject");
            $table->boolean("mail_send")->default(true);
            $table->string("cc")->nullable();
            $table->text("template")->nullable();
            $table->foreignId("created_by")->nullable()->references("id")->on("admins");
            $table->foreignId("updated_by")->nullable()->references("id")->on("admins");
            $table->softDeletes();

            $table->string('remarks')->nullable();
            $table->enum('admin_status',["Active","Inactive","Pending","Cencle","Delete"]);
            $table->string('create_by')->nullable();
            $table->date('create_date')->nullable();
            $table->string('modified_by')->nullable();
            $table->date('modified_date')->nullable();
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
        Schema::dropIfExists('email_templates');
    }
}
