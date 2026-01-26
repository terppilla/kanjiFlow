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
        Character::insert([
            [
                'character' => '学',
                'piniyn' => 'xué',
                'meaning' => 'учить',
                'audio' => '...'
            ],
            [
                'character' => '日',
                'piniyn' => 'rì',
                'meaning' => 'день',
                'audio' => '...'
            ]
        ]);
    }
}
