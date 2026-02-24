<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user    = $request->user();
        $profile = $user->profile;

        // Statistik ringkas
        $totalRecommendations = 0;
        $latestRecommendation = null;

        if ($profile) {
            $totalRecommendations = Recommendation::where(
                'user_profile_id',
                $profile->id
            )->count();

            $latestRecommendation = Recommendation::where(
                'user_profile_id',
                $profile->id
            )
                ->with(['details.exercise', 'primaryComplaint', 'goal'])
                ->latest()
                ->first();
        }

        return view('pages.dashboard', compact(
            'user',
            'profile',
            'totalRecommendations',
            'latestRecommendation',
        ));
    }
}
