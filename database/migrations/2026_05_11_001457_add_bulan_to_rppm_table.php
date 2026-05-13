<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rppm', function (Blueprint $table) {
            $table->tinyInteger('bulan')->unsigned()->nullable()->after('minggu_ke');
            $table->smallInteger('tahun')->unsigned()->nullable()->after('bulan');
        });
    }

    public function down(): void
    {
        Schema::table('rppm', function (Blueprint $table) {
            //
        });
    }
};
