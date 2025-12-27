<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            if (!Schema::hasColumn('pasien', 'alamat')) {
                $table->string('alamat')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('pasien', 'tgl_lahir')) {
                $table->date('tgl_lahir')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('pasien', 'no_rm')) {
                $table->string('no_rm', 20)->nullable()->unique()->after('tgl_lahir');
            }
            if (!Schema::hasColumn('pasien', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'tgl_lahir', 'no_rm', 'user_id']);
        });
    }
};
