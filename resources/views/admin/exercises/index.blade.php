@extends('layouts.admin')
@section('title', 'Kelola Olahraga')

@section('content')
    <div class="space-y-5">

        <div class="flex justify-between items-center">
            <p class="text-sm text-gray-500">Total: {{ $exercises->count() }} olahraga</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-5 py-3 font-medium text-gray-600">Nama</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-600">Kategori</th>
                        <th class="text-center px-5 py-3 font-medium text-gray-600">Impact</th>
                        <th class="text-center px-5 py-3 font-medium text-gray-600">Intensity</th>
                        <th class="text-center px-5 py-3 font-medium text-gray-600">Durasi</th>
                        <th class="text-center px-5 py-3 font-medium text-gray-600">Frekuensi</th>
                        <th class="text-center px-5 py-3 font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($exercises as $exercise)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3.5 font-medium text-gray-900">{{ $exercise->name }}</td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $exercise->category }}</td>
                            <td class="px-5 py-3.5 text-center">
                                <span
                                    class="
                                @if ($exercise->impact_level === 1) badge-green
                                @elseif($exercise->impact_level === 2) badge-yellow
                                @else badge-red @endif">
                                    {{ ['', 'Low', 'Medium', 'High'][$exercise->impact_level] }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span
                                    class="
                                @if ($exercise->intensity_level === 1) badge-green
                                @elseif($exercise->intensity_level === 2) badge-yellow
                                @else badge-red @endif">
                                    {{ ['', 'Low', 'Medium', 'High'][$exercise->intensity_level] }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center text-gray-600">{{ $exercise->duration_min }} menit</td>
                            <td class="px-5 py-3.5 text-center text-gray-600">{{ $exercise->frequency_per_week }}x/minggu
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <a href="{{ route('admin.exercises.edit', $exercise->id) }}"
                                    class="text-primary-600 hover:text-primary-700 font-medium">
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
