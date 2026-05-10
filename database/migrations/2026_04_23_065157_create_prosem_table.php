<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prosem', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->unsignedBigInteger('tema_id');
            $table->unsignedBigInteger('sub_tema_id');
            $table->tinyInteger('minggu_ke');
            $table->enum('status', ['menunggu', 'valid', 'invalid'])
                ->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['tahun_ajaran_id', 'sub_tema_id'], 'uq_prosem_subtema');

            $table->unique(['tahun_ajaran_id', 'minggu_ke'], 'uq_prosem_minggu');

            $table->foreign('tahun_ajaran_id')
                ->references('id')->on('tahun_ajaran')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('tema_id')
                ->references('id')->on('tema')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('sub_tema_id')
                ->references('id')->on('sub_tema')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('prosem', function (Blueprint $table) {
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropForeign(['tema_id']);
            $table->dropForeign(['sub_tema_id']);
            $table->dropColumn(['status', 'catatan']);
        });
        Schema::dropIfExists('prosem');
    }
};
