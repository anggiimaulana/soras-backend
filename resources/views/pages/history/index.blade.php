@extends('layouts.app')
@section('title', 'Riwayat Rekomendasi')
@section('page_title', 'Riwayat')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Riwayat Rekomendasi</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Semua rekomendasi yang pernah kamu dapatkan.
                    @if (!$history->isEmpty())
                        <span
                            class="text-green-600 dark:text-green-400 font-medium">{{ method_exists($history, 'total') ? $history->total() : $history->count() }}
                            total</span>
                    @endif
                </p>
            </div>
            <a href="{{ route('recommendation.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm shadow-green-600/25 self-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Rekomendasi Baru
            </a>
        </div>

        {{-- Content --}}
        @if ($history->isEmpty())
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/5 p-16 text-center">
                <div
                    class="w-16 h-16 bg-gray-100 dark:bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-5">Belum ada riwayat rekomendasi.</p>
                <a href="{{ route('recommendation.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-colors">
                    Dapatkan Rekomendasi Pertama
                </a>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($history as $rec)
                    <a href="{{ route('recommendation.result', $rec->id) }}"
                        class="group flex items-center gap-4 p-4 bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/5 hover:border-green-300 dark:hover:border-green-500/30 hover:shadow-sm transition-all block">

                        {{-- Score circle --}}
                        <div
                            class="w-14 h-14 rounded-2xl bg-green-50 dark:bg-green-500/10 border-2 border-green-200 dark:border-green-500/20 flex flex-col items-center justify-center flex-shrink-0">
                            <span class="text-sm font-extrabold text-green-700 dark:text-green-400 leading-none">
                                {{ number_format($rec->final_score * 100, 0) }}%
                            </span>
                            <span class="text-[9px] text-green-500 dark:text-green-500 mt-0.5">match</span>
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1 flex-wrap">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                    {{ $rec->primaryComplaint?->name ?? '—' }}
                                </p>
                                <span
                                    class="flex-shrink-0 px-2 py-0.5 text-[10px] font-semibold bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 rounded-lg">
                                    {{ $rec->goal?->name }}
                                </span>
                            </div>

                            <div class="flex items-center gap-3 text-xs text-gray-400 dark:text-gray-500 mb-2">
                                <span>{{ $rec->created_at->format('d M Y, H:i') }}</span>
                                <span>·</span>
                                <span>Confidence: <span
                                        class="font-semibold text-gray-600 dark:text-gray-400">{{ number_format($rec->confidence, 1) }}%</span></span>
                            </div>

                            {{-- Top 3 chips --}}
                            <div class="flex items-center gap-1.5 flex-wrap">
                                @foreach ($rec->details->take(3) as $i => $detail)
                                    @php
                                        $chipColor =
                                            [
                                                'bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-400',
                                                'bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-400',
                                                'bg-orange-100 dark:bg-orange-500/20 text-orange-700 dark:text-orange-400',
                                            ][$i] ?? '';
                                        $medal = ['🥇', '🥈', '🥉'][$i] ?? '';
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-semibold rounded-lg {{ $chipColor }}">
                                        {{ $medal }} {{ $detail->exercise->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Arrow --}}
                        <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 group-hover:text-green-500 dark:group-hover:text-green-400 transition-colors flex-shrink-0"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>

                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if (method_exists($history, 'hasPages') && $history->hasPages())
                <div class="flex justify-center">
                    {{ $history->links() }}
                </div>
            @endif
        @endif

    </div>
@endsection
