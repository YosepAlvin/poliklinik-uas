<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('poli', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('nama_poli');
            $table->enum('status', ['aktif','nonaktif'])->default('aktif')->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('poli', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'status']);
        });
    }
};
