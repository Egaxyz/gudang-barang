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
        Schema::create('asal_barang', function (Blueprint $table) {
            $table->string('id_asal_br',10)->primary();
            $table->string('nama_perusahaan', 20);
            $table->string('jumlah_kirim', 10);
            $table->date('tgl_kirim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asal_barang');
    }
};