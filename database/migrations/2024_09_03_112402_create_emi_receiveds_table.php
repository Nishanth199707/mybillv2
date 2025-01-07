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
        Schema::create('emi_receiveds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('business_id')->constrained();
            $table->foreignId('sale_id')->constrained();
            $table->foreignId('financier_id')->constrained();
            $table->string('loan_no')->nullable();           
            $table->string('paid_date')->nullable();
            $table->float('credit')->nullable()->default(0);
            $table->float('debit')->nullable()->default(0);
            $table->string('payment_type');
            $table->string('mode_of_payment')->nullable();
            $table->string('receipt_type')->nullable();
            $table->string('transaction_number')->nullable();
            $table->string('collection_date')->nullable();
            $table->float('opening_balance')->default(0);
            $table->float('closing_balance')->default(0);
            $table->string('status')->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emi_receiveds');
    }
};
