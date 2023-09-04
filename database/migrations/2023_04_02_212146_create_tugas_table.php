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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tugas');
            $table->string('soal');
            $table->date('date');
            $table->date('deadline');
            $table->string('link_tugas')->nullable();
            $table->string('file_tugas')->nullable();
            $table->foreignId('mapel_id');
            $table->enum('status_tugas', ['lewat_deadline', 'dalam_deadline'])->default('dalam_deadline');
            $table->enum('input_jawaban', ['tidak', 'ya']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
