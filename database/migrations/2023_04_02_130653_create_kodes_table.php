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
        Schema::create('kodes', function (Blueprint $table) {
            $table->id();
            $table->string('kode_guru')->unique();
            $table->string('nama_mapel');
            $table->foreignId('guru_id');
            $table->enum('status_mapel', ['produktif', 'normadaf', 'bk']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kodes');
    }
};
