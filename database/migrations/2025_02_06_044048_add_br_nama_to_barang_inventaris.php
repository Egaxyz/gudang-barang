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
        Schema::table('barang_inventaris', function (Blueprint $table) {
            $table->string('br_nama', 20)->after('br_kode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_inventaris', function (Blueprint $table) {
            $table->dropColumn('br_nama');
        });
    }
};