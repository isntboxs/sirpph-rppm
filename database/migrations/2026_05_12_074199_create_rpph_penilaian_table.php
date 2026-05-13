<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rpph_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rpph_id')
                ->constrained('rpph')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('nama', 100);
            $table->tinyInteger('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rpph_penilaian');
    }
};
