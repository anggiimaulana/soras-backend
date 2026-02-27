@extends('layouts.app')
@section('title', 'Dapatkan Rekomendasi')
@section('page_title', 'Rekomendasi Baru')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Dapatkan Rekomendasi</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Isi kondisi dan tujuan olahraga kamu untuk mendapatkan
                rekomendasi yang tepat.</p>
        </div>

        <form method="POST" action="{{ route('recommendation.generate') }}" class="space-y-5" id="rec-form">
            @csrf

            {{-- ── Step 1: Primary Complaint ─────────────────── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/5 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-white/5 flex items-center gap-3">
                    <div
                        class="w-7 h-7 rounded-lg bg-red-100 dark:bg-red-500/20 flex items-center justify-center flex-shrink-0">
                        <span class="text-xs font-bold text-red-600 dark:text-red-400">1</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">Keluhan Utama <span
                                class="text-red-500">*</span></p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Satu kondisi yang paling dominan kamu rasakan
                        </p>
                    </div>
                </div>
                <div class="p-5">
                    <select id="primary_complaint_id" name="primary_complaint_id"
                        class="w-full px-4 py-3 text-sm bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('primary_complaint_id') border-red-400 @enderror"
                        required>
                        <option value="">— Pilih Keluhan Utama —</option>
                        @foreach ($complaints as $complaint)
                            <option value="{{ $complaint->id }}"
                                {{ old('primary_complaint_id') == $complaint->id ? 'selected' : '' }}>
                                {{ $complaint->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('primary_complaint_id')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ── Step 2: Secondary Complaints ──────────────── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/5 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-white/5 flex items-center gap-3">
                    <div
                        class="w-7 h-7 rounded-lg bg-orange-100 dark:bg-orange-500/20 flex items-center justify-center flex-shrink-0">
                        <span class="text-xs font-bold text-orange-600 dark:text-orange-400">2</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            Keluhan Tambahan
                            <span class="text-xs font-normal text-gray-400 ml-1">opsional · maks. 3</span>
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Keluhan lain yang juga kamu rasakan</p>
                    </div>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($complaints as $complaint)
                            <label
                                class="secondary-label flex items-center gap-2.5 p-3 border border-gray-200 dark:border-white/10 rounded-xl cursor-pointer transition-all hover:bg-gray-50 dark:hover:bg-white/5 has-[:checked]:border-green-400 dark:has-[:checked]:border-green-500/50 has-[:checked]:bg-green-50 dark:has-[:checked]:bg-green-500/10">
                                <input type="checkbox" name="secondary_complaint_ids[]" value="{{ $complaint->id }}"
                                    data-id="{{ $complaint->id }}"
                                    class="secondary-cb rounded border-gray-300 dark:border-white/20 text-green-600 focus:ring-green-500 bg-white dark:bg-white/10"
                                    {{ in_array($complaint->id, old('secondary_complaint_ids', [])) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $complaint->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('secondary_complaint_ids')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ── Step 3: Goal ────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/5 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-white/5 flex items-center gap-3">
                    <div
                        class="w-7 h-7 rounded-lg bg-green-100 dark:bg-green-500/20 flex items-center justify-center flex-shrink-0">
                        <span class="text-xs font-bold text-green-700 dark:text-green-400">3</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">Tujuan Latihan <span
                                class="text-red-500">*</span></p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Satu tujuan utama yang ingin kamu capai</p>
                    </div>
                </div>
                <div class="p-5">
                    <div class="space-y-2">
                        @foreach ($goals as $goal)
                            <label
                                class="flex items-center gap-3 p-3.5 border border-gray-200 dark:border-white/10 rounded-xl cursor-pointer transition-all hover:bg-gray-50 dark:hover:bg-white/5 has-[:checked]:border-green-400 dark:has-[:checked]:border-green-500/50 has-[:checked]:bg-green-50 dark:has-[:checked]:bg-green-500/10">
                                <input type="radio" name="goal_id" value="{{ $goal->id }}"
                                    class="text-green-600 focus:ring-green-500 border-gray-300 dark:border-white/20 bg-white dark:bg-white/10"
                                    {{ old('goal_id') == $goal->id ? 'checked' : '' }} required>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $goal->name }}</p>
                                    @if ($goal->description)
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $goal->description }}
                                        </p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('goal_id')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ── Disclaimer ──────────────────────────────────── --}}
            <div
                class="flex items-start gap-3 p-4 bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20 rounded-xl">
                <svg class="w-4 h-4 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs text-blue-700 dark:text-blue-400">
                    Rekomendasi ini bersifat informatif dan tidak menggantikan konsultasi dengan tenaga medis profesional.
                </p>
            </div>

            {{-- ── Submit ────────────────────────────────────────── --}}
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl shadow-sm shadow-green-600/25 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Dapatkan Rekomendasi Saya
            </button>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const primarySelect = document.getElementById('primary_complaint_id');
            const secondaryCbs = document.querySelectorAll('.secondary-cb');

            function update() {
                const primaryVal = parseInt(primarySelect.value);
                const checkedCbs = [...secondaryCbs].filter(cb => cb.checked);

                secondaryCbs.forEach(cb => {
                    const label = cb.closest('label');
                    const val = parseInt(cb.dataset.id);
                    const isSameAsPrimary = val === primaryVal;
                    const maxReached = checkedCbs.length >= 3 && !cb.checked;

                    const disabled = isSameAsPrimary || (maxReached && !isSameAsPrimary);
                    cb.disabled = disabled;

                    if (isSameAsPrimary) cb.checked = false;

                    label.classList.toggle('opacity-40', disabled);
                    label.classList.toggle('cursor-not-allowed', disabled);
                    label.classList.toggle('cursor-pointer', !disabled);
                });
            }

            primarySelect.addEventListener('change', update);
            secondaryCbs.forEach(cb => cb.addEventListener('change', update));
            update();
        });
    </script>
@endsection
