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
        Schema::table('sub_tema', function (Blueprint $table) {
            $table->integer('minggu_ke')->default(1)->after('name');
        });

        // Backfill minggu_ke
        $temas = \Illuminate\Support\Facades\DB::table('sub_tema')->select('tema_id')->distinct()->pluck('tema_id');
        foreach ($temas as $temaId) {
            $subTemas = \Illuminate\Support\Facades\DB::table('sub_tema')->where('tema_id', $temaId)->orderBy('id')->get();
            $mingguKe = 1;
            foreach ($subTemas as $st) {
                \Illuminate\Support\Facades\DB::table('sub_tema')->where('id', $st->id)->update(['minggu_ke' => $mingguKe]);
                $mingguKe++;
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_tema', function (Blueprint $table) {
            $table->dropColumn('minggu_ke');
        });
    }
};
