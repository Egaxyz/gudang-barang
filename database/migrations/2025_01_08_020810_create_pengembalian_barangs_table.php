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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->string('kembali_id', 20)->primary();
            $table->string('pb_id', 20)->nullable();
            $table->string('user_id',10)->nullable();
            $table->dateTime('kembali_tgl')->nullable();
            $table->string('kembali_sts', 2)->nullable();

            $table->foreign('pb_id')->references('pb_id')->on('peminjaman');
            $table->foreign('user_id')->references('user_id')->on('penggunas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};