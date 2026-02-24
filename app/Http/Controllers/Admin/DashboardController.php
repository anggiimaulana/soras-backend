<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Exercise;
use App\Models\Goal;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users'           => User::where('is_admin', false)->count(),
            'total_recommendations' => Recommendation::count(),
            'total_exercises'       => Exercise::count(),
            'total_complaints'      => Complaint::count(),
        ];

        // Top 5 olahraga paling sering direkomendasikan
        $topExercises = Exercise::withCount('recommendationDetails')
            ->orderByDesc('recommendation_details_count')
            ->limit(5)
            ->get();

        // 10 rekomendasi terbaru
        $latestRecommendations = Recommendation::with([
            'userProfile.user',
            'primaryComplaint',
            'goal',
        ])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'topExercises',
            'latestRecommendations',
        ));
    }
}
