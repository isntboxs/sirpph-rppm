<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('name', 100);
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->enum('role', ['admin', 'kepala', 'guru', 'ortu']);
            $table->tinyInteger('active')->default(1);
            $table->string('no_telp', 20)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
