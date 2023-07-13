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
        Schema::create('pesans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('percakapan_id');
            $table->foreign('percakapan_id')->references('id')->on('percakapans');

            $table->unsignedBigInteger('guru_id');
            $table->foreign('guru_id')->references('id')->on('gurus');

            $table->unsignedBigInteger('murid_id');
            $table->foreign('murid_id')->references('id')->on('murids');

            $table->text('isi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesans');
    }
};
