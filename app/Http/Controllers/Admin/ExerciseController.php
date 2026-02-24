<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Exercise;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExerciseController extends Controller
{
    public function index(): View
    {
        $exercises = Exercise::with('complaints')->orderBy('name')->get();
        $complaints = Complaint::orderBy('name')->get();

        return view('admin.exercises.index', compact('exercises', 'complaints'));
    }

    public function edit(int $id): View
    {
        $exercise   = Exercise::with(['complaints', 'goals'])->findOrFail($id);
        $complaints = Complaint::orderBy('name')->get();

        return view('admin.exercises.edit', compact('exercise', 'complaints'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $exercise = Exercise::findOrFail($id);

        $validated = $request->validate([
            'name'               => ['required', 'string', 'max:255'],
            'category'           => ['required', 'string', 'max:255'],
            'impact_level'       => ['required', 'integer', 'in:1,2,3'],
            'intensity_level'    => ['required', 'integer', 'in:1,2,3'],
            'duration_min'       => ['required', 'integer', 'min:5'],
            'frequency_per_week' => ['required', 'integer', 'min:1', 'max:7'],
            'description'        => ['nullable', 'string'],
        ]);

        $exercise->update($validated);

        return redirect()
            ->route('admin.exercises.index')
            ->with('success', "Exercise '{$exercise->name}' berhasil diupdate!");
    }
}
