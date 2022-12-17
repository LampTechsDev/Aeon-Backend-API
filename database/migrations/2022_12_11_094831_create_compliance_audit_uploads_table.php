<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplianceAuditUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compliance_audit_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId("complianceaudit_id")->references("id")->on("compliances")->cascadeOnDelete();
            $table->string("file_name");
            $table->string("file_url");
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
        Schema::dropIfExists('compliance_audit_uploads');
    }
}
