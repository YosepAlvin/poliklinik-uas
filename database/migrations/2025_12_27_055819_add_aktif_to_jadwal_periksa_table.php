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
        Schema::table('jadwal_periksa', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_periksa', 'aktif')) {
                $table->boolean('aktif')->default(true)->after('jam_selesai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_periksa', function (Blueprint $table) {
            $table->dropColumn('aktif');
        });
    }
};
