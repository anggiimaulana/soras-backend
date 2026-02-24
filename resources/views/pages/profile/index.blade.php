@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
            <p class="text-gray-500 mt-1">Data fisik kamu digunakan untuk menghitung BMI dan kategori usia.</p>
        </div>

        <div class="card">
            <form method="POST" action="{{ $profile ? route('profile.update') : route('profile.store') }}" class="space-y-5">
                @csrf
                @if ($profile)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-2 gap-5">

                    {{-- Usia --}}
                    <div>
                        <label for="age" class="form-label">Usia (tahun)</label>
                        <input type="number" id="age" name="age" value="{{ old('age', $profile?->age) }}"
                            min="5" max="100" placeholder="30"
                            class="form-input @error('age') border-red-400 @enderror" required>
                        @error('age')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gender --}}
                    <div>
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select id="gender" name="gender" class="form-input @error('gender') border-red-400 @enderror"
                            required>
                            <option value="">Pilih...</option>
                            <option value="L" {{ old('gender', $profile?->gender) === 'L' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="P" {{ old('gender', $profile?->gender) === 'P' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        @error('gender')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tinggi --}}
                    <div>
                        <label for="height_cm" class="form-label">Tinggi Badan (cm)</label>
                        <input type="number" id="height_cm" name="height_cm"
                            value="{{ old('height_cm', $profile?->height_cm) }}" min="50" max="250"
                            step="0.1" placeholder="170" class="form-input @error('height_cm') border-red-400 @enderror"
                            required>
                        @error('height_cm')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Berat --}}
                    <div>
                        <label for="weight_kg" class="form-label">Berat Badan (kg)</label>
                        <input type="number" id="weight_kg" name="weight_kg"
                            value="{{ old('weight_kg', $profile?->weight_kg) }}" min="10" max="300"
                            step="0.1" placeholder="70" class="form-input @error('weight_kg') border-red-400 @enderror"
                            required>
                        @error('weight_kg')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- BMI Info (readonly) --}}
                @if ($profile?->bmi)
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-sm font-medium text-gray-700 mb-2">Hasil Kalkulasi Terakhir</p>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">BMI</p>
                                <p class="font-bold text-gray-900">{{ $profile->bmi }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Kategori BMI</p>
                                <p class="font-bold text-gray-900">{{ $profile->bmi_category }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Kategori Usia</p>
                                <p class="font-bold text-gray-900">{{ $profile->age_category }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        {{ $profile ? 'Update Profil' : 'Simpan Profil' }}
                    </button>
                    @if ($profile)
                        <a href="{{ route('recommendation.create') }}" class="btn-secondary">
                            Dapatkan Rekomendasi →
                        </a>
                    @endif
                </div>

            </form>
        </div>

    </div>
@endsection
