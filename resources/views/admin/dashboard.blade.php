@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6">

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ([['Total User', $stats['total_users'], 'text-blue-600 dark:text-blue-400'], ['Total Rekomendasi', $stats['total_recommendations'], 'text-violet-600 dark:text-violet-400'], ['Jenis Olahraga', $stats['total_exercises'], 'text-emerald-600 dark:text-emerald-400'], ['Jenis Keluhan', $stats['total_complaints'], 'text-amber-600 dark:text-amber-400']] as [$label, $value, $text])
                <div
                    class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] p-5 transition-colors">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ $label }}</p>
                    <p class="text-3xl font-extrabold {{ $text }}">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            {{-- Top Exercises --}}
            <div class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] p-5">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-semibold text-gray-900 dark:text-white text-sm">Top Olahraga Direkomendasikan</h2>
                    <span class="text-xs text-gray-400 dark:text-gray-500">Top {{ $topExercises->count() }}</span>
                </div>
                <div class="space-y-3.5">
                    @forelse($topExercises as $i => $exercise)
                        <div class="flex items-center gap-3">
                            <span
                                class="w-6 h-6 rounded-full text-xs font-bold flex items-center justify-center flex-shrink-0"
                                style="background:linear-gradient(135deg,rgba(139,92,246,0.2),rgba(99,102,241,0.15));color:#a78bfa;">
                                {{ $i + 1 }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-1.5">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">
                                        {{ $exercise->name }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 ml-2 flex-shrink-0">
                                        {{ $exercise->recommendation_details_count }}x</p>
                                </div>
                                @if ($topExercises->first()->recommendation_details_count > 0)
                                    <div class="w-full bg-gray-100 dark:bg-white/[0.06] rounded-full h-1.5">
                                        <div class="h-1.5 rounded-full"
                                            style="width:{{ ($exercise->recommendation_details_count / $topExercises->first()->recommendation_details_count) * 100 }}%;background:linear-gradient(90deg,#6366f1,#8b5cf6)">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <p class="text-sm text-gray-400 dark:text-gray-600">Belum ada data.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Latest Recommendations --}}
            <div class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] p-5">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-semibold text-gray-900 dark:text-white text-sm">Rekomendasi Terbaru</h2>
                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $latestRecommendations->count() }}
                        terakhir</span>
                </div>
                <div class="space-y-3">
                    @forelse($latestRecommendations as $rec)
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 text-white font-bold"
                                style="font-size:12px;background:linear-gradient(135deg,#818cf8,#6366f1);">
                                {{ strtoupper(substr($rec->userProfile?->user?->name ?? '?', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 dark:text-gray-200 truncate">
                                    {{ $rec->userProfile?->user?->name ?? 'Unknown' }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 truncate">
                                    {{ $rec->primaryComplaint?->name ?? '-' }} &bull;
                                    {{ $rec->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <span class="text-xs font-semibold px-2 py-1 rounded-lg flex-shrink-0"
                                style="background:rgba(99,102,241,0.1);color:#818cf8;">
                                {{ number_format($rec->final_score * 100, 0) }}%
                            </span>
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <p class="text-sm text-gray-400 dark:text-gray-600">Belum ada data.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
