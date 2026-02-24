@extends('layouts.app')
@section('title', 'Dapatkan Rekomendasi')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dapatkan Rekomendasi Olahraga</h1>
            <p class="text-gray-500 mt-1">Isi form di bawah untuk mendapatkan rekomendasi yang sesuai kondisimu.</p>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('recommendation.generate') }}" class="space-y-6">
                @csrf

                {{-- Primary Complaint --}}
                <div>
                    <label for="primary_complaint_id" class="form-label">
                        Keluhan Utama <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-2">
                        Pilih satu keluhan yang paling dominan kamu rasakan saat ini.
                    </p>
                    <select id="primary_complaint_id" name="primary_complaint_id"
                        class="form-input @error('primary_complaint_id') border-red-400 @enderror" required>
                        <option value="">— Pilih Keluhan Utama —</option>
                        @foreach ($complaints as $complaint)
                            <option value="{{ $complaint->id }}"
                                {{ old('primary_complaint_id') == $complaint->id ? 'selected' : '' }}>
                                {{ $complaint->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('primary_complaint_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Secondary Complaints --}}
                <div>
                    <label class="form-label">
                        Keluhan Tambahan
                        <span class="text-xs font-normal text-gray-400">(opsional, maksimal 3)</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-3">
                        Pilih keluhan lain yang juga kamu rasakan. Tidak boleh sama dengan keluhan utama.
                    </p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($complaints as $complaint)
                            <label
                                class="flex items-center gap-2.5 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors has-[:checked]:border-primary-400 has-[:checked]:bg-primary-50">
                                <input type="checkbox" name="secondary_complaint_ids[]" value="{{ $complaint->id }}"
                                    class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                                    {{ in_array($complaint->id, old('secondary_complaint_ids', [])) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">{{ $complaint->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('secondary_complaint_ids')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Goal --}}
                <div>
                    <label for="goal_id" class="form-label">
                        Tujuan Latihan <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-3">
                        Pilih satu tujuan utama yang ingin kamu capai dari olahraga.
                    </p>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach ($goals as $goal)
                            <label
                                class="flex items-center gap-3 p-3.5 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors has-[:checked]:border-primary-400 has-[:checked]:bg-primary-50">
                                <input type="radio" name="goal_id" value="{{ $goal->id }}"
                                    class="text-primary-600 focus:ring-primary-500"
                                    {{ old('goal_id') == $goal->id ? 'checked' : '' }} required>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $goal->name }}</p>
                                    @if ($goal->description)
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $goal->description }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('goal_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Disclaimer --}}
                <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl text-sm text-blue-700">
                    ⚠️ Rekomendasi ini bersifat informatif dan tidak menggantikan konsultasi dengan tenaga medis
                    profesional.
                </div>

                <button type="submit" class="btn-primary w-full py-3 text-base">
                    Dapatkan Rekomendasi Saya →
                </button>

            </form>
        </div>

    </div>

    {{-- JS: limit secondary max 3, disable primary di secondary --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const primarySelect = document.getElementById('primary_complaint_id');
            const secondaryBoxes = document.querySelectorAll('input[name="secondary_complaint_ids[]"]');

            function updateSecondary() {
                const primaryVal = parseInt(primarySelect.value);
                const checked = [...secondaryBoxes].filter(cb => cb.checked);

                secondaryBoxes.forEach(cb => {
                    const val = parseInt(cb.value);

                    // Disable kalau sama dengan primary
                    if (val === primaryVal) {
                        cb.checked = false;
                        cb.disabled = true;
                        cb.closest('label').classList.add('opacity-40', 'cursor-not-allowed');
                        cb.closest('label').classList.remove('cursor-pointer');
                    } else {
                        cb.disabled = false;
                        cb.closest('label').classList.remove('opacity-40', 'cursor-not-allowed');
                        cb.closest('label').classList.add('cursor-pointer');
                    }

                    // Disable yang unchecked kalau sudah 3 yang checked
                    if (checked.length >= 3 && !cb.checked && val !== primaryVal) {
                        cb.disabled = true;
                        cb.closest('label').classList.add('opacity-40', 'cursor-not-allowed');
                    }
                });
            }

            primarySelect.addEventListener('change', updateSecondary);
            secondaryBoxes.forEach(cb => cb.addEventListener('change', updateSecondary));
            updateSecondary();
        });
    </script>

@endsection
