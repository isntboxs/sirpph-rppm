<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan_aspek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('aspek_perkembangan_id')->constrained('aspek_perkembangan')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unique(['kegiatan_id', 'aspek_perkembangan_id'], 'uq_kegiatan_aspek');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_aspek');
    }
};
