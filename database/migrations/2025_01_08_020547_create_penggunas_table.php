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
        Schema::create('siswa', function (Blueprint $table) {
    $table->integer('siswa_id')->autoIncrement()->primary();
    $table->integer('kelas_id');
    $table->integer('jurusan_id');
    $table->string('nama_siswa');
    $table->string('nis');
    $table->string('no_hp');

            $table->foreign('kelas_id')->references('kelas_id')->on('kelas');
            $table->foreign('jurusan_id')->references('jurusan_id')->on('jurusan');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};