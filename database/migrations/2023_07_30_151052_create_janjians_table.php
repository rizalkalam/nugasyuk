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
        Schema::create('janjians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id');
            $table->foreignId('murid_id');
            $table->foreignId('jam_id');
            $table->foreignId('lokasi_id');
            $table->text('topik');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('janjians');
    }
};
