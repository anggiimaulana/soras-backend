@extends('layouts.app')
@section('title', 'Hasil Rekomendasi')
@section('page_title', 'Hasil Rekomendasi')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- ── Header ──────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Hasil Rekomendasi</h1>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
                    {{ $recommendation->created_at->format('d F Y, H:i') }}</p>
            </div>
            <a href="{{ route('recommendation.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors self-start"
                style="box-shadow:0 2px 8px rgba(22,163,74,0.25);">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Rekomendasi Baru
            </a>
        </div>

        {{-- ── Context card ─────────────────────────────────── --}}
        <div class="rounded-2xl p-5" style="background:linear-gradient(135deg,#16a34a,#166534);">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach ([['Keluhan Utama', $recommendation->primaryComplaint->name], ['Tujuan', $recommendation->goal->name], ['Confidence', number_format($recommendation->confidence, 1) . '%'], ['Top Score', number_format($recommendation->final_score * 100, 1) . '%']] as [$label, $value])
                    <div>
                        <p class="text-green-200 uppercase tracking-widest font-semibold mb-1" style="font-size:9px;">
                            {{ $label }}</p>
                        <p class="text-sm font-bold text-white leading-tight">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── Top 3 Recommendations ───────────────────────── --}}
        <div class="space-y-4">
            @foreach ($recommendation->details as $detail)
                @php
                    $configs = [
                        1 => [
                            'emoji' => '🥇',
                            'label' => 'Terbaik',
                            'cardBg' => 'bg-yellow-50 dark:bg-yellow-500/5 border-yellow-200 dark:border-yellow-500/15',
                            'badgeBg' => 'bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-400',
                            'bar' => '#22c55e',
                        ],
                        2 => [
                            'emoji' => '🥈',
                            'label' => 'Alternatif 1',
                            'cardBg' => 'bg-gray-50 dark:bg-white/[0.02] border-gray-200 dark:border-white/[0.06]',
                            'badgeBg' => 'bg-gray-200 dark:bg-white/10 text-gray-600 dark:text-gray-400',
                            'bar' => '#60a5fa',
                        ],
                        3 => [
                            'emoji' => '🥉',
                            'label' => 'Alternatif 2',
                            'cardBg' => 'bg-orange-50 dark:bg-orange-500/5 border-orange-100 dark:border-orange-500/15',
                            'badgeBg' => 'bg-orange-100 dark:bg-orange-500/20 text-orange-700 dark:text-orange-400',
                            'bar' => '#f97316',
                        ],
                    ];
                    $cfg = $configs[$detail->rank_order] ?? $configs[3];
                    $impactLabel = ['', 'Low', 'Medium', 'High'][$detail->exercise->impact_level] ?? '—';
                    $impactStyle =
                        [
                            '',
                            'background:#dcfce7;color:#15803d;',
                            'background:#fef9c3;color:#a16207;',
                            'background:#fee2e2;color:#dc2626;',
                        ][$detail->exercise->impact_level] ?? '';
                    $impactStyleDark =
                        ['', 'rgba(34,197,94,0.15)', 'rgba(245,158,11,0.15)', 'rgba(239,68,68,0.15)'][
                            $detail->exercise->impact_level
                        ] ?? '';
                @endphp

                <div class="border rounded-2xl p-5 {{ $cfg['cardBg'] }}">

                    {{-- Header row --}}
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <span class="text-2xl">{{ $cfg['emoji'] }}</span>
                            <span
                                class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $cfg['badgeBg'] }}">{{ $cfg['label'] }}</span>
                            <h3 class="text-lg font-extrabold text-gray-900 dark:text-white">{{ $detail->exercise->name }}
                            </h3>
                            <span class="text-xs text-gray-400 dark:text-gray-500">{{ $detail->exercise->category }}</span>
                        </div>
                        <div class="text-right flex-shrink-0 ml-3">
                            <p class="text-3xl font-extrabold text-gray-900 dark:text-white leading-none">
                                {{ number_format($detail->score * 100, 1) }}<span class="text-lg font-medium">%</span>
                            </p>
                            <p class="text-gray-400 dark:text-gray-500 mt-0.5" style="font-size:10px;">Match Score</p>
                        </div>
                    </div>

                    {{-- Progress bar --}}
                    <div class="w-full bg-gray-200 dark:bg-white/10 rounded-full mb-5" style="height:8px;">
                        <div class="rounded-full transition-all"
                            style="height:8px;width:{{ number_format($detail->score * 100, 1) }}%;background-color:{{ $cfg['bar'] }};">
                        </div>
                    </div>

                    {{-- Stats chips --}}
                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div
                            class="text-center p-3 bg-white dark:bg-white/5 rounded-xl border border-gray-100 dark:border-white/[0.06]">
                            <p class="text-xl font-extrabold text-gray-900 dark:text-white leading-none">
                                {{ $detail->exercise->duration_min }}</p>
                            <p class="text-gray-400 dark:text-gray-500 mt-1" style="font-size:10px;">menit</p>
                            <p class="text-gray-400 dark:text-gray-500" style="font-size:9px;">Durasi</p>
                        </div>
                        <div
                            class="text-center p-3 bg-white dark:bg-white/5 rounded-xl border border-gray-100 dark:border-white/[0.06]">
                            <p class="text-xl font-extrabold text-gray-900 dark:text-white leading-none">
                                {{ $detail->exercise->frequency_per_week }}</p>
                            <p class="text-gray-400 dark:text-gray-500 mt-1" style="font-size:10px;">× / minggu</p>
                            <p class="text-gray-400 dark:text-gray-500" style="font-size:9px;">Frekuensi</p>
                        </div>
                        <div
                            class="text-center p-3 bg-white dark:bg-white/5 rounded-xl border border-gray-100 dark:border-white/[0.06]">
                            <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-bold"
                                style="{{ $impactStyle }}">{{ $impactLabel }}</span>
                            <p class="text-gray-400 dark:text-gray-500 mt-1.5" style="font-size:9px;">Impact Level</p>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if ($detail->exercise->description)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                            {{ $detail->exercise->description }}</p>
                    @endif

                    {{-- FIX #4: Score Breakdown DENGAN perhitungan lengkap --}}
                    @if ($detail->scoreBreakdown)
                        @php
                            $sb = $detail->scoreBreakdown;
                            $factors = [
                                [
                                    'abbr' => 'P',
                                    'label' => 'Primary Complaint',
                                    'weight' => 0.3,
                                    'score' => $sb->score_primary,
                                    'color' => '#ef4444',
                                    'bg' => '#fee2e2',
                                    'darkBg' => 'rgba(239,68,68,0.15)',
                                ],
                                [
                                    'abbr' => 'S',
                                    'label' => 'Secondary Complaint',
                                    'weight' => 0.2,
                                    'score' => $sb->score_secondary,
                                    'color' => '#f97316',
                                    'bg' => '#ffedd5',
                                    'darkBg' => 'rgba(249,115,22,0.15)',
                                ],
                                [
                                    'abbr' => 'G',
                                    'label' => 'Goal / Tujuan',
                                    'weight' => 0.25,
                                    'score' => $sb->score_goal,
                                    'color' => '#3b82f6',
                                    'bg' => '#dbeafe',
                                    'darkBg' => 'rgba(59,130,246,0.15)',
                                ],
                                [
                                    'abbr' => 'BMI',
                                    'label' => 'Indeks Massa Tubuh',
                                    'weight' => 0.15,
                                    'score' => $sb->score_bmi,
                                    'color' => '#8b5cf6',
                                    'bg' => '#ede9fe',
                                    'darkBg' => 'rgba(139,92,246,0.15)',
                                ],
                                [
                                    'abbr' => 'Age',
                                    'label' => 'Usia + Impact Level',
                                    'weight' => 0.1,
                                    'score' => $sb->score_age,
                                    'color' => '#22c55e',
                                    'bg' => '#dcfce7',
                                    'darkBg' => 'rgba(34,197,94,0.15)',
                                ],
                            ];
                            // Hitung final score manual untuk verifikasi
                            $calcFinal = 0;
                            foreach ($factors as $f) {
                                $calcFinal += $f['weight'] * $f['score'];
                            }
                        @endphp

                        <details class="group" x-data="{ open: false }" @toggle="open = $event.target.open">
                            <summary
                                class="flex items-center gap-1.5 text-sm font-semibold text-green-600 dark:text-green-400 cursor-pointer list-none hover:opacity-80 select-none">
                                <svg class="transition-transform" :class="open ? 'rotate-90' : ''" width="16"
                                    height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                Lihat Breakdown Skor Lengkap
                            </summary>

                            <div class="mt-4 space-y-3">

                                {{-- Formula header --}}
                                <div
                                    class="p-3 rounded-xl border border-gray-200 dark:border-white/[0.06] bg-gray-50 dark:bg-white/[0.03]">
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5">Formula SORAS:</p>
                                    <p class="font-mono-custom text-xs text-gray-700 dark:text-gray-300">
                                        FinalScore = (0.30×P) + (0.20×S) + (0.25×G) + (0.15×BMI) + (0.10×Age)
                                    </p>
                                </div>

                                {{-- Per-factor breakdown --}}
                                <div class="space-y-2">
                                    @foreach ($factors as $f)
                                        @php
                                            $contribution = $f['weight'] * $f['score'];
                                        @endphp
                                        <div
                                            class="p-3 rounded-xl bg-white dark:bg-white/[0.03] border border-gray-100 dark:border-white/[0.06]">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center gap-2.5">
                                                    {{-- Badge abbr --}}
                                                    <div class="flex items-center justify-center rounded-lg font-extrabold font-mono-custom"
                                                        style="width:32px;height:32px;font-size:10px;background-color:{{ $f['bg'] }};color:{{ $f['color'] }};">
                                                        {{ $f['abbr'] }}
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">
                                                            {{ $f['label'] }}</p>
                                                        <p class="text-gray-400 dark:text-gray-500" style="font-size:10px;">
                                                            Bobot: <span
                                                                class="font-bold text-gray-600 dark:text-gray-400">{{ number_format($f['weight'] * 100, 0) }}%</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-sm font-extrabold text-gray-900 dark:text-white">
                                                        {{ number_format($f['score'] * 100, 0) }}
                                                        <span class="text-xs font-medium text-gray-400">/100</span>
                                                    </p>
                                                    <p class="font-mono-custom"
                                                        style="font-size:10px;color:{{ $f['color'] }};">
                                                        {{ number_format($f['weight'], 2) }} ×
                                                        {{ number_format($f['score'], 2) }}
                                                        = <strong>{{ number_format($contribution, 4) }}</strong>
                                                    </p>
                                                </div>
                                            </div>
                                            {{-- Mini bar --}}
                                            <div class="bg-gray-100 dark:bg-white/10 rounded-full" style="height:4px;">
                                                <div class="rounded-full"
                                                    style="height:4px;width:{{ number_format($f['score'] * 100, 1) }}%;background-color:{{ $f['color'] }};">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Total calculation --}}
                                <div
                                    class="p-4 rounded-xl border-2 border-green-200 dark:border-green-500/30 bg-green-50 dark:bg-green-500/10">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p
                                                class="text-xs font-bold text-green-700 dark:text-green-400 uppercase tracking-wider">
                                                Final Score</p>
                                            <p class="text-xs text-green-600 dark:text-green-500 mt-1">
                                                @foreach ($factors as $i => $f)
                                                    {{ number_format($f['weight'] * $f['score'], 4) }}{{ !$i + 1 == count($factors) ? ' + ' : '' }}
                                                @endforeach
                                            </p>
                                            <p class="text-xs text-green-700 dark:text-green-400 font-bold mt-0.5">
                                                = {{ number_format($calcFinal, 4) }} →
                                                {{ number_format($calcFinal * 100, 1) }}%
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p
                                                class="text-3xl font-extrabold text-green-700 dark:text-green-400">
                                                {{ number_format($detail->score * 100, 1) }}%
                                            </p>
                                            <p class="text-xs text-green-600 dark:text-green-500 font-semibold">Match Score
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </details>
                    @endif

                </div>
            @endforeach
        </div>

        {{-- ── Disclaimer ──────────────────────────────────── --}}
        <div
            class="flex items-start gap-3 p-4 bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/[0.06] rounded-xl">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="2" class="text-gray-400 flex-shrink-0 mt-0.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Rekomendasi ini bersifat informatif. Konsultasikan dengan tenaga medis profesional sebelum memulai program
                olahraga baru.
            </p>
        </div>

        {{-- ── Actions ─────────────────────────────────────── --}}
        <div class="flex gap-3">
            <a href="{{ route('history.index') }}"
                class="flex-1 text-center py-3 border border-gray-200 dark:border-white/[0.1] text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                Lihat Semua Riwayat
            </a>
            <a href="{{ route('recommendation.create') }}"
                class="flex-1 text-center py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-colors"
                style="box-shadow:0 2px 8px rgba(22,163,74,0.25);">
                Rekomendasi Baru
            </a>
        </div>

    </div>
@endsection
