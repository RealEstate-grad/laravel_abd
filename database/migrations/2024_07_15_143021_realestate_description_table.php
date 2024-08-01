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
        Schema::create('realestate_description', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('address');
            $table->integer('realestate_num');
            $table->string('space');
            $table->string('floor');
            $table->string('bathroom');
            $table->string('bedroom');
            $table->integer('price');
            $table->string('status');
            $table->string('owner_name');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('state');
            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')->references('id')->on('place');
            $table->timestamps();
        });
    }






    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realestate_description');
    }
};