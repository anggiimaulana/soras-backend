@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6">

        {{-- Stats --}}
        <div class="grid grid-cols-4 gap-5">
            @foreach ([['Total User', $stats['total_users'], 'text-blue-600 bg-blue-50', '👤'], ['Total Rekomendasi', $stats['total_recommendations'], 'text-green-600 bg-green-50', '📊'], ['Jenis Olahraga', $stats['total_exercises'], 'text-purple-600 bg-purple-50', '🏃'], ['Jenis Keluhan', $stats['total_complaints'], 'text-orange-600 bg-orange-50', '🩺']] as [$label, $value, $color, $icon])
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm text-gray-500">{{ $label }}</p>
                        <span class="text-xl">{{ $icon }}</span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-2 gap-6">

            {{-- Top Exercises --}}
            <div class="bg-white rounded-xl border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-900 mb-4">Top Olahraga Direkomendasikan</h2>
                <div class="space-y-3">
                    @forelse($topExercises as $i => $exercise)
                        <div class="flex items-center gap-3">
                            <span
                                class="w-6 h-6 rounded-full bg-primary-100 text-primary-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                {{ $i + 1 }}
                            </span>
                            <div class="flex-1">
                                <div class="flex justify-between items-center mb-1">
                                    <p class="text-sm font-medium text-gray-800">{{ $exercise->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $exercise->recommendation_details_count }}x</p>
                                </div>
                                @if ($topExercises->first()->recommendation_details_count > 0)
                                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                                        <div class="h-1.5 rounded-full bg-primary-400"
                                            style="width: {{ ($exercise->recommendation_details_count / $topExercises->first()->recommendation_details_count) * 100 }}%">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada data.</p>
                    @endforelse
                </div>
            </div>

            {{-- Latest Recommendations --}}
            <div class="bg-white rounded-xl border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-900 mb-4">Rekomendasi Terbaru</h2>
                <div class="space-y-3">
                    @forelse($latestRecommendations as $rec)
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-7 h-7 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-gray-600">
                                    {{ strtoupper(substr($rec->userProfile?->user?->name ?? '?', 0, 1)) }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 truncate">
                                    {{ $rec->userProfile?->user?->name ?? 'Unknown' }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $rec->primaryComplaint?->name }} • {{ $rec->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <span class="text-xs font-semibold text-primary-600">
                                {{ number_format($rec->final_score * 100, 0) }}%
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada data.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
