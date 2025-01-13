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
            $table->string('user_hak', 2)->nullable();
            $table->string('user_sts', 2)->nullable();
            
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