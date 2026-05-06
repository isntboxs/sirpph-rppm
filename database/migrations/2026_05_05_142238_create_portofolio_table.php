<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portofolio', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('guru_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('rpph_id')
                ->nullable()
                ->constrained('rpph')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('kegiatan_id')
                ->nullable()
                ->constrained('kegiatan')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('foto_icon', 10)->default('📸');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio');
    }
};
