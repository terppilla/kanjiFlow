<?php

namespace App\Http\Controllers;

use App\Services\GamificationService;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function __construct(
        private readonly GamificationService $gamification,
    ) {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = $this->gamification->achievementDisplayData(Auth::user());

        return view('user.achievements.index', $data);
    }
}
