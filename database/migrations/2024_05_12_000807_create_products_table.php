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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('business_id');
            $table->string('image')->nullable();
            $table->string('item_type');
            $table->string('category');
            $table->foreignId('sub_category_id')->nullable();
            $table->string('item_code_barcode')->nullable();
            $table->string('item_name');
            $table->string('price_type')->nullable();
            $table->float('sale_price')->default(0);
            $table->float('gst_rate')->nullable()->default(0);
            $table->string('units')->nullable();
            $table->string('stock')->nullable()->default(0);
            $table->string('purchase_type')->nullable();
            $table->float('purchase_price')->default(0);
            $table->string('hsn_code')->nullable();
            $table->text('description')->nullable();
            $table->string('imei')->default('no');
            $table->float('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
