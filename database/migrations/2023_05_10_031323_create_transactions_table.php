<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_reservation_id');
            $table->unsignedBigInteger('guest_id');
            
            $table->float('amount');

            $table->foreign('room_reservation_id')
                  ->references('id')
                  ->on('room_reservations')
                  ->cascadeOnDelete();
                  
            $table->foreign('guest_id')
                  ->references('id')
                  ->on('guests')
                  ->cascadeOnDelete();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};