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
        Schema::create('penggunas', function (Blueprint $table) {
            $table->string('user_id',10)->primary();
            $table->string('user_nama',50)->nullable();
            $table->string('user_pass', 32)->nullable();
            $table->string('role', 30)->nullable();
            $table->enum('user_sts', ['0','1'])->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
 public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};