@extends('layouts.app')
@section('title', 'Hasil Rekomendasi')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Hasil Rekomendasi</h1>
                <p class="text-gray-500 mt-1">{{ $recommendation->created_at->format('d F Y, H:i') }}</p>
            </div>
            <a href="{{ route('recommendation.create') }}" class="btn-secondary text-sm">
                + Rekomendasi Baru
            </a>
        </div>

        {{-- Context Card --}}
        <div class="card bg-primary-50 border-primary-100">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-primary-600 font-medium uppercase tracking-wide">Keluhan Utama</p>
                    <p class="font-semibold text-gray-900 mt-1">
                        {{ $recommendation->primaryComplaint->name }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-primary-600 font-medium uppercase tracking-wide">Tujuan</p>
                    <p class="font-semibold text-gray-900 mt-1">
                        {{ $recommendation->goal->name }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-primary-600 font-medium uppercase tracking-wide">Confidence</p>
                    <p class="font-semibold text-gray-900 mt-1">
                        {{ number_format($recommendation->confidence, 1) }}%
                    </p>
                </div>
                <div>
                    <p class="text-xs text-primary-600 font-medium uppercase tracking-wide">Top Score</p>
                    <p class="font-semibold text-gray-900 mt-1">
                        {{ number_format($recommendation->final_score * 100, 1) }}%
                    </p>
                </div>
            </div>
        </div>

        {{-- Top 3 Recommendations --}}
        <div class="space-y-4">
            @foreach ($recommendation->details as $detail)
                @php
                    $rankConfig = match ($detail->rank_order) {
                        1 => [
                            'bg' => 'bg-yellow-50 border-yellow-200',
                            'badge' => 'bg-yellow-100 text-yellow-700',
                            'label' => '🥇 Terbaik',
                        ],
                        2 => [
                            'bg' => 'bg-gray-50 border-gray-200',
                            'badge' => 'bg-gray-200 text-gray-600',
                            'label' => '🥈 Alternatif 1',
                        ],
                        3 => [
                            'bg' => 'bg-orange-50 border-orange-100',
                            'badge' => 'bg-orange-100 text-orange-700',
                            'label' => '🥉 Alternatif 2',
                        ],
                        default => [
                            'bg' => 'bg-white border-gray-200',
                            'badge' => 'bg-gray-100 text-gray-600',
                            'label' => '#' . $detail->rank_order,
                        ],
                    };
                @endphp

                <div class="border rounded-xl p-5 {{ $rankConfig['bg'] }}">

                    {{-- Header --}}
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $rankConfig['badge'] }}">
                                {{ $rankConfig['label'] }}
                            </span>
                            <h3 class="text-lg font-bold text-gray-900">
                                {{ $detail->exercise->name }}
                            </h3>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900">
                                {{ number_format($detail->score * 100, 1) }}%
                            </p>
                            <p class="text-xs text-gray-400">Match Score</p>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                        <div class="h-2 rounded-full bg-primary-500 transition-all"
                            style="width: {{ number_format($detail->score * 100, 1) }}%"></div>
                    </div>

                    {{-- Exercise Info --}}
                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div class="text-center p-3 bg-white rounded-lg">
                            <p class="text-lg font-bold text-gray-900">{{ $detail->exercise->duration_min }}'</p>
                            <p class="text-xs text-gray-400">Durasi</p>
                        </div>
                        <div class="text-center p-3 bg-white rounded-lg">
                            <p class="text-lg font-bold text-gray-900">{{ $detail->exercise->frequency_per_week }}x</p>
                            <p class="text-xs text-gray-400">Per Minggu</p>
                        </div>
                        <div class="text-center p-3 bg-white rounded-lg">
                            <p class="text-lg font-bold text-gray-900">
                                {{ ['', 'Low', 'Medium', 'High'][$detail->exercise->impact_level] }}
                            </p>
                            <p class="text-xs text-gray-400">Impact</p>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if ($detail->exercise->description)
                        <p class="text-sm text-gray-600 mb-4">{{ $detail->exercise->description }}</p>
                    @endif

                    {{-- Score Breakdown --}}
                    @if ($detail->scoreBreakdown)
                        <details class="group">
                            <summary
                                class="text-sm font-medium text-primary-600 cursor-pointer hover:text-primary-700 list-none flex items-center gap-1">
                                <svg class="w-4 h-4 transition-transform group-open:rotate-90" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                Lihat Breakdown Skor
                            </summary>
                            <div class="mt-3 grid grid-cols-5 gap-2">
                                @foreach ([['P', 'Primary', $detail->scoreBreakdown->score_primary, 'bg-red-100 text-red-700'], ['S', 'Secondary', $detail->scoreBreakdown->score_secondary, 'bg-orange-100 text-orange-700'], ['G', 'Goal', $detail->scoreBreakdown->score_goal, 'bg-blue-100 text-blue-700'], ['B', 'BMI', $detail->scoreBreakdown->score_bmi, 'bg-purple-100 text-purple-700'], ['A', 'Usia', $detail->scoreBreakdown->score_age, 'bg-green-100 text-green-700']] as [$abbr, $label, $score, $color])
                                    <div class="text-center p-2 rounded-lg bg-white border border-gray-100">
                                        <div
                                            class="w-7 h-7 rounded-full {{ $color }} flex items-center justify-center mx-auto mb-1">
                                            <span class="text-xs font-bold">{{ $abbr }}</span>
                                        </div>
                                        <p class="text-sm font-bold text-gray-900">{{ number_format($score * 100, 0) }}%
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $label }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    @endif

                </div>
            @endforeach
        </div>

        {{-- Disclaimer --}}
        <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-500 text-center">
            ⚠️ Rekomendasi ini bersifat informatif. Konsultasikan dengan tenaga medis profesional sebelum memulai program
            olahraga baru.
        </div>

        {{-- Actions --}}
        <div class="flex gap-3">
            <a href="{{ route('history.index') }}" class="btn-secondary flex-1 text-center">
                Lihat Semua Riwayat
            </a>
            <a href="{{ route('recommendation.create') }}" class="btn-primary flex-1 text-center">
                Rekomendasi Baru
            </a>
        </div>

    </div>
@endsection
