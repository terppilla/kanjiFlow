<?php

namespace Database\Seeders;

use App\Models\Character;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $json = file_get_contents(database_path('data/characters.json'));
       $data = json_decode($json, true);

       foreach ($data as $item) {
        Character::create([
          'character'  => $item['character'],
          'pinyin' => $item['pinyin'],
          'meaning' => $item['meaning'],
          'hsk_level' => $item['hsk_level'],
          'example_hanzi' => $item['example_hanzi'] ?? null,
          'example_pinyin' => $item['example_pinyin'] ?? null,
          'example_translation' => $item['example_translation'] ?? null,
          'audio_character' => null,
          'audio_example' => null,
        ]);
       }
    }
}
