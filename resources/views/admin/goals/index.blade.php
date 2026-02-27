@extends('layouts.admin')
@section('title', 'Matriks Tujuan vs Olahraga')

@section('content')
    <div class="space-y-5">

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Edit nilai relevansi setiap tujuan latihan terhadap olahraga.
            Skala: <strong class="text-gray-700 dark:text-gray-300">0.0</strong> hingga
            <strong class="text-gray-700 dark:text-gray-300">1.0</strong>.
        </p>

        <div
            class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-white/[0.03] border-b border-gray-100 dark:border-white/[0.07]">
                    <tr>
                        <th class="text-left px-4 py-3.5 font-medium text-gray-500 dark:text-gray-400 min-w-48">Tujuan
                            Latihan</th>
                        @foreach ($exercises as $exercise)
                            <th class="text-center px-3 py-3.5 font-medium text-gray-500 dark:text-gray-400 min-w-28">
                                {{ $exercise->name }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-white/[0.05]">
                    @foreach ($goals as $goal)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-4 py-3 font-semibold text-gray-800 dark:text-gray-200">{{ $goal->name }}</td>
                            @foreach ($exercises as $exercise)
                                @php
                                    $pivot = $goal->exercises->where('id', $exercise->id)->first();
                                    $score = $pivot?->pivot->relevance_score ?? 0;
                                    $colorClass = match (true) {
                                        $score >= 0.7
                                            => 'bg-green-50 dark:bg-green-500/10 border-green-200 dark:border-green-500/30 text-green-700 dark:text-green-400',
                                        $score >= 0.3
                                            => 'bg-blue-50 dark:bg-blue-500/10 border-blue-200 dark:border-blue-500/30 text-blue-700 dark:text-blue-400',
                                        default
                                            => 'bg-gray-50 dark:bg-white/[0.05] border-gray-200 dark:border-white/[0.1] text-gray-600 dark:text-gray-400',
                                    };
                                @endphp
                                <td class="px-3 py-3 text-center">
                                    <form method="POST" action="{{ route('admin.goals.updateScore', $goal->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="exercise_id" value="{{ $exercise->id }}">
                                        <input type="number" name="relevance_score" value="{{ $score }}"
                                            min="0" max="1" step="0.1"
                                            class="w-20 text-center text-xs font-semibold border rounded-lg px-2 py-1.5 {{ $colorClass }} focus:outline-none focus:ring-2 focus:ring-violet-400 transition-colors"
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
        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
            <span class="font-medium">Keterangan:</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-green-200 dark:bg-green-500/30 rounded"></span>
                ≥ 0.7 Sangat Cocok</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-blue-200 dark:bg-blue-500/30 rounded"></span> ≥
                0.3 Netral</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-gray-200 dark:bg-white/10 rounded"></span> &lt;
                0.3 Rendah</span>
        </div>

    </div>
@endsection
