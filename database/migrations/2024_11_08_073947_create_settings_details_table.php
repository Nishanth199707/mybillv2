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
        Schema::create('setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id'); 
            $table->foreignId('user_id');
            $table->foreignId('settings_id')->constrained('settings')->onDelete('cascade'); 
            $table->string('vehicle_no')->nullable(); 
            $table->string('logo_image')->nullable(); 
            $table->text('logo_text')->nullable();
            $table->string('description_image')->nullable(); 
            $table->text('description_text')->nullable(); 
            $table->string('signature_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_details');
    }
};
