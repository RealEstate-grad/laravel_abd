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
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('image_id');
            $table->string('path');
            $table->string('registration');
            $table->unsignedBigInteger('realestate_id');
            $table->foreign('realestate_id')->references('id')->on('crealestate');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');


           
            


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image');
    }
};