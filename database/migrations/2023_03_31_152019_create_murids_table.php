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
            $table->string('nis');
            $table->string('nama_panggilan');
            $table->string('nama_siswa');
            $table->string('email');
            $table->string('password');
            $table->text('alamat');
            $table->string('foto_profile');
            $table->foreignId('kelas_id')->nullable();
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
