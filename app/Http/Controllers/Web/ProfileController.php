<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class ProfileController extends Controller
{
    public function index()
    {
        // FIX #5: Selalu ambil fresh dari DB, jangan pakai cached auth()->user()->profile
        $profile = UserProfile::where('user_id', Auth::id())->first();

        return view('pages.profile.index', compact('profile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'age'       => 'required|integer|min:5|max:100',
            'gender'    => 'required|in:L,P',
            'height_cm' => 'required|numeric|min:50|max:250',
            'weight_kg' => 'required|numeric|min:10|max:300',
        ]);

        // Hitung BMI & kategori
        $bmi = round($validated['weight_kg'] / pow($validated['height_cm'] / 100, 2), 1);

        $bmiCategory = match (true) {
            $bmi < 18.5 => 'Underweight',
            $bmi < 25.0 => 'Normal',
            $bmi < 30.0 => 'Overweight',
            default     => 'Obesitas',
        };

        $ageCategory = match (true) {
            $validated['age'] < 13 => 'Anak-anak',
            $validated['age'] < 18 => 'Remaja',
            $validated['age'] < 50 => 'Dewasa',
            default                => 'Lansia',
        };

        UserProfile::create([
            'user_id'      => Auth::id(),
            'age'          => $validated['age'],
            'gender'       => $validated['gender'],
            'height_cm'    => $validated['height_cm'],
            'weight_kg'    => $validated['weight_kg'],
            'bmi'          => $bmi,
            'bmi_category' => $bmiCategory,
            'age_category' => $ageCategory,
        ]);

        // FIX #5: Redirect ke profile.index bukan dashboard
        // Agar $profile fresh dari DB dan langsung terlihat
        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil disimpan! BMI kamu: ' . $bmi . ' (' . $bmiCategory . ')');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'age'       => 'required|integer|min:5|max:100',
            'gender'    => 'required|in:L,P',
            'height_cm' => 'required|numeric|min:50|max:250',
            'weight_kg' => 'required|numeric|min:10|max:300',
        ]);

        // Hitung ulang BMI & kategori
        $bmi = round($validated['weight_kg'] / pow($validated['height_cm'] / 100, 2), 1);

        $bmiCategory = match (true) {
            $bmi < 18.5 => 'Underweight',
            $bmi < 25.0 => 'Normal',
            $bmi < 30.0 => 'Overweight',
            default     => 'Obesitas',
        };

        $ageCategory = match (true) {
            $validated['age'] < 13 => 'Anak-anak',
            $validated['age'] < 18 => 'Remaja',
            $validated['age'] < 50 => 'Dewasa',
            default                => 'Lansia',
        };

        // FIX #5: Update langsung ke DB — jangan pakai auth()->user()->profile (bisa stale)
        UserProfile::where('user_id', Auth::id())->update([
            'age'          => $validated['age'],
            'gender'       => $validated['gender'],
            'height_cm'    => $validated['height_cm'],
            'weight_kg'    => $validated['weight_kg'],
            'bmi'          => $bmi,
            'bmi_category' => $bmiCategory,
            'age_category' => $ageCategory,
        ]);

        // FIX #5: Redirect ke profile.index — data langsung fresh dari DB
        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui! BMI terbaru: ' . $bmi . ' (' . $bmiCategory . ')');
    }
}
