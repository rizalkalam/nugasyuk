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
        Schema::create('murids', function (Blueprint $table) {
            // $table->string('id')->unique();
            $table->id();
            $table->string('nama_siswa');
            $table->string('email');
            $table->string('password');
            // $table->integer('nis')->primary();
            $table->string('foto_profile');
            $table->foreignId('kelas_id');
            // $table->foreignId('role_id');
            // $table->bigInteger('tugas_id')->nullable();
            // $table->foreignId('materi_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('murids');
    }
};
