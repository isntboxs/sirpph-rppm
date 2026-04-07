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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->string('kelas')->nullable()->after('password'); // A atau B (untuk guru)
            $table->string('hp')->nullable()->after('kelas');
            $table->boolean('is_aktif')->default(true)->after('hp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'kelas', 'hp', 'is_aktif']);
        });
    }
};
