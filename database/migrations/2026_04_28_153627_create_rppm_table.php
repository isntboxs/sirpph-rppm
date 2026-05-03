<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rppm', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('sub_tema_id')
                ->constrained('sub_tema')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('minggu_ke');
            $table->string('model_pembelajaran', 100)->nullable();
            $table->text('tujuan')->nullable();
            $table->text('capaian')->nullable();

            $table->enum('status', ['draft', 'pending', 'disetujui', 'dikembalikan'])
                ->default('draft');

            $table->text('catatan_kepala')->nullable();

            $table->unique(
                ['guru_id', 'tahun_ajaran_id', 'sub_tema_id'],
                'uq_rppm_guru_subtema'
            );

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rppm');
    }
};
