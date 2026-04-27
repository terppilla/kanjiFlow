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
        Schema::table('collection_character', function (Blueprint $table) {
            $table->dropUnique('collection_character_unique');
        });
    }
};
