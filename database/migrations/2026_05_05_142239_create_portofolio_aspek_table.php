<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portofolio_aspek', function (Blueprint $table) {
            $table->id();

            $table->foreignId('portofolio_id')
                ->constrained('portofolio')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('aspek_id')
                ->constrained('aspek_perkembangan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique(['portofolio_id', 'aspek_id'], 'uq_porto_aspek');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio_aspek');
    }
};
