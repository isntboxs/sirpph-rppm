<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspek_perkembangan', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('emote', 10);
            $table->string('warna', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspek_perkembangan');
    }
};
