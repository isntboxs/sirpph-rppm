<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prosem', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->unsignedInteger('tema_id');
            $table->unsignedInteger('sub_tema_id');
            $table->tinyInteger('minggu_ke');
            $table->timestamps();

            // Satu sub tema hanya boleh muncul sekali per tahun ajaran
            $table->unique(['tahun_ajaran_id', 'sub_tema_id'], 'uq_prosem_subtema');

            // Satu nomor minggu hanya boleh ada sekali per tahun ajaran
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
        });
        Schema::dropIfExists('prosem');
    }
};
