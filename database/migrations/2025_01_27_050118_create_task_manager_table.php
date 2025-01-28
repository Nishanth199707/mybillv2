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
        Schema::create('task_managers', function (Blueprint $table) {
            $table->id();
            $table->decimal('user_id');
            $table->decimal('business_id');
            $table->decimal('party');
            $table->decimal('product');
            $table->string('description',550);
            $table->string('status',50);
            $table->decimal('sub_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_managers');
    }
};
