<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->boolean('is_builtin')->default(false)->after('user_id');
            $table->string('builtin_slug', 64)->nullable()->after('is_builtin');
            $table->unique(['user_id', 'builtin_slug']);
        });
    }

    public function down(): void
    {
        // Составной unique (user_id, builtin_slug) может быть единственным индексом,
        // которым пользуется FK на user_id — сначала снимаем ограничение внешнего ключа.
        Schema::table('collections', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('collections', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'builtin_slug']);
            $table->dropColumn(['is_builtin', 'builtin_slug']);
        });

        Schema::table('collections', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
