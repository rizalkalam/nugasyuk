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
        Schema::create('pengumpulans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id');
            $table->string('link')->nullable();
            $table->string('file')->nullable();
            $table->enum('status', ['menunggu', 'selesai', 'belum_selesai'])->default('belum_selesai');
            $table->date('tanggal')->nullable();
            // $table->foreignId('kelas_id');
            $table->foreignId('murid_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulans');
    }
};
