@extends('layouts.app')
@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">

        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Profil Saya</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Data fisik digunakan untuk menghitung BMI dan menentukan
                kategori usia.</p>
        </div>

        {{-- FIX #5: $profile di sini sudah fresh dari controller --}}
        {{-- Pastikan ProfileController@index dan ProfileController@update me-redirect ke route('profile.index') --}}
        {{-- dan DashboardController juga mengambil fresh $profile dari DB --}}

        {{-- BMI Result Card --}}
        @if ($profile?->bmi)
            @php
                $bmiVal = (float) $profile->bmi;
                $bmiMin = 10;
                $bmiMax = 45;
                $bmiClamped = min(max($bmiVal, $bmiMin), $bmiMax);
                $bmiPercent = round((($bmiClamped - $bmiMin) / ($bmiMax - $bmiMin)) * 100, 1);

                $bmiColors = [
                    'Normal' => [
                        'text' => 'text-green-600 dark:text-green-400',
                        'badge' => 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400',
                        'dot' => '#22c55e',
                    ],
                    'Underweight' => [
                        'text' => 'text-blue-600 dark:text-blue-400',
                        'badge' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400',
                        'dot' => '#60a5fa',
                    ],
                    'Overweight' => [
                        'text' => 'text-amber-600 dark:text-amber-400',
                        'badge' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400',
                        'dot' => '#f59e0b',
                    ],
                    'Obesitas' => [
                        'text' => 'text-red-600 dark:text-red-400',
                        'badge' => 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400',
                        'dot' => '#ef4444',
                    ],
                ];
                $bmiColor = $bmiColors[$profile->bmi_category] ?? $bmiColors['Obesitas'];
            @endphp
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/[0.06] p-5">
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4">Hasil
                    Kalkulasi Saat Ini</p>
                <div class="flex items-center gap-6">
                    <div>
                        <p class="text-5xl font-extrabold {{ $bmiColor['text'] }} tracking-tight leading-none">
                            {{ $profile->bmi }}</p>
                        <span
                            class="mt-2 inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold {{ $bmiColor['badge'] }}">
                            {{ $profile->bmi_category }}
                        </span>
                    </div>
                    <div class="w-px bg-gray-100 dark:bg-white/[0.06]" style="height:64px;"></div>
                    <div class="space-y-1.5 flex-1">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400 dark:text-gray-500">Kategori BMI</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $profile->bmi_category }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400 dark:text-gray-500">Kategori Usia</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $profile->age_category }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400 dark:text-gray-500">Nilai BMI</span>
                            <span class="text-sm font-semibold {{ $bmiColor['text'] }}">{{ $profile->bmi }}</span>
                        </div>
                    </div>
                </div>

                {{-- FIX #6: BMI scale bar dengan dot indikator --}}
                <div class="mt-5">
                    <div class="relative">
                        <div class="flex h-2.5 rounded-full overflow-hidden gap-px">
                            <div style="flex:28" class="bg-blue-300 dark:bg-blue-500/50"></div>
                            <div style="flex:22" class="bg-green-400 dark:bg-green-500/60"></div>
                            <div style="flex:17" class="bg-amber-300 dark:bg-amber-500/50"></div>
                            <div style="flex:33" class="bg-red-300 dark:bg-red-500/50"></div>
                        </div>
                        {{-- Dot indikator posisi BMI user --}}
                        <div class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 z-10"
                            style="left: {{ $bmiPercent }}%;">
                            <div class="w-4 h-4 rounded-full border-2 border-white dark:border-gray-900 shadow-lg"
                                style="background-color: {{ $bmiColor['dot'] }};"></div>
                        </div>
                    </div>
                    {{-- Tick marks & labels --}}
                    <div class="flex justify-between mt-1.5">
                        <span class="text-gray-400 dark:text-gray-600" style="font-size:9px;">10</span>
                        <span class="text-gray-400 dark:text-gray-600" style="font-size:9px;">18.5</span>
                        <span class="text-gray-400 dark:text-gray-600" style="font-size:9px;">25</span>
                        <span class="text-gray-400 dark:text-gray-600" style="font-size:9px;">30</span>
                        <span class="text-gray-400 dark:text-gray-600" style="font-size:9px;">45+</span>
                    </div>
                    <div class="flex justify-between mt-0.5">
                        <span class="text-blue-400" style="font-size:9px;">Kurus</span>
                        <span class="text-green-500" style="font-size:9px;">Normal</span>
                        <span class="text-amber-400" style="font-size:9px;">Gemuk</span>
                        <span class="text-red-400" style="font-size:9px;">Obesitas</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/[0.06] overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-white/[0.06]">
                <p class="text-sm font-bold text-gray-900 dark:text-white">Data Fisik</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Pastikan data sudah benar agar rekomendasi akurat
                </p>
            </div>

            <form method="POST" action="{{ $profile ? route('profile.update') : route('profile.store') }}"
                class="p-5 space-y-5">
                @csrf
                @if ($profile)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-2 gap-5">

                    {{-- Usia --}}
                    <div>
                        <label for="age" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                            Usia (tahun)
                        </label>
                        <input type="number" id="age" name="age" value="{{ old('age', $profile?->age) }}"
                            min="5" max="100" placeholder="30"
                            class="w-full px-4 py-3 text-sm rounded-xl border transition-all
                            bg-gray-50 dark:bg-white/[0.05]
                            border-gray-200 dark:border-white/[0.1]
                            text-gray-900 dark:text-white
                            placeholder-gray-400 dark:placeholder-gray-600
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                            @error('age') border-red-400 dark:border-red-500 @enderror"
                            required>
                        @error('age')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gender --}}
                    <div>
                        <label for="gender" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                            Jenis Kelamin
                        </label>
                        {{-- FIX #3: select dark mode sudah di-handle oleh .dark select di CSS global --}}
                        <select id="gender" name="gender"
                            class="w-full px-4 py-3 text-sm rounded-xl border transition-all
                            bg-gray-50 dark:bg-gray-800
                            border-gray-200 dark:border-white/[0.1]
                            text-gray-900 dark:text-white
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                            @error('gender') border-red-400 dark:border-red-500 @enderror"
                            required>
                            <option value="">Pilih...</option>
                            <option value="L" {{ old('gender', $profile?->gender) === 'L' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="P" {{ old('gender', $profile?->gender) === 'P' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tinggi --}}
                    <div>
                        <label for="height_cm" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                            Tinggi Badan (cm)
                        </label>
                        <input type="number" id="height_cm" name="height_cm"
                            value="{{ old('height_cm', $profile?->height_cm) }}" min="50" max="250"
                            step="0.1" placeholder="170"
                            class="w-full px-4 py-3 text-sm rounded-xl border transition-all
                            bg-gray-50 dark:bg-white/[0.05]
                            border-gray-200 dark:border-white/[0.1]
                            text-gray-900 dark:text-white
                            placeholder-gray-400 dark:placeholder-gray-600
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                            @error('height_cm') border-red-400 dark:border-red-500 @enderror"
                            required>
                        @error('height_cm')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Berat --}}
                    <div>
                        <label for="weight_kg" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                            Berat Badan (kg)
                        </label>
                        <input type="number" id="weight_kg" name="weight_kg"
                            value="{{ old('weight_kg', $profile?->weight_kg) }}" min="10" max="300"
                            step="0.1" placeholder="70"
                            class="w-full px-4 py-3 text-sm rounded-xl border transition-all
                            bg-gray-50 dark:bg-white/[0.05]
                            border-gray-200 dark:border-white/[0.1]
                            text-gray-900 dark:text-white
                            placeholder-gray-400 dark:placeholder-gray-600
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                            @error('weight_kg') border-red-400 dark:border-red-500 @enderror"
                            required>
                        @error('weight_kg')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="flex items-center gap-3 pt-2 border-t border-gray-100 dark:border-white/[0.06]">
                    <button type="submit"
                        class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-colors"
                        style="box-shadow:0 2px 8px rgba(22,163,74,0.25);">
                        {{ $profile ? 'Update Profil' : 'Simpan Profil' }}
                    </button>
                    @if ($profile)
                        <a href="{{ route('recommendation.create') }}"
                            class="px-5 py-2.5 border border-gray-200 dark:border-white/[0.1] text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                            Dapatkan Rekomendasi →
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{--
        FIX #5 — Catatan untuk ProfileController:
        Pastikan method store() dan update() di ProfileController melakukan:

        1. Hitung BMI dan kategori:
           $bmi = round($request->weight_kg / pow($request->height_cm / 100, 2), 1);
           $bmiCategory = match(true) {
               $bmi < 18.5 => 'Underweight',
               $bmi < 25   => 'Normal',
               $bmi < 30   => 'Overweight',
               default     => 'Obesitas',
           };
           $ageCategory = match(true) {
               $request->age < 13 => 'Anak-anak',
               $request->age < 18 => 'Remaja',
               $request->age < 50 => 'Dewasa',
               default            => 'Lansia',
           };

        2. Simpan semua field termasuk bmi, bmi_category, age_category

        3. Redirect dengan flash:
           return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');

        JANGAN redirect ke dashboard — karena dashboard perlu fresh data dari profile.index
    --}}

    </div>
@endsection
