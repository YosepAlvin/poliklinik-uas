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
        Schema::table('daftar_poli', function (Blueprint $table) {
            if (!Schema::hasColumn('daftar_poli', 'status')) {
                $table->enum('status', ['menunggu', 'diperiksa', 'selesai'])->default('menunggu')->after('no_antrian');
            }
            if (!Schema::hasColumn('daftar_poli', 'tanggal_periksa')) {
                $table->date('tanggal_periksa')->nullable()->after('jadwal_periksa_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_poli', function (Blueprint $table) {
            if (Schema::hasColumn('daftar_poli', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('daftar_poli', 'tanggal_periksa')) {
                $table->dropColumn('tanggal_periksa');
            }
        });
    }
};
