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
        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_materi');
            $table->text('isi');
            $table->string('link')->nullable();
            $table->string('file')->nullable();
            $table->date('tanggal_dibuat')->nullable();
            // $table->year('tahun_mulai')->nullable();;
            // $table->year('tahun_selesai')->nullable();;
            $table->foreignId('mapel_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
