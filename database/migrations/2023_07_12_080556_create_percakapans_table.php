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
        Schema::create('percakapans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_one')->nullable();
            $table->foreign('user_one')->references('id')->on('gurus');

            $table->unsignedBigInteger('user_two')->nullable();
            $table->foreign('user_two')->references('id')->on('murids');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('percakapans');
    }
};
