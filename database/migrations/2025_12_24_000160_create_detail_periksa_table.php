<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_periksa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periksa_id')->constrained('periksa')->cascadeOnDelete();
            $table->foreignId('obat_id')->constrained('obat')->cascadeOnDelete();
            $table->unsignedInteger('harga')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_periksa');
    }
};

