<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rppm_kegiatan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rppm_id')
                ->constrained('rppm')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('kegiatan_id')
                ->constrained('kegiatan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->tinyInteger('urutan')->default(1);

            $table->unique(['rppm_id', 'kegiatan_id', 'hari'], 'uq_rppm_kegiatan_hari');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rppm_kegiatan');
    }
};
