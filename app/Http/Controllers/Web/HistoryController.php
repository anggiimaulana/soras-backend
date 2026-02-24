<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Recommendation\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function __construct(
        private readonly RecommendationService $service,
    ) {}

    public function index(Request $request): View
    {
        $profile = $request->user()->profile;
        $history = collect();

        if ($profile) {
            $history = $this->service->getHistory($profile->id);
        }

        return view('pages.history.index', compact('history'));
    }
}
