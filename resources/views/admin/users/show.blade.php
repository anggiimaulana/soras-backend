@extends('layouts.admin')
@section('title', 'Detail Pengguna: ' . $user->name)

@section('content')
    <div class="space-y-5">

        <a href="{{ route('admin.users.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar
        </a>

        {{-- Header Card --}}
        <div class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white font-extrabold flex-shrink-0"
                    style="font-size:22px;background:linear-gradient(135deg,#818cf8,#6366f1);box-shadow:0 4px 16px rgba(99,102,241,0.3);">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-600 mt-1">
                        Bergabung {{ $user->created_at->format('d M Y') }} &bull; {{ $user->created_at->diffForHumans() }}
                    </p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-3xl font-extrabold" style="color:#818cf8;">{{ $user->recommendations_count }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">Rekomendasi</p>
                </div>
            </div>
        </div>

        {{-- Profil Fisik --}}
        @if ($user->profile)
            <div class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Profil Fisik</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach ([['Usia', ($user->profile->age ?? '—') . ' tahun'], ['Jenis Kelamin', $user->profile->gender === 'L' ? 'Laki-laki' : ($user->profile->gender === 'P' ? 'Perempuan' : '—')], ['Tinggi', ($user->profile->height_cm ?? '—') . ' cm'], ['Berat', ($user->profile->weight_kg ?? '—') . ' kg']] as [$key, $val])
                        <div
                            class="bg-gray-50 dark:bg-white/[0.03] rounded-xl p-3 border border-gray-100 dark:border-white/[0.06]">
                            <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">{{ $key }}</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $val }}</p>
                        </div>
                    @endforeach
                </div>

                @if ($user->profile->bmi)
                    <div
                        class="mt-4 flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-white/[0.03] border border-gray-100 dark:border-white/[0.06]">
                        <div>
                            <p class="text-xs text-gray-400 dark:text-gray-500">BMI</p>
                            <p class="text-xl font-extrabold text-gray-800 dark:text-gray-100">
                                {{ number_format($user->profile->bmi, 1) }}</p>
                        </div>
                        <div class="w-px h-8 bg-gray-200 dark:bg-white/10 mx-1"></div>
                        <div>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Kategori BMI</p>
                            @php
                                $bmiColor = match ($user->profile->bmi_category) {
                                    'Normal' => 'bg-green-50 dark:bg-green-500/10 text-green-700 dark:text-green-400',
                                    'Underweight' => 'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400',
                                    'Overweight'
                                        => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400',
                                    default => 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400',
                                };
                            @endphp
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold {{ $bmiColor }}">
                                {{ $user->profile->bmi_category ?? '—' }}
                            </span>
                        </div>
                        @if ($user->profile->age_category)
                            <div class="w-px h-8 bg-gray-200 dark:bg-white/10 mx-1"></div>
                            <div>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Kategori Usia</p>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-violet-50 dark:bg-violet-500/10 text-violet-700 dark:text-violet-400">
                                    {{ $user->profile->age_category }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- ── Keluhan & Tujuan (berdasarkan frekuensi dari history) ────────── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                {{-- Keluhan Paling Sering --}}
                <div class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Keluhan Paling Sering</h3>
                        @if ($totalRecs > 0)
                            <span class="text-xs text-gray-400 dark:text-gray-500">dari {{ $totalRecs }} sesi</span>
                        @endif
                    </div>

                    @if ($topComplaints->isEmpty())
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center mb-2">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="1.5" class="text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-600">Belum ada data keluhan.</p>
                        </div>
                    @else
                        <div class="space-y-2.5">
                            @foreach ($topComplaints as $i => $complaint)
                                @php
                                    // Hitung persentase relatif terhadap complaint teratas
                                    $maxFreq = $topComplaints->first()['frequency'];
                                    $pct = $maxFreq > 0 ? round(($complaint['frequency'] / $maxFreq) * 100) : 0;
                                    $isPrimary = $complaint['type'] === 'primary';
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center gap-2 min-w-0">
                                            {{-- Rank badge --}}
                                            <span
                                                class="flex-shrink-0 w-4 h-4 rounded flex items-center justify-center text-white font-bold"
                                                style="font-size:9px;background:{{ $i === 0 ? '#6366f1' : ($i === 1 ? '#8b5cf6' : '#a78bfa') }};">
                                                {{ $i + 1 }}
                                            </span>
                                            <span class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                                {{ $complaint['name'] }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2 flex-shrink-0 ml-2">
                                            {{-- Frequency --}}
                                            <span class="text-xs font-bold text-gray-500 dark:text-gray-400"
                                                style="font-size:10px;min-width:28px;text-align:right;">
                                                {{ $complaint['frequency'] }}×
                                            </span>
                                        </div>
                                    </div>
                                    {{-- Frequency bar --}}
                                    <div class="h-1 bg-gray-100 dark:bg-white/[0.06] rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all"
                                            style="width:{{ $pct }}%;background:{{ $i === 0 ? '#6366f1' : ($i === 1 ? '#8b5cf6' : '#a78bfa') }};opacity:{{ $i === 0 ? '1' : '0.7' }};">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Goal Paling Sering --}}
                <div class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Tujuan Paling Sering</h3>
                        @if ($totalRecs > 0)
                            <span class="text-xs text-gray-400 dark:text-gray-500">dari {{ $totalRecs }} sesi</span>
                        @endif
                    </div>

                    @if ($topGoals->isEmpty())
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center mb-2">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="1.5" class="text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-600">Belum ada data tujuan.</p>
                        </div>
                    @else
                        <div class="space-y-2.5">
                            @foreach ($topGoals as $i => $goal)
                                @php
                                    $maxFreq = $topGoals->first()['frequency'];
                                    $pct = $maxFreq > 0 ? round(($goal['frequency'] / $maxFreq) * 100) : 0;
                                    // Warna gradasi green untuk goals
                                    $colors = ['#16a34a', '#22c55e', '#4ade80', '#86efac', '#bbf7d0'];
                                    $color = $colors[$i] ?? '#86efac';
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span
                                                class="flex-shrink-0 w-4 h-4 rounded flex items-center justify-center text-white font-bold"
                                                style="font-size:9px;background:{{ $color }};">
                                                {{ $i + 1 }}
                                            </span>
                                            <span class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                                {{ $goal['name'] }}
                                            </span>
                                        </div>
                                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 flex-shrink-0 ml-2"
                                            style="font-size:10px;">
                                            {{ $goal['frequency'] }}×
                                        </span>
                                    </div>
                                    {{-- Frequency bar --}}
                                    <div class="h-1 bg-gray-100 dark:bg-white/[0.06] rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all"
                                            style="width:{{ $pct }}%;background:{{ $color }};opacity:{{ $i === 0 ? '1' : '0.7' }};">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        @else
            <div
                class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] p-8 text-center">
                <p class="text-sm text-gray-400 dark:text-gray-600">Pengguna belum melengkapi profil.</p>
            </div>
        @endif

        {{-- Riwayat Rekomendasi --}}
        @if ($user->profile && $user->profile->recommendations->isNotEmpty())
            <div class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Riwayat Rekomendasi</h3>
                    <span class="text-xs text-gray-400 dark:text-gray-500">5 Terakhir</span>
                </div>
                <div class="space-y-3">
                    @foreach ($user->profile->recommendations as $rec)
                        <div
                            class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-white/[0.03] border border-gray-100 dark:border-white/[0.06]">
                            <div>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                        {{ $rec->primaryComplaint?->name ?? 'Umum' }}
                                    </p>
                                    @if ($rec->goal)
                                        <span class="text-xs px-1.5 py-0.5 rounded"
                                            style="background:rgba(34,197,94,0.1);color:#16a34a;font-size:9px;">
                                            {{ $rec->goal->name }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                    {{ $rec->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div class="text-right flex-shrink-0 ml-3">
                                <p class="text-sm font-extrabold" style="color:#818cf8;">
                                    {{ number_format($rec->final_score * 100, 0) }}%
                                </p>
                                <p class="text-gray-400 dark:text-gray-500" style="font-size:9px;">score</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
