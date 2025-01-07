<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
{
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id'); 
            $table->foreignId('user_id'); 
            $table->string('service_no');
            $table->string('customer_name');
            $table->string('address');
            $table->string('phone');
            $table->text('complaint_remark');
            $table->string('imei')->nullable();
            $table->string('mobile_pin');
            $table->string('phone_condition');
            $table->enum('battery', ['yes', 'no']);
            $table->string('battery_details')->nullable();
            $table->enum('sim', ['yes', 'no']);
            $table->string('sim_details')->nullable();
            $table->decimal('estimated_amount', 8, 2);
            $table->date('estimated_delivery_date');
            $table->string('model')->nullable();
            $table->string('cash_received')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('repairs');
    }
}
