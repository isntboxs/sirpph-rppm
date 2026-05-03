<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_tema', function (Blueprint $table) {
            $table->id();
            // $table->unsignedInteger('tema_id');
            $table->foreignId('tema_id')
                ->constrained('tema')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('sub_tema', function (Blueprint $table) {
            $table->dropForeign(['tema_id']);
        });
        Schema::dropIfExists('sub_tema');
    }
};
