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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'spesialisasi')) {
                $table->string('spesialisasi')->nullable()->after('is_jaga');
            }
            if (!Schema::hasColumn('users', 'unit')) {
                $table->string('unit')->nullable()->after('spesialisasi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['spesialisasi', 'unit']);
        });
    }
};
