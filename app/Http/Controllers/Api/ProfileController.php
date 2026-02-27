<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\StoreProfileRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\ComplaintResource;
use App\Http\Resources\GoalResource;
use App\Http\Resources\UserProfileResource;
use App\Models\Complaint;
use App\Models\Goal;
use App\Services\Recommendation\AgeClassifier;
use App\Services\Recommendation\BMICalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // GET /api/complaints — public, untuk dropdown Flutter
    public function complaints(): JsonResponse
    {
        $complaints = Complaint::orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data'    => ComplaintResource::collection($complaints),
        ]);
    }

    // GET /api/goals — public, untuk dropdown Flutter
    public function goals(): JsonResponse
    {
        $goals = Goal::orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data'    => GoalResource::collection($goals),
        ]);
    }

    // GET /api/profile
    public function show(Request $request): JsonResponse
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        $profile = $user?->profile;

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profil belum dibuat.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => new UserProfileResource($profile),
        ]);
    }

    // POST /api/profile
    public function store(StoreProfileRequest $request): JsonResponse
    {
        // Cek apakah profil sudah ada
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        if ($user?->profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profil sudah ada. Gunakan PUT untuk mengupdate.',
            ], 422);
        }

        $profile = $user->profile()->create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil dibuat.',
            'data'    => new UserProfileResource($profile),
        ], 201);
    }

    // PUT /api/profile
    public function update(UpdateProfileRequest $request)
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        $profile = $user->profile;

        $data = $request->validated();

        // Hitung ulang BMI
        $heightM = $data['height_cm'] / 100;
        $bmi     = round($data['weight_kg'] / ($heightM * $heightM), 2);

        // Hitung ulang age_category — pastikan ini dipanggil!
        $ageCategory = app(AgeClassifier::class)->categorize($data['age']);
        $bmiCategory = app(BMICalculator::class)->categorize($bmi);

        $profile->update([
            ...$data,
            'bmi'          => $bmi,
            'bmi_category' => $bmiCategory,
            'age_category' => $ageCategory,  // ← pastikan ada
        ]);

        return $this->successResponse(
            new UserProfileResource($profile->fresh()),
            'Profil berhasil diupdate.'
        );
    }
}
