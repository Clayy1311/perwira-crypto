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
        // Pastikan kolom 'expiry_date' ditambahkan di metode up()
        Schema::table('user_modules', function (Blueprint $table) {
            // Ubah dari 'expires_at' ke 'expiry_date' sesuai nama kolom Anda
            // Gunakan 'timestamp' agar bisa menyimpan tanggal dan waktu, lebih fleksibel.
            $table->timestamp('expiry_date')->nullable()->after('status_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Di metode down(), Anda menghapus kolom yang ditambahkan di up()
        Schema::table('user_modules', function (Blueprint $table) {
           $table->dropColumn('expiry_date'); // Hapus kolom 'expiry_date'
        });
    }
};
