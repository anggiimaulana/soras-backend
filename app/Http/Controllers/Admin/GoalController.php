<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Goal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GoalController extends Controller
{
    public function index(): View
    {
        $goals = Goal::with(['exercises' => function ($q) {
            $q->orderBy('name');
        }])->orderBy('name')->get();

        $exercises = Exercise::orderBy('name')->get();

        return view('admin.goals.index', compact('goals', 'exercises'));
    }

    public function updateScore(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'exercise_id'     => ['required', 'integer', 'exists:exercises,id'],
            'relevance_score' => ['required', 'numeric', 'min:0', 'max:1'],
        ]);

        $goal = Goal::findOrFail($id);

        $goal->exercises()->syncWithoutDetaching([
            $validated['exercise_id'] => [
                'relevance_score' => $validated['relevance_score'],
            ],
        ]);

        return back()->with('success', 'Nilai matriks berhasil diupdate!');
    }
}
