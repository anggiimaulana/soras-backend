<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SORAS') }} — @yield('title', 'Sistem Rekomendasi Olahraga')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">

    <div class="min-h-full">

        {{-- Navbar --}}
        <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">

                    {{-- Logo + Nav Links --}}
                    <div class="flex items-center gap-8">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span class="font-bold text-gray-900 text-lg">SORAS</span>
                        </a>

                        <div class="hidden md:flex items-center gap-1">
                            <a href="{{ route('dashboard') }}"
                                class="px-3 py-2 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('recommendation.create') }}"
                                class="px-3 py-2 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('recommendation.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                                Rekomendasi
                            </a>
                            <a href="{{ route('history.index') }}"
                                class="px-3 py-2 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('history.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                                Riwayat
                            </a>
                        </div>
                    </div>

                    {{-- User Menu --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('profile.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">
                            <div class="w-7 h-7 bg-primary-100 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-primary-700">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <span class="hidden md:block">{{ auth()->user()->name }}</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="px-3 py-2 rounded-lg text-sm font-medium text-gray-500 hover:text-red-600 hover:bg-red-50 transition-colors">
                                Keluar
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </nav>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div
                    class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800 text-sm">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('warning'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div
                    class="flex items-center gap-3 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800 text-sm">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('warning') }}
                </div>
            </div>
        @endif

        {{-- Page Content --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>

    </div>

</body>

</html>
