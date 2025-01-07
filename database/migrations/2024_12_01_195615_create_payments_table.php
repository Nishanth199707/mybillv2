<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('plan_id'); // Foreign key reference (optional)
            $table->foreignId('user_id'); 
            $table->decimal('amount', 10, 2); // Amount with precision
            $table->string('transaction_id')->unique(); // Unique transaction ID
            $table->string('payment_status');
            $table->text('response_msg')->nullable(); // Response message
            $table->string('providerReferenceId')->nullable(); // Reference ID from the provider
            $table->string('merchantOrderId')->nullable(); // Merchant's order ID
            $table->string('checksum')->nullable(); // Checksum for verification
            $table->timestamps(); // Created_at and Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
