@extends('layouts.admin')
@section('title', 'Edit Olahraga: ' . $exercise->name)

@section('content')
    <div class="max-w-2xl space-y-5">

        <a href="{{ route('admin.exercises.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar
        </a>

        <div class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-100 dark:border-white/[0.07] p-6">
            <form method="POST" action="{{ route('admin.exercises.update', $exercise->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-5">

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama
                            Olahraga</label>
                        <input type="text" name="name" value="{{ old('name', $exercise->name) }}"
                            class="block w-full px-4 py-2.5 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-white/[0.1] rounded-xl bg-white dark:bg-white/[0.05] focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-colors placeholder:text-gray-400 dark:placeholder:text-gray-600 @error('name') border-red-400 @enderror"
                            required>
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kategori</label>
                        <input type="text" name="category" value="{{ old('category', $exercise->category) }}"
                            class="block w-full px-4 py-2.5 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-white/[0.1] rounded-xl bg-white dark:bg-white/[0.05] focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-colors"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Durasi
                            (menit)</label>
                        <input type="number" name="duration_min" value="{{ old('duration_min', $exercise->duration_min) }}"
                            min="5"
                            class="block w-full px-4 py-2.5 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-white/[0.1] rounded-xl bg-white dark:bg-white/[0.05] focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-colors"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Impact
                            Level</label>
                        <select name="impact_level"
                            class="block w-full px-4 py-2.5 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-white/[0.1] rounded-xl bg-white dark:bg-white/[0.05] focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-colors"
                            required>
                            @foreach ([1 => 'Low', 2 => 'Medium', 3 => 'High'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('impact_level', $exercise->impact_level) == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Intensity
                            Level</label>
                        <select name="intensity_level"
                            class="block w-full px-4 py-2.5 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-white/[0.1] rounded-xl bg-white dark:bg-white/[0.05] focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-colors"
                            required>
                            @foreach ([1 => 'Low', 2 => 'Medium', 3 => 'High'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('intensity_level', $exercise->intensity_level) == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Frekuensi per
                            Minggu</label>
                        <input type="number" name="frequency_per_week"
                            value="{{ old('frequency_per_week', $exercise->frequency_per_week) }}" min="1"
                            max="7"
                            class="block w-full px-4 py-2.5 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-white/[0.1] rounded-xl bg-white dark:bg-white/[0.05] focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-colors"
                            required>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="3"
                            class="block w-full px-4 py-2.5 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-white/[0.1] rounded-xl bg-white dark:bg-white/[0.05] focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-colors resize-none">{{ old('description', $exercise->description) }}</textarea>
                    </div>

                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all"
                        style="background:linear-gradient(135deg,#6366f1,#7c3aed);box-shadow:0 4px 12px rgba(99,102,241,0.3);"
                        onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.exercises.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-white/[0.06] hover:bg-gray-200 dark:hover:bg-white/[0.1] transition-colors">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
@endsection
