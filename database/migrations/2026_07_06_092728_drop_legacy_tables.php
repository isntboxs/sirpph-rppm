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
        Schema::dropIfExists('komentar_portofolio');
        Schema::dropIfExists('portofolio_aspek');
        Schema::dropIfExists('portofolio');
        
        Schema::dropIfExists('rpph');
        Schema::dropIfExists('rppm_kegiatan');
        
        Schema::dropIfExists('kegiatan_alat');
        Schema::dropIfExists('kegiatan_aspek');
        Schema::dropIfExists('kegiatan');
        
        Schema::dropIfExists('alat_bahan');
        Schema::dropIfExists('bentuk_kegiatan');
        Schema::dropIfExists('aspek_perkembangan');
        
        Schema::dropIfExists('prosem');
        
        if (Schema::hasTable('rppm')) {
            Schema::table('rppm', function (Blueprint $table) {
                if (Schema::hasColumn('rppm', 'model_pembelajaran')) {
                    $table->dropColumn('model_pembelajaran');
                }
                if (Schema::hasColumn('rppm', 'bulan')) {
                    $table->dropColumn('bulan');
                }
                if (Schema::hasColumn('rppm', 'tahun')) {
                    $table->dropColumn('tahun');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down migration for dropped legacy tables
    }
};
