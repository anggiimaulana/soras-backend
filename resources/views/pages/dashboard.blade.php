@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">

        {{-- Welcome --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Halo, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-gray-500 mt-1">
                    @if ($profile)
                        Kamu siap untuk mendapatkan rekomendasi olahraga hari ini.
                    @else
                        Lengkapi profil kamu untuk mulai mendapatkan rekomendasi.
                    @endif
                </p>
            </div>
            <a href="{{ route('recommendation.create') }}" class="btn-primary">
                + Rekomendasi Baru
            </a>
        </div>

        {{-- Alert profil belum lengkap --}}
        @if (!$profile)
            <div class="flex items-start gap-4 p-5 bg-amber-50 border border-amber-200 rounded-xl">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-amber-900">Profil belum lengkap</p>
                    <p class="text-sm text-amber-700 mt-1">
                        Isi data fisik kamu terlebih dahulu agar sistem dapat memberikan rekomendasi yang akurat.
                    </p>
                    <a href="{{ route('profile.index') }}"
                        class="inline-flex items-center gap-1 mt-3 text-sm font-medium text-amber-800 hover:text-amber-900">
                        Lengkapi Profil →
                    </a>
                </div>
            </div>
        @endif

        {{-- Stats --}}
        @if ($profile)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- BMI Card --}}
                <div class="card">
                    <p class="text-sm font-medium text-gray-500">BMI Kamu</p>
                    @if ($profile->bmi)
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $profile->bmi }}</p>
                        <span
                            class="mt-2 inline-block
                        @if ($profile->bmi_category === 'Normal') badge-green
                        @elseif($profile->bmi_category === 'Underweight') badge-blue
                        @elseif($profile->bmi_category === 'Overweight') badge-yellow
                        @else badge-red @endif">
                            {{ $profile->bmi_category }}
                        </span>
                    @else
                        <p class="text-3xl font-bold text-gray-400 mt-1">—</p>
                        <p class="text-xs text-gray-400 mt-2">Belum dihitung</p>
                    @endif
                </div>

                {{-- Total Rekomendasi --}}
                <div class="card">
                    <p class="text-sm font-medium text-gray-500">Total Rekomendasi</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalRecommendations }}</p>
                    <p class="text-xs text-gray-400 mt-2">Sepanjang waktu</p>
                </div>

                {{-- Profil --}}
                <div class="card">
                    <p class="text-sm font-medium text-gray-500">Profil Fisik</p>
                    <div class="mt-2 space-y-1">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Usia</span>
                            <span class="font-medium text-gray-900">{{ $profile->age }} tahun</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tinggi</span>
                            <span class="font-medium text-gray-900">{{ $profile->height_cm }} cm</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Berat</span>
                            <span class="font-medium text-gray-900">{{ $profile->weight_kg }} kg</span>
                        </div>
                    </div>
                </div>

            </div>
        @endif

        {{-- Rekomendasi Terakhir --}}
        @if ($latestRecommendation)
            <div class="card">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-semibold text-gray-900">Rekomendasi Terakhir</h2>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-400">
                            {{ $latestRecommendation->created_at->diffForHumans() }}
                        </span>
                        <a href="{{ route('recommendation.result', $latestRecommendation->id) }}"
                            class="text-sm text-primary-600 font-medium hover:underline">
                            Lihat Detail →
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($latestRecommendation->details as $detail)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                            <div
                                class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm
                            @if ($detail->rank_order === 1) bg-yellow-100 text-yellow-700
                            @elseif($detail->rank_order === 2) bg-gray-200 text-gray-600
                            @else bg-orange-100 text-orange-700 @endif">
                                #{{ $detail->rank_order }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 truncate">
                                    {{ $detail->exercise->name }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    Skor: {{ number_format($detail->score * 100, 1) }}%
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Empty state --}}
            @if ($profile)
                <div class="card text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-gray-500 mb-4">Belum ada rekomendasi. Yuk mulai sekarang!</p>
                    <a href="{{ route('recommendation.create') }}" class="btn-primary">
                        Dapatkan Rekomendasi
                    </a>
                </div>
            @endif
        @endif

    </div>
@endsection
