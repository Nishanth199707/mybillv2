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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('party');
            $table->foreignId('business_id');
            $table->foreignId('user_id');
            $table->foreignId('party_id');
            $table->string('invoice_date');
            $table->string('invoice_no');
            $table->float('discount')->default(0);


            $table->float('taxable28Amount')->nullable();
            $table->float('taxable18Amount')->nullable();
            $table->float('taxable12Amount')->nullable();
            $table->float('taxable5Amount')->nullable();
            $table->float('taxable0Amount')->nullable();

            $table->float('totalAmountDisplay')->nullable();
            $table->float('tax_amount_28_cgst')->nullable();
            $table->float('tax_amount_28_sgst')->nullable();
            $table->float('tax_amount_18_cgst')->nullable();
            $table->float('tax_amount_18_sgst')->nullable();
            $table->float('tax_amount_12_cgst')->nullable();
            $table->float('tax_amount_12_sgst')->nullable();
            $table->float('tax_amount_5_cgst')->nullable();
            $table->float('tax_amount_5_sgst')->nullable();
            $table->float('tax_amount')->nullable();
            $table->float('net_amount');
            $table->float('cash_received')->nullable();
            $table->string('totQues');
            $table->string('cash_type');
            $table->string('bill_type');

            $table->string('purchase_order_date')->nullable();
            $table->string('purchase_order_number')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('ewayBillNo',225)->nullable();
            $table->json('ebillresponse')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
