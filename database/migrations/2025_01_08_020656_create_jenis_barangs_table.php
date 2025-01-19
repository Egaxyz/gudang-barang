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
        Schema::create('jenis_barang', function (Blueprint $table) {
            $table->integer('jns_brg_kode', 5)->autoIncrement()->primary();
            $table->string('jns_barang_nama', 50);
            $table->dateTime('tgl_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_barang');
    }
};