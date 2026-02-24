@extends('layouts.admin')
@section('title', 'Matriks Keluhan vs Olahraga')

@section('content')
    <div class="space-y-5">

        <p class="text-sm text-gray-500">
            Edit nilai relevansi setiap keluhan terhadap olahraga.
            Skala: <strong>-0.5</strong> (berisiko) hingga <strong>1.0</strong> (sangat cocok).
        </p>

        <div class="bg-white rounded-xl border border-gray-100 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium text-gray-600 min-w-40">Keluhan</th>
                        @foreach ($exercises as $exercise)
                            <th class="text-center px-3 py-3 font-medium text-gray-600 min-w-28">
                                {{ $exercise->name }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($complaints as $complaint)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $complaint->name }}</td>
                            @foreach ($exercises as $exercise)
                                @php
                                    $pivot = $complaint->exercises->where('id', $exercise->id)->first();
                                    $score = $pivot?->pivot->relevance_score ?? 0;
                                    $colorClass = match (true) {
                                        $score >= 0.7 => 'bg-green-50 border-green-200 text-green-700',
                                        $score >= 0.3 => 'bg-blue-50 border-blue-200 text-blue-700',
                                        $score >= 0 => 'bg-gray-50 border-gray-200 text-gray-600',
                                        default => 'bg-red-50 border-red-200 text-red-700',
                                    };
                                @endphp
                                <td class="px-3 py-3 text-center">
                                    <form method="POST"
                                        action="{{ route('admin.complaints.updateScore', $complaint->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="exercise_id" value="{{ $exercise->id }}">
                                        <input type="number" name="relevance_score" value="{{ $score }}"
                                            min="-0.5" max="1" step="0.1"
                                            class="w-20 text-center text-xs font-semibold border rounded-lg px-2 py-1.5 {{ $colorClass }} focus:outline-none focus:ring-2 focus:ring-primary-400"
                                            onchange="this.form.submit()">
                                    </form>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Legend --}}
        <div class="flex items-center gap-4 text-xs text-gray-500">
            <span>Keterangan:</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-green-200 rounded"></span> ≥ 0.7 Sangat
                Cocok</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-blue-200 rounded"></span> ≥ 0.3 Netral</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-gray-200 rounded"></span> ≥ 0 Tidak
                Direkomendasikan</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-red-200 rounded"></span>
                < 0 Berisiko</span>
        </div>

    </div>
@endsection
