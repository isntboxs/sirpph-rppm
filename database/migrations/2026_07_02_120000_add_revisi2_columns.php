<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rppm', function (Blueprint $table) {
            $table->date('tanggal_dibuat')->nullable()->after('minggu_ke');
            $table->text('kegiatan_pembuka')->nullable();
            $table->text('kegiatan_inti')->nullable();
            $table->text('recalling')->nullable();
            $table->text('kegiatan_penutup')->nullable();
            $table->text('rencana_penilaian')->nullable();
        });

        Schema::create('laporan_rpp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('rppm_id')->constrained('rppm')->onDelete('cascade');
            $table->date('tanggal')->nullable();
            $table->text('keterangan_singkat')->nullable();
            $table->string('status', 30)->default('draft'); // draft, pending, disetujui, dikembalikan
            $table->text('catatan_kepala')->nullable();
            $table->timestamps();
        });

        Schema::create('laporan_rpp_foto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_rpp_id')->constrained('laporan_rpp')->onDelete('cascade');
            $table->string('jenis', 50)->nullable(); // bersama_anak, hasil_karya
            $table->string('path', 255);
            $table->timestamps();
        });

        Schema::table('tema', function (Blueprint $table) {
            $table->text('alasan_edit')->nullable();
            $table->foreignId('edited_by')->nullable()->constrained('users')->onDelete('set null');
        });

        Schema::table('sub_tema', function (Blueprint $table) {
            $table->text('alasan_edit')->nullable();
            $table->foreignId('edited_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('sub_tema', function (Blueprint $table) {
            $table->dropForeign(['edited_by']);
            $table->dropColumn(['alasan_edit', 'edited_by']);
        });

        Schema::table('tema', function (Blueprint $table) {
            $table->dropForeign(['edited_by']);
            $table->dropColumn(['alasan_edit', 'edited_by']);
        });

        Schema::dropIfExists('laporan_rpp_foto');
        Schema::dropIfExists('laporan_rpp');

        Schema::table('rppm', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_dibuat',
                'kegiatan_pembuka',
                'kegiatan_inti',
                'recalling',
                'kegiatan_penutup',
                'rencana_penilaian'
            ]);
        });
    }
};
