<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rpph_penilaian_poin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_id')
                ->constrained('rpph_penilaian')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->text('poin');
            $table->tinyInteger('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rpph_penilaian_poin');
    }
};
