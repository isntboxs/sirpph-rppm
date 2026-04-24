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
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tema_id')->constrained('tema')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('bentuk_kegiatan_id')->constrained('bentuk_kegiatan')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('diusulkan_oleh')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name', 150);
            $table->text('deskripsi')->nullable();
            $table->string('foto_icon', 10)->default('🎨');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_kepala')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};
