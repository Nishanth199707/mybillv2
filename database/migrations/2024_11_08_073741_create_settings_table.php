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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id'); 
            $table->foreignId('user_id'); 
            $table->string('ewaybill_no')->nullable(); 
            $table->string('purchase_order_date')->nullable(); 
            $table->string('purchase_order_number')->nullable(); 
            $table->string('vehicle_no')->nullable(); 
            $table->string('logo')->nullable(); 
            $table->string('emi')->nullable();
            $table->text('description')->nullable(); 
            $table->string('signature')->nullable(); 
            $table->string('shipping_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
