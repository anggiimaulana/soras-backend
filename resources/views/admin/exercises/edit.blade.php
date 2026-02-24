@extends('layouts.admin')
@section('title', 'Edit Olahraga: ' . $exercise->name)

@section('content')
    <div class="max-w-2xl space-y-5">

        <a href="{{ route('admin.exercises.index') }}"
            class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
            ← Kembali
        </a>

        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <form method="POST" action="{{ route('admin.exercises.update', $exercise->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-5">

                    <div class="col-span-2">
                        <label class="form-label">Nama Olahraga</label>
                        <input type="text" name="name" value="{{ old('name', $exercise->name) }}"
                            class="form-input @error('name') border-red-400 @enderror" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" value="{{ old('category', $exercise->category) }}"
                            class="form-input" required>
                    </div>

                    <div>
                        <label class="form-label">Durasi (menit)</label>
                        <input type="number" name="duration_min" value="{{ old('duration_min', $exercise->duration_min) }}"
                            min="5" class="form-input" required>
                    </div>

                    <div>
                        <label class="form-label">Impact Level</label>
                        <select name="impact_level" class="form-input" required>
                            @foreach ([1 => 'Low', 2 => 'Medium', 3 => 'High'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('impact_level', $exercise->impact_level) == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Intensity Level</label>
                        <select name="intensity_level" class="form-input" required>
                            @foreach ([1 => 'Low', 2 => 'Medium', 3 => 'High'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('intensity_level', $exercise->intensity_level) == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Frekuensi per Minggu</label>
                        <input type="number" name="frequency_per_week"
                            value="{{ old('frequency_per_week', $exercise->frequency_per_week) }}" min="1"
                            max="7" class="form-input" required>
                    </div>

                    <div class="col-span-2">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" rows="3" class="form-input resize-none">{{ old('description', $exercise->description) }}</textarea>
                    </div>

                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.exercises.index') }}" class="btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
@endsection
