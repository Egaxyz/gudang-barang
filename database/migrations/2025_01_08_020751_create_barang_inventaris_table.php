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
        Schema::create('barang_inventaris', function (Blueprint $table) {
            $table->string('br_kode', 12)->primary();
            $table->string('jns_brg_kode', 5)->nullable();
            $table->string('user_id', 10)->nullable();
            $table->date('br_tgl_terima')->nullable();
            $table->dateTime('br_tgl_entry')->nullable();
            $table->string('br_status', 2)->nullable();

            $table->foreign('jns_brg_kode')->references('jns_brg_kode')->on('jenis_barang');
            $table->foreign('user_id')->references('user_id')->on('penggunas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_inventaris');
    }
};