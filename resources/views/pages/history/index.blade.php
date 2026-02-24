@extends('layouts.app')
@section('title', 'Riwayat Rekomendasi')

@section('content')
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Rekomendasi</h1>
                <p class="text-gray-500 mt-1">Semua rekomendasi yang pernah kamu dapatkan.</p>
            </div>
            <a href="{{ route('recommendation.create') }}" class="btn-primary">
                + Rekomendasi Baru
            </a>
        </div>

        @if ($history->isEmpty())
            <div class="card text-center py-16">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-gray-500 mb-4">Belum ada riwayat rekomendasi.</p>
                <a href="{{ route('recommendation.create') }}" class="btn-primary">
                    Dapatkan Rekomendasi Pertama
                </a>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($history as $rec)
                    <a href="{{ route('recommendation.result', $rec->id) }}"
                        class="card hover:shadow-md transition-shadow flex items-center gap-5 group block">

                        {{-- Score Circle --}}
                        <div
                            class="w-14 h-14 rounded-full bg-primary-50 border-2 border-primary-200 flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-primary-700">
                                {{ number_format($rec->final_score * 100, 0) }}%
                            </span>
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <p class="font-semibold text-gray-900 truncate">
                                    {{ $rec->primaryComplaint?->name ?? '—' }}
                                </p>
                                <span class="badge-blue flex-shrink-0">{{ $rec->goal?->name }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-400">
                                <span>{{ $rec->created_at->format('d M Y, H:i') }}</span>
                                <span>•</span>
                                <span>Confidence: {{ number_format($rec->confidence, 1) }}%</span>
                            </div>
                            {{-- Top 3 exercise names --}}
                            <div class="flex items-center gap-2 mt-2">
                                @foreach ($rec->details->take(3) as $i => $detail)
                                    <span
                                        class="text-xs px-2 py-0.5 rounded-full
                                    @if ($i === 0) bg-yellow-100 text-yellow-700
                                    @elseif($i === 1) bg-gray-100 text-gray-600
                                    @else bg-orange-100 text-orange-700 @endif">
                                        #{{ $detail->rank_order }} {{ $detail->exercise->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <svg class="w-5 h-5 text-gray-300 group-hover:text-primary-500 transition-colors flex-shrink-0"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>

                    </a>
                @endforeach
            </div>
        @endif

    </div>
@endsection
