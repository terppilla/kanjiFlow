<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collection_character', function (Blueprint $table) {
            $table->unique(['collection_id', 'character_id'], 'collection_character_unique');
        });
    }

    public function down(): void
    {
        // Уникальный (collection_id, character_id) может обслуживать FK на collection_id.
        Schema::table('collection_character', function (Blueprint $table) {
            $table->dropForeign(['collection_id']);
            $table->dropForeign(['character_id']);
        });

        Schema::table('collection_character', function (Blueprint $table) {
            $table->dropUnique('collection_character_unique');
        });

        Schema::table('collection_character', function (Blueprint $table) {
            $table->foreign('collection_id')->references('id')->on('collections')->cascadeOnDelete();
            $table->foreign('character_id')->references('id')->on('characters')->cascadeOnDelete();
        });
    }
};
