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
        Schema::create('sale_return_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id');
            $table->foreignId('user_id');
            $table->foreignId('party_id');
            $table->foreignId('sale_return_id');
            $table->foreignId('product_id');
            $table->string('item_description');
            $table->string('rpqty');
            $table->string('qty');
            $table->string('gst')->nullable();
            $table->float('amount')->nullable();
            $table->float('discount')->default(0);
            $table->string('gstvaldata')->nullable();
            $table->string('total_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_return_details');
    }
};
