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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_guru');
            $table->string('email');
            $table->string('password');
            $table->integer('niy')->unique();
            $table->string('foto_profile');
            $table->foreignId('mapel_id');
            // $table->string('konfirmasi')->nullable();
            // $table->foreignId('role_id');
            // $table->foreignId('mapel2_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
