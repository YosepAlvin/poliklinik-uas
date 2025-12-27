<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_periksa', function (Blueprint $table) {
            $table->renameColumn('harga', 'harga_saat_periksa');
        });
    }

    public function down(): void
    {
        Schema::table('detail_periksa', function (Blueprint $table) {
            $table->renameColumn('harga_saat_periksa', 'harga');
        });
    }
};
