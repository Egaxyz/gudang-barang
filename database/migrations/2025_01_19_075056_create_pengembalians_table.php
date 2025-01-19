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
            $table->string('pb_id', 20);
            $table->integer('user_id');
            $table->dateTime('kembali_tgl');
            $table->enum('kembali_sts', ['0','1']);

            $table->foreign('pb_id')->references('pb_id')->on('peminjaman');
            $table->foreign('user_id')->references('user_id')->on('pengguna');
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