<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where('is_admin', false)
            ->with(['profile'])
            ->withCount('recommendations')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(int $id): View
    {
        $user = User::where('is_admin', false)
            ->with([
                'profile',
                'profile.recommendations' => fn($q) => $q
                    ->with('primaryComplaint', 'goal')
                    ->latest()
                    ->limit(5),
            ])
            ->withCount('recommendations')
            ->findOrFail($id);

        $profileId = $user->profile?->id;

        // ── Keluhan PALING SERING dipilih user (dari history rekomendasi) ──────
        $topComplaints = collect();

        if ($profileId) {
            // Primary complaint: tiap rekomendasi punya 1 primary complaint
            $primaryFreq = DB::table('recommendations')
                ->join('complaints', 'recommendations.primary_complaint_id', '=', 'complaints.id')
                ->where('recommendations.user_profile_id', $profileId)
                ->whereNotNull('recommendations.primary_complaint_id')
                ->select(
                    'complaints.id',
                    'complaints.name',
                    DB::raw('COUNT(*) as frequency'),
                    DB::raw("'primary' as complaint_type")
                )
                ->groupBy('complaints.id', 'complaints.name')
                ->orderByDesc('frequency')
                ->get();

            // Secondary complaint: dari user_complaints is_primary = false per profile
            $secondaryFreq = DB::table('user_complaints')
                ->join('complaints', 'user_complaints.complaint_id', '=', 'complaints.id')
                ->where('user_complaints.user_profile_id', $profileId)
                ->where('user_complaints.is_primary', false)
                ->select(
                    'complaints.id',
                    'complaints.name',
                    DB::raw('COUNT(*) as frequency'),
                    DB::raw("'secondary' as complaint_type")
                )
                ->groupBy('complaints.id', 'complaints.name')
                ->orderByDesc('frequency')
                ->get();

            // Merge: jika complaint muncul di keduanya, pakai tipe "primary" (lebih kuat)
            // dan jumlahkan frekuensinya
            $merged = collect();

            foreach ($primaryFreq as $p) {
                $merged->put($p->id, [
                    'id'        => $p->id,
                    'name'      => $p->name,
                    'frequency' => $p->frequency,
                    'type'      => 'primary',
                ]);
            }

            foreach ($secondaryFreq as $s) {
                if ($merged->has($s->id)) {
                    // Sudah ada dari primary — tambah frekuensi, tetap type primary
                    $existing = $merged->get($s->id);
                    $existing['frequency'] += $s->frequency;
                    $merged->put($s->id, $existing);
                } else {
                    $merged->put($s->id, [
                        'id'        => $s->id,
                        'name'      => $s->name,
                        'frequency' => $s->frequency,
                        'type'      => 'secondary',
                    ]);
                }
            }

            $topComplaints = $merged
                ->sortByDesc('frequency')
                ->take(6)
                ->values();
        }

        // ── Goal PALING SERING dipilih user (dari history rekomendasi) ──────────
        $topGoals = collect();

        if ($profileId) {
            $topGoals = DB::table('recommendations')
                ->join('goals', 'recommendations.goal_id', '=', 'goals.id')
                ->where('recommendations.user_profile_id', $profileId)
                ->whereNotNull('recommendations.goal_id')
                ->select(
                    'goals.id',
                    'goals.name',
                    DB::raw('COUNT(*) as frequency')
                )
                ->groupBy('goals.id', 'goals.name')
                ->orderByDesc('frequency')
                ->limit(5)
                ->get()
                ->map(fn($g) => [
                    'id'        => $g->id,
                    'name'      => $g->name,
                    'frequency' => $g->frequency,
                ]);
        }

        // Total rekomendasi (untuk hitung persentase frekuensi)
        $totalRecs = $user->recommendations_count;

        return view('admin.users.show', compact(
            'user',
            'topComplaints',
            'topGoals',
            'totalRecs'
        ));
    }
}
