<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Exercise;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    // Tampilkan matriks complaint vs exercise
    public function index(): View
    {
        $complaints = Complaint::with(['exercises' => function ($q) {
            $q->orderBy('name');
        }])->orderBy('name')->get();

        $exercises = Exercise::orderBy('name')->get();

        return view('admin.complaints.index', compact('complaints', 'exercises'));
    }

    // Update satu nilai di matriks
    public function updateScore(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'exercise_id'     => ['required', 'integer', 'exists:exercises,id'],
            'relevance_score' => ['required', 'numeric', 'min:-0.5', 'max:1'],
        ]);

        $complaint = Complaint::findOrFail($id);

        // Update pivot
        $complaint->exercises()->syncWithoutDetaching([
            $validated['exercise_id'] => [
                'relevance_score' => $validated['relevance_score'],
            ],
        ]);

        return back()->with('success', 'Nilai matriks berhasil diupdate!');
    }
}
