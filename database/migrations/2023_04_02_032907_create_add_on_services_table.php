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
        Schema::create('add_on_services', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedBigInteger('room_types_id');
            $table->unsignedBigInteger('services_id');

            $table->foreign('room_types_id')
                  ->references('id')
                  ->on('room_types')
                  ->cascadeOnDelete();
                  
            $table->foreign('services_id')
                  ->references('id')
                  ->on('services');


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
        Schema::dropIfExists('add_on_services');
    }
};