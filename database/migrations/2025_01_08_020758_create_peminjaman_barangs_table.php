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
        Schema::create('peminjaman_barang', function (Blueprint $table) {
            $table->string('pbd_id', 20)->primary();
            $table->string('pb_id', 20)->nullable();
            $table->string('br_kode', 12)->nullable();
            $table->dateTime('pdb_tgl')->nullable();
            $table->enum('pdb_sts', ['dipinjam', 'tersedia'])->nullable();

           $table->foreign('br_kode')->references('br_kode')->on('barang_inventaris');
            $table->foreign('pb_id')->references('pb_id')->on('peminjaman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_barang');
    }
};