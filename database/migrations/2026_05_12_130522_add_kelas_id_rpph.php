<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rpph', function (Blueprint $table) {
            $table->unsignedInteger('kelas_id')
                ->nullable()
                ->after('tanggal');

            $table->foreign('kelas_id')
                ->references('id')
                ->on('kelas')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('rpph', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn(['kelas_id']);
        });
    }
};
