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
        Schema::create('konsentrasi', function (Blueprint $table) {
            $table->integer('konsentrasi_id')->autoIncrement()->primary();
            $table->integer('jurusan_id');
            $table->string('konsentrasi', 20);

            $table->foreign('jurusan_id')->references('jurusan_id')->on('jurusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsentrasi');
    }
};