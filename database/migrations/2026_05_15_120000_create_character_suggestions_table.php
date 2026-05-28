<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('character_suggestions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('collection_id')->nullable()->constrained()->nullOnDelete();
    $table->string('search_query', 255)->nullable();
    $table->text('words');
    $table->text('note')->nullable();
    $table->string('status', 20)->default('pending');
    $table->timestamp('processed_at')->nullable();
    $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
    $table->timestamps();

    $table->index(['status', 'created_at']);
});
    }

    public function down(): void
    {
        Schema::dropIfExists('character_suggestions');
    }
};
