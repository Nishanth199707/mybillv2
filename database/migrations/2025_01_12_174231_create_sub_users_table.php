<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubUsersTable extends Migration
{
    public function up()
    {
        Schema::create('sub_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->json('permissions')->nullable(); 
            $table->string('usertype')->nullable(); 
            $table->json('is_email_verified')->default('1'); 
            $table->json('is_active')->default('1'); 
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_users');
    }
}
