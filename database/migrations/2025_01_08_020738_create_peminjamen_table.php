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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->string('pb_id', 20)->primary();
            $table->integer('siswa_id');
            $table->dateTime('pb_tgl');
            $table->string('pb_no_siswa', 20);
            $table->string('pb_nama_siswa', 100);
            $table->dateTime('pb_harus_kembali_tgl');
            $table->enum('pb_stat', ['0','1']);

            $table->foreign('siswa_id')->references('siswa_id')->on('siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};