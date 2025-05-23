<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini

class AddStatusApprovedToUserModules extends Migration
{
    public function up()
    {
        // Langkah 1: Tambahkan kolom baru
        Schema::table('user_modules', function (Blueprint $table) {
            $table->enum('status_approved', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('status');
        });

        // Langkah 2: Migrasi data existing setelah kolom ditambahkan
        // Pastikan kolom sudah ada dan dikenali oleh database
        DB::table('user_modules')
            ->where('status', 'active')
            ->update([
                'status_approved' => 'approved',
                'status' => 'active' // tetap pertahankan, ini untuk mencegah perubahan status jika tidak diinginkan
            ]);
    }

    public function down()
    {
        Schema::table('user_modules', function (Blueprint $table) {
            $table->dropColumn('status_approved');
        });
    }
}