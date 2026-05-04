<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('last_study_date')->nullable();
            $table->unsignedInteger('study_streak')->default(0);
            $table->unsignedInteger('study_sessions_completed')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['last_study_date', 'study_streak', 'study_sessions_completed']);
        });
    }
};
