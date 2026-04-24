<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            // $table->unsignedInteger('guru_id')->nullable();
            $table->foreignId('guru_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('name', 50);
            $table->timestamps();

            // $table->foreign('guru_id')
            //       ->references('id')
            //       ->on('users')
            //       ->onUpdate('cascade')
            //       ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
        });
        Schema::dropIfExists('kelas');
    }
};
