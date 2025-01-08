<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id(); 
            $table->string('otp', 6); 
            $table->string('otp_message')->nullable(); 
            $table->enum('otp_status', ['pending', 'verified', 'expired'])->default('pending'); 
            $table->string('mobileno'); 
            $table->text('response')->nullable(); 
            $table->timestamp('send_date')->nullable(); 
            $table->string('track_id')->nullable(); 
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->timestamp('expires_at')->nullable(); 
            $table->timestamps(); 

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('otps');
    }
}
