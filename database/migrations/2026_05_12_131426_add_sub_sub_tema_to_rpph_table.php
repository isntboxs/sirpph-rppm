<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rpph', function (Blueprint $table) {
            $table->string('sub_sub_tema', 150)
                ->nullable()
                ->after('hari');
        });
    }

    public function down(): void
    {
        Schema::table('rpph', function (Blueprint $table) {
            $table->dropColumn('sub_sub_tema');
        });
    }
};
