<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('builtin_collection_templates', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 64)->unique();
            $table->string('name');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('builtin_collection_character', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('builtin_collection_template_id');
            $table->unsignedBigInteger('character_id');
            $table->unsignedSmallInteger('sort_order')->default(0);

            /* Короткие имена: лимит MySQL ~64 символа на идентификатор */
            $table->foreign('builtin_collection_template_id', 'bcc_tpl_fk')
                ->references('id')
                ->on('builtin_collection_templates')
                ->cascadeOnDelete();
            $table->foreign('character_id', 'bcc_char_fk')
                ->references('id')
                ->on('characters')
                ->cascadeOnDelete();

            $table->unique(['builtin_collection_template_id', 'character_id'], 'bcc_tpl_char_uq');
        });

        $definitions = [
            'people' => [
                'name' => 'Люди и общение',
                'characters' => ['我', '你', '他', '她', '我们', '朋友', '家', '爱', '这', '那'],
            ],
            'verbs' => [
                'name' => 'Бытовые действия',
                'characters' => ['吃', '喝', '看', '听', '说', '学', '去', '来', '做', '买'],
            ],
            'time_scale' => [
                'name' => 'Время и размеры',
                'characters' => ['天', '月', '年', '时间', '大', '小', '多', '少', '上', '下'],
            ],
            'function_words' => [
                'name' => 'Базовые служебные слова',
                'characters' => ['有', '没', '在', '不', '很', '和', '也', '都', '中', '国'],
            ],
        ];

        $sort = 0;
        foreach ($definitions as $slug => $def) {
            $tid = DB::table('builtin_collection_templates')->insertGetId([
                'slug' => $slug,
                'name' => $def['name'],
                'sort_order' => $sort++,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $pos = 0;
            foreach ($def['characters'] as $glyph) {
                $cid = DB::table('characters')->where('character', $glyph)->value('id');
                if ($cid === null) {
                    continue;
                }
                DB::table('builtin_collection_character')->insert([
                    'builtin_collection_template_id' => $tid,
                    'character_id' => $cid,
                    'sort_order' => $pos++,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('builtin_collection_character');
        Schema::dropIfExists('builtin_collection_templates');
    }
};
