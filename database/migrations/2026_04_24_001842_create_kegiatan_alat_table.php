<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan_alat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('alat_bahan_id')->constrained('alat_bahan')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unique(['kegiatan_id', 'alat_bahan_id'], 'uq_kegiatan_alat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_alat');
    }
};
