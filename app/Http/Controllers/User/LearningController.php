<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Character;

 

class LearningController extends Controller
{
    public function index() {
        $characters = Character::orderBy('hsk_level')->limit(20)->get();
        
        return view('user.learning.index', compact('characters'));
    }

    public function show(Character $character) {
        return view('user.learning.show', compact('character'));
    }
}
