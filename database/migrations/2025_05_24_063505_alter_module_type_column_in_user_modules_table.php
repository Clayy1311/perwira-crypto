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
        Schema::table('user_modules', function (Blueprint $table) {
            // Ubah tipe kolom module_type menjadi string dengan panjang yang cukup (misal 20 karakter)
            // Pastikan tidak ada data yang hilang jika sebelumnya ada nilai yang lebih panjang
            $table->string('module_type', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_modules', function (Blueprint $table) {
            // Jika Anda ingin mengembalikan ke ukuran semula saat rollback,
            // Anda perlu tahu ukuran aslinya. Misalnya, jika aslinya 10:
            // $table->string('module_type', 10)->change();
            // Atau jika tidak yakin dan ingin aman, bisa juga tidak melakukan apa-apa di down()
            // jika rollback tidak prioritas untuk perubahan ukuran ini.
        });
    }
};