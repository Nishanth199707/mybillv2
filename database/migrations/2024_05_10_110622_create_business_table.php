<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('logo')->nullable();
            $table->string('company_name');
            $table->string('gstavailable');
            $table->string('gstin')->nullable();
            $table->string('phone_no');
            $table->string('email');
            $table->text('address');
            $table->string('business_type');
            $table->string('business_category');
            $table->string('pincode');
            $table->string('state');
            $table->string('city');
            $table->string('country');
            $table->text('description')->nullable();
            $table->string('signature')->nullable();
            $table->string('gst_auth',225)->nullable();
            $table->json('auth_response')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business');
    }
};
