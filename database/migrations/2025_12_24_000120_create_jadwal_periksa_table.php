<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_periksa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokter_id')->constrained('users')->cascadeOnDelete();
            $table->string('hari');
            $table->string('jam_mulai');
            $table->string('jam_selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_periksa');
    }
};

