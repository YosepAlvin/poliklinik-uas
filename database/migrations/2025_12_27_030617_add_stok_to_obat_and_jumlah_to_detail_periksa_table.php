<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('obat', 'stok')) {
            Schema::table('obat', function (Blueprint $table) {
                $table->integer('stok')->default(0)->after('harga');
            });
        }

        if (!Schema::hasColumn('detail_periksa', 'jumlah')) {
            Schema::table('detail_periksa', function (Blueprint $table) {
                $table->integer('jumlah')->default(1)->after('obat_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->dropColumn('stok');
        });

        Schema::table('detail_periksa', function (Blueprint $table) {
            $table->dropColumn('jumlah');
        });
    }
};
