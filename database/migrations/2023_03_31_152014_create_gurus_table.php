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
            $table->string('niy')->unique();
            $table->string('nama_guru');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('foto_profile');
            $table->string('alamat');
            $table->string('nomor_tlp');
            $table->foreignId('kode_id')->nullable()->default(null)->unique();
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
