<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rpph', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rppm_id')
                ->constrained('rppm')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->text('pembuka')->nullable();
            $table->text('inti')->nullable();
            $table->text('penutup')->nullable();

            $table->enum('status', ['draft', 'pending', 'disetujui', 'dikembalikan'])
                ->default('draft');

            $table->text('catatan_kepala')->nullable();

            // Satu RPPM hanya boleh punya satu RPPH per hari
            $table->unique(['rppm_id', 'hari'], 'uq_rpph_hari');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rpph');
    }
};
