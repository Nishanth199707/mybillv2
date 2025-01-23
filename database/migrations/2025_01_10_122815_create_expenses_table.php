<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_ref');
            $table->decimal('exp_type');
            $table->decimal('user_id');
            $table->date('dateofexpense');
            $table->decimal('amount', 10, 2);
            $table->string('cash_type');
            $table->string('description',500);
            $table->timestamps(); // This adds `created_at` and `updated_at` columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
