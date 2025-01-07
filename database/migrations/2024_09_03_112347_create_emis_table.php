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
        Schema::create('emis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('business_id')->constrained();
            $table->foreignId('sale_id')->constrained();
            $table->string('financier_name');
            $table->string('loan_no');
            $table->string('initial_payment');
            $table->string('emi_amount_paid')->nullable();
            $table->string('emi_amount_balance')->nullable();
            $table->string('emi')->nullable();
            $table->string('scheme')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emis');
    }
};
