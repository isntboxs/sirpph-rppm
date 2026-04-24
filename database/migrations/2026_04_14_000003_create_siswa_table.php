<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('kelas_id');
            // $table->unsignedInteger('ortu_id')->nullable();
            $table->foreignId('ortu_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('name', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->timestamps();

            $table->foreign('kelas_id')
                ->references('id')
                ->on('kelas')
                ->onUpdate('cascade')
                ->onDelete('restrict');


            // $table->foreign('ortu_id')
            //     ->references('id')
            //     ->on('users')
            //     ->onUpdate('cascade')
            //     ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['ortu_id']);
        });
        Schema::dropIfExists('siswa');
    }
};
