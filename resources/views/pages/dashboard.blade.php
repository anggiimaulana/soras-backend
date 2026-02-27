@extends('layouts.app')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- ── Welcome header ──────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            {{-- FIX #5: name->split() tidak valid di Blade — pakai PHP explode --}}
            @php $firstName = explode(' ', auth()->user()->name)[0]; @endphp
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                Halo, {{ $firstName }}! 👋
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                @if ($profile)
                    Kamu siap mendapatkan rekomendasi olahraga hari ini.
                @else
                    Lengkapi profil kamu untuk mulai mendapatkan rekomendasi.
                @endif
            </p>
        </div>
        <a href="{{ route('recommendation.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors self-start"
            style="box-shadow:0 2px 8px rgba(22,163,74,0.25);">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
            Rekomendasi Baru
        </a>
    </div>

    {{-- ── Alert profil belum lengkap ─────────────────── --}}
    @if (!$profile)
        <div class="flex items-start gap-4 p-5 bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 rounded-2xl">
            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" class="text-amber-600 dark:text-amber-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-amber-900 dark:text-amber-400">Profil belum lengkap</p>
                <p class="text-sm text-amber-700 dark:text-amber-500 mt-1">Isi data fisik kamu agar sistem dapat memberikan rekomendasi yang akurat.</p>
                <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-1 mt-3 text-sm font-semibold text-amber-800 dark:text-amber-400 hover:underline">
                    Lengkapi Profil →
                </a>
            </div>
        </div>
    @endif

    {{-- ── Stats grid ───────────────────────────────────── --}}
    @if ($profile)
        @php
            $bmiVal = (float) $profile->bmi;

            $bmiMin = 10;
            $bmiMax = 45;
            $bmiClamped = min(max($bmiVal, $bmiMin), $bmiMax);
            $bmiPercent = round((($bmiClamped - $bmiMin) / ($bmiMax - $bmiMin)) * 100, 1);

            $bmiColors = [
                'Normal'      => ['text' => 'text-green-600 dark:text-green-400',  'badge' => 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400',  'dot' => '#22c55e'],
                'Underweight' => ['text' => 'text-blue-600 dark:text-blue-400',   'badge' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400',    'dot' => '#60a5fa'],
                'Overweight'  => ['text' => 'text-amber-600 dark:text-amber-400', 'badge' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400', 'dot' => '#f59e0b'],
                'Obesitas'    => ['text' => 'text-red-600 dark:text-red-400',     'badge' => 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400',         'dot' => '#ef4444'],
            ];
            $bmiColor = $bmiColors[$profile->bmi_category] ?? $bmiColors['Obesitas'];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            {{-- BMI Card --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/[0.06] p-5">
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">BMI Kamu</p>
                @if ($profile->bmi)
                    <p class="text-4xl font-extrabold {{ $bmiColor['text'] }} tracking-tight">{{ $profile->bmi }}</p>
                    <span class="mt-2 inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $bmiColor['badge'] }}">
                        {{ $profile->bmi_category }}
                    </span>

                    {{-- FIX #6: BMI bar dengan dot indikator posisi --}}
                    <div class="mt-4">
                        {{-- Bar dengan dot --}}
                        <div class="relative">
                            {{-- Segments --}}
                            <div class="flex h-2 rounded-full overflow-hidden gap-px">
                                <div style="flex:28" class="bg-blue-300 dark:bg-blue-500/50"></div>
                                <div style="flex:22" class="bg-green-400 dark:bg-green-500/60"></div>
                                <div style="flex:17" class="bg-amber-300 dark:bg-amber-500/50"></div>
                                <div style="flex:33" class="bg-red-300 dark:bg-red-500/50"></div>
                            </div>
                            {{-- Dot indikator posisi BMI --}}
                            <div class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2"
                                style="left: {{ $bmiPercent }}%;">
                                <div class="w-3.5 h-3.5 rounded-full border-2 border-white dark:border-gray-900 shadow-md"
                                    style="background-color: {{ $bmiColor['dot'] }};"></div>
                            </div>
                        </div>
                        {{-- Labels --}}
                        <div class="flex justify-between mt-2" style="font-size:9px;" class="text-gray-400 dark:text-gray-600">
                            <span class="text-gray-400 dark:text-gray-600">10</span>
                            <span class="text-gray-400 dark:text-gray-600">18.5</span>
                            <span class="text-gray-400 dark:text-gray-600">25</span>
                            <span class="text-gray-400 dark:text-gray-600">30</span>
                            <span class="text-gray-400 dark:text-gray-600">45+</span>
                        </div>
                        <div class="flex justify-between mt-0.5" style="font-size:9px;">
                            <span class="text-blue-400">Kurus</span>
                            <span class="text-green-500">Normal</span>
                            <span class="text-amber-400">Gemuk</span>
                            <span class="text-red-400">Obesitas</span>
                        </div>
                    </div>
                @else
                    <p class="text-4xl font-extrabold text-gray-300 dark:text-gray-700">—</p>
                    <p class="text-xs text-gray-400 mt-2">Belum dihitung</p>
                @endif
            </div>

            {{-- Total Rekomendasi --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/[0.06] p-5">
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Total Rekomendasi</p>
                <p class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ $totalRecommendations }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Sepanjang waktu</p>
                <div class="mt-4 flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <p class="text-xs text-gray-400 dark:text-gray-500">Aktif menggunakan SORAS</p>
                </div>
            </div>

            {{-- Profil Fisik --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/[0.06] p-5">
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Profil Fisik</p>
                {{-- FIX #5: Tampil data fresh dari $profile (di-pass dari controller) --}}
                <div class="space-y-2">
                    @foreach ([
                        ['Usia',     $profile->age . ' tahun'],
                        ['Tinggi',   $profile->height_cm . ' cm'],
                        ['Berat',    $profile->weight_kg . ' kg'],
                        ['Kategori', $profile->age_category],
                    ] as [$label, $val])
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400 dark:text-gray-500">{{ $label }}</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $val }}</span>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('profile.index') }}"
                    class="mt-4 inline-flex items-center gap-1 text-xs text-green-600 dark:text-green-400 hover:underline font-medium">
                    Edit Profil →
                </a>
            </div>

        </div>
    @endif

    {{-- ── CTA Banner ───────────────────────────────────── --}}
    <div class="relative overflow-hidden rounded-2xl p-6" style="background:linear-gradient(135deg,#16a34a,#166534);">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-8 -right-8 w-48 h-48 rounded-full bg-white"></div>
            <div class="absolute -bottom-12 -left-8 w-64 h-64 rounded-full bg-white"></div>
        </div>
        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-green-200 uppercase tracking-widest mb-1">Siap Mulai?</p>
                <h2 class="text-xl font-extrabold text-white">Dapatkan Rekomendasi Olahraga</h2>
                <p class="text-sm text-green-200 mt-1">Sistem kami akan memilihkan olahraga terbaik sesuai kondisimu.</p>
            </div>
            <a href="{{ route('recommendation.create') }}"
                class="inline-flex items-center gap-2 px-5 py-3 bg-white text-green-700 text-sm font-bold rounded-xl hover:bg-green-50 transition-colors whitespace-nowrap shadow-lg self-start sm:self-auto">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Mulai Sekarang
            </a>
        </div>
    </div>

    {{-- ── Rekomendasi Terakhir ─────────────────────────── --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-gray-900 dark:text-white">Rekomendasi Terakhir</h2>
            @if ($latestRecommendation)
                <a href="{{ route('history.index') }}" class="text-xs text-green-600 dark:text-green-400 hover:underline font-medium">
                    Lihat Semua →
                </a>
            @endif
        </div>

        @if ($latestRecommendation)
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/[0.06] overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-white/[0.06]">
                    <div>
                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ $latestRecommendation->created_at->diffForHumans() }}</p>
                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $latestRecommendation->primaryComplaint->name }}</span>
                            <span class="text-gray-300 dark:text-gray-600">·</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $latestRecommendation->goal->name }}</span>
                        </div>
                    </div>
                    <a href="{{ route('recommendation.result', $latestRecommendation->id) }}"
                        class="text-xs text-green-600 dark:text-green-400 font-medium hover:underline whitespace-nowrap">
                        Detail →
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 dark:divide-white/[0.06]">
                    @foreach ($latestRecommendation->details as $detail)
                        @php
                            $rankEmoji = ['🥇','🥈','🥉'][$detail->rank_order - 1] ?? '#'.$detail->rank_order;
                            $rankBg = [
                                'bg-yellow-50 dark:bg-yellow-500/5',
                                'bg-gray-50 dark:bg-white/[0.02]',
                                'bg-orange-50 dark:bg-orange-500/5',
                            ][$detail->rank_order - 1] ?? '';
                        @endphp
                        <div class="flex items-center gap-3 px-5 py-4 {{ $rankBg }}">
                            <span class="text-2xl">{{ $rankEmoji }}</span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $detail->exercise->name }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="flex-1 h-1.5 bg-gray-200 dark:bg-white/10 rounded-full overflow-hidden">
                                        <div class="h-full bg-green-500 rounded-full" style="width:{{ number_format($detail->score * 100, 1) }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-green-600 dark:text-green-400 flex-shrink-0">
                                        {{ number_format($detail->score * 100, 1) }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            @if ($profile)
                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/[0.06] p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="text-gray-400 dark:text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-5">Belum ada rekomendasi. Yuk mulai sekarang!</p>
                    <a href="{{ route('recommendation.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors">
                        Dapatkan Rekomendasi
                    </a>
                </div>
            @endif
        @endif
    </div>

</div>
@endsection