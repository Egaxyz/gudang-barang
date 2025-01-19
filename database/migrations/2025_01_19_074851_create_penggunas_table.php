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
        Schema::create('pengguna', function (Blueprint $table) {
    $table->integer('user_id')->autoIncrement()->primary(); // Auto increment
    $table->string('user_nama');
    $table->string('user_pass');
    $table->enum('role', ['superuser', 'admin', 'user']);
    $table->boolean('user_sts')->default(1);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};