<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $profile = $request->user()->profile;

        return view('pages.profile.index', compact('profile'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'age'       => ['required', 'integer', 'min:5', 'max:100'],
            'gender'    => ['required', 'in:L,P'],
            'height_cm' => ['required', 'numeric', 'min:50', 'max:250'],
            'weight_kg' => ['required', 'numeric', 'min:10', 'max:300'],
        ]);

        $request->user()->profile()->create($validated);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profil berhasil dibuat!');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'age'       => ['sometimes', 'integer', 'min:5', 'max:100'],
            'gender'    => ['sometimes', 'in:L,P'],
            'height_cm' => ['sometimes', 'numeric', 'min:50', 'max:250'],
            'weight_kg' => ['sometimes', 'numeric', 'min:10', 'max:300'],
        ]);

        $request->user()->profile->update($validated);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profil berhasil diupdate!');
    }
}
