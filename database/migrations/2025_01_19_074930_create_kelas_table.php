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
        Schema::create('kelas', function (Blueprint $table) {
            $table->integer('kelas_id')->autoIncrement()->primary();
            $table->enum('tingkatan',['X', 'XI', 'XII']);
            $table->integer('jurusan_id');
            $table->string('konsentrasi', 10);
            $table->integer('no_konsentrasi');

            $table->foreign('jurusan_id')->references('jurusan_id')->on('jurusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};