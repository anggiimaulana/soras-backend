@extends('layouts.admin')
@section('title', 'Kelola Olahraga')

@section('content')
    <div class="space-y-5">

        <div class="flex justify-between items-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total: <span
                    class="font-semibold text-gray-700 dark:text-gray-200">{{ $exercises->count() }}</span> olahraga</p>
        </div>

        <div
            class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-white/[0.03] border-b border-gray-100 dark:border-white/[0.07]">
                    <tr>
                        <th class="text-left px-5 py-3.5 font-medium text-gray-500 dark:text-gray-400">Nama</th>
                        <th class="text-left px-5 py-3.5 font-medium text-gray-500 dark:text-gray-400">Kategori</th>
                        <th class="text-center px-5 py-3.5 font-medium text-gray-500 dark:text-gray-400">Impact</th>
                        <th class="text-center px-5 py-3.5 font-medium text-gray-500 dark:text-gray-400">Intensity</th>
                        <th class="text-center px-5 py-3.5 font-medium text-gray-500 dark:text-gray-400">Durasi</th>
                        <th class="text-center px-5 py-3.5 font-medium text-gray-500 dark:text-gray-400">Frekuensi</th>
                        <th class="text-center px-5 py-3.5 font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-white/[0.05]">
                    @foreach ($exercises as $exercise)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-5 py-3.5 font-semibold text-gray-900 dark:text-gray-100">{{ $exercise->name }}
                            </td>
                            <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400">{{ $exercise->category }}</td>
                            <td class="px-5 py-3.5 text-center">
                                @php
                                    $impactClasses = [
                                        1 => 'bg-green-50 dark:bg-green-500/10 text-green-700 dark:text-green-400 border border-green-100 dark:border-green-500/20',
                                        2 => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20',
                                        3 => 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border border-red-100 dark:border-red-500/20',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold {{ $impactClasses[$exercise->impact_level] ?? '' }}">
                                    {{ ['', 'Low', 'Medium', 'High'][$exercise->impact_level] }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold {{ $impactClasses[$exercise->intensity_level] ?? '' }}">
                                    {{ ['', 'Low', 'Medium', 'High'][$exercise->intensity_level] }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center text-gray-600 dark:text-gray-400">
                                {{ $exercise->duration_min }} menit</td>
                            <td class="px-5 py-3.5 text-center text-gray-600 dark:text-gray-400">
                                {{ $exercise->frequency_per_week }}x/minggu</td>
                            <td class="px-5 py-3.5 text-center">
                                <a href="{{ route('admin.exercises.edit', $exercise->id) }}"
                                    class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors"
                                    style="background:rgba(99,102,241,0.1);color:#818cf8;"
                                    onmouseover="this.style.background='rgba(99,102,241,0.2)'"
                                    onmouseout="this.style.background='rgba(99,102,241,0.1)'">
                                    <svg width="12" height="12" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
