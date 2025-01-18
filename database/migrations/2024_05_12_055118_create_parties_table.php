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
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('business_id')->constrained();
            $table->string('transaction_type');
            $table->string('party_type');
            $table->string('state')->nullable();
            $table->string('name');
            $table->string('gstin')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->text('billing_address_1')->nullable();
            $table->text('billing_address_2')->nullable();
            $table->string('billing_pincode')->nullable();
            $table->text('shipping_address_1')->nullable();
            $table->text('shipping_address_2')->nullable();
            $table->string('shipping_pincode')->nullable();
            $table->float('opening_balance')->default(0);
            $table->string('gst_profile',225)->nullable();
            $table->json('gst_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
