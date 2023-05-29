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
        Schema::create('users', function (Blueprint $table) {
         $table->increments('id');
         $table->unsignedBigInteger('user_types_id');

         $table->string('name');
         $table->string('email')->unique();
         $table->string('phone_number')->nullable();
         $table->string('gender')->nullable();
         $table->timestamp('email_verified_at')->nullable();
         $table->string('password');
         $table->rememberToken();

         $table->foreign('user_types_id')
               ->references('id')
               ->on('user_types')
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
        Schema::dropIfExists('users');
    }
};