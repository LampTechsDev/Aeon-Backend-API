<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_profiles', function (Blueprint $table) {
            $table->id('vendor_id');
            $table->string('factory_profile_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();

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
        Schema::dropIfExists('vendor_profiles');
    }
}
