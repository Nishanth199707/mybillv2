<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditAccessesTable extends Migration
{
    public function up()
    {
        Schema::create('audit_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auditor_id');
            $table->unsignedBigInteger('target_user_id');
            $table->foreignId('user_id');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->foreign('auditor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('target_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_accesses');
    }
}
