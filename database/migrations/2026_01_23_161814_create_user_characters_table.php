<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('character_id')->constrained()->cascadeOnDelete();

            $table->integer('interval')->default(1);
            $table->float('ease_factor')->default(2.5);
            $table->integer('repetitions')->default(0); 
            $table->integer('streak')->default(0);
            $table->integer('total_reviews')->default(0); 
            
            $table->dateTime('next_review_at')->nullable(); 
            $table->dateTime('last_reviewed_at')->nullable();
            
            $table->enum('last_result', ['again', 'hard', 'good', 'easy'])->nullable();
            $table->float('average_time')->nullable(); 
            $table->float('success_rate')->default(0);

            $table->boolean('is_learned')->default(false);
            $table->dateTime('learned_at')->nullable(); 
            $table->integer('days_studied')->default(0);

            $table->timestamps();

            $table->unique(['user_id', 'character_id']);
            $table->index(['user_id', 'next_review_at']);
            $table->index(['user_id', 'is_learned']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_characters');
    }
};