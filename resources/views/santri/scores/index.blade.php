@extends('layouts.santri')

@section('title', 'Riwayat Skor')

@section('content')
@php
    // Safe variable defaults
    $paginatedScores = $paginatedScores ?? collect();
    $totalGamesPlayed = $totalGamesPlayed ?? 0;
    $averageScore = $averageScore ?? 0;
    $bestScore = $bestScore ?? 0;
@endphp

<!-- Header with Animation -->
<div class="mb-10" 
     x-data="{ show: false }" 
     x-init="setTimeout(() => show = true, 100)"
     x-show="show"
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-[-20px]">
    <div class="text-center">
        <div class="inline-block mb-4">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-3xl blur-xl opacity-50 animate-pulse"></div>
                <div class="relative bg-gradient-to-br from-emerald-500 to-teal-500 rounded-3xl p-6 shadow-2xl">
                    <span class="text-7xl">📊</span>
                </div>
            </div>
        </div>
        <h1 class="text-4xl sm:text-5xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-3">
            Riwayat Skor
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Lihat semua hasil game yang sudah kamu mainkan dan pantau perkembanganmu! 📈
        </p>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <!-- Total Games -->
    <div x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 300)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-95">
        <div class="group bg-white rounded-2xl shadow-xl p-6 border-2 border-emerald-200 hover:border-emerald-400 transition-all hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-600">Total Game Dimainkan</h3>
                <div class="text-4xl transform group-hover:scale-110 group-hover:rotate-12 transition-transform">🎮</div>
            </div>
            <div class="text-5xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                {{ $totalGamesPlayed }}
            </div>
            <div class="mt-2 text-xs text-gray-500 font-medium">Game selesai</div>
        </div>
    </div>

    <!-- Average Score -->
    <div x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 400)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-95">
        <div class="group bg-white rounded-2xl shadow-xl p-6 border-2 border-blue-200 hover:border-blue-400 transition-all hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-600">Rata-rata Skor</h3>
                <div class="text-4xl transform group-hover:scale-110 group-hover:rotate-12 transition-transform">📈</div>
            </div>
            <div class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                {{ number_format($averageScore, 1) }}%
            </div>
            <div class="mt-2 text-xs text-gray-500 font-medium">Performa rata-rata</div>
        </div>
    </div>

    <!-- Best Score -->
    <div x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 500)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-95">
        <div class="group bg-white rounded-2xl shadow-xl p-6 border-2 border-yellow-200 hover:border-yellow-400 transition-all hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-600">Skor Tertinggi</h3>
                <div class="text-4xl transform group-hover:scale-110 group-hover:rotate-12 transition-transform">🏆</div>
            </div>
            <div class="text-5xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
                {{ number_format($bestScore, 0) }}%
            </div>
            <div class="mt-2 text-xs text-gray-500 font-medium">Prestasi terbaik</div>
        </div>
    </div>

</div>

<!-- Score History Table -->
<div x-data="{ show: false }" 
     x-init="setTimeout(() => show = true, 600)"
     x-show="show"
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 scale-95">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-4 border-emerald-200">
        
        <!-- Table Header -->
        <div class="relative bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 px-6 py-5 overflow-hidden">
            <div class="absolute inset-0" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); background-size: 1000px 100%; animation: shimmer 2s infinite;"></div>
            <h2 class="relative text-2xl font-bold text-white drop-shadow-lg flex items-center gap-3">
                <span class="text-3xl">📋</span>
                <span>Riwayat Lengkap</span>
            </h2>
        </div>

        @if($paginatedScores->count() > 0)
        
        <!-- Table Content (Desktop) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Game
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Skor
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Benar/Total
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Tanggal
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($paginatedScores as $index => $score)
                    <tr class="hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 transition-all group">
                        
                        <!-- Number -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 text-sm font-bold text-emerald-700 group-hover:scale-110 transition-transform">
                                {{ ($paginatedScores->currentPage() - 1) * $paginatedScores->perPage() + $index + 1 }}
                            </span>
                        </td>

                        <!-- Game Info -->
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                @if(is_array($score) || is_object($score))
                                    @php
                                        $scoreType = is_array($score) ? $score['type'] : $score->type;
                                        $gameTitle = is_array($score) ? $score['game_title'] : $score->game_title;
                                    @endphp
                                    
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br 
                                        @if($scoreType == 'listening') from-purple-400 to-indigo-500
                                        @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'tebak_gambar') from-pink-400 to-red-500
                                        @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'kosakata_tempat') from-blue-400 to-indigo-500
                                        @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'pilihan_ganda') from-emerald-400 to-teal-500
                                        @else from-amber-400 to-orange-500
                                        @endif
                                        flex items-center justify-center text-2xl shadow-lg group-hover:scale-110 transition-transform">
                                        @if($scoreType == 'listening')
                                            🎧
                                        @elseif($scoreType == 'regular' && isset($score->game))
                                            @if($score->game->type == 'tebak_gambar')
                                                🖼️
                                            @elseif($score->game->type == 'kosakata_tempat')
                                                🏫
                                            @elseif($score->game->type == 'pilihan_ganda')
                                                ✅
                                            @else
                                                💬
                                            @endif
                                        @else
                                            🎮
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ $gameTitle }}
                                        </div>
                                        <div class="text-xs text-gray-500 font-medium">
                                            @if($scoreType == 'listening')
                                                Listening Game
                                            @elseif($scoreType == 'regular' && isset($score->game))
                                                {{ ucfirst(str_replace('_', ' ', $score->game->type)) }}
                                            @else
                                                Game
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- Score -->
                        <td class="px-6 py-4 text-center">
                            @php
                                $scorePercentage = is_array($score) ? $score['score_percentage'] : $score->score_percentage;
                            @endphp
                            <span class="inline-flex items-center px-5 py-2 rounded-full text-sm font-bold shadow-md
                                @if($scorePercentage >= 80) bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border-2 border-green-300
                                @elseif($scorePercentage >= 60) bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 border-2 border-blue-300
                                @else bg-gradient-to-r from-orange-100 to-red-100 text-orange-700 border-2 border-orange-300
                                @endif
                            ">
                                {{ number_format($scorePercentage, 0) }}%
                            </span>
                        </td>

                        <!-- Correct/Total -->
                        <td class="px-6 py-4 text-center">
                            @php
                                $correctAnswers = is_array($score) ? $score['correct_answers'] : $score->correct_answers;
                                $totalQuestions = is_array($score) ? $score['total_questions'] : $score->total_questions;
                            @endphp
                            <span class="inline-flex items-center gap-1 text-sm font-bold text-gray-900">
                                <span class="text-emerald-600">{{ $correctAnswers }}</span>
                                <span class="text-gray-400">/</span>
                                <span class="text-gray-600">{{ $totalQuestions }}</span>
                            </span>
                        </td>

                        <!-- Date -->
                        <td class="px-6 py-4 text-center">
                            @php
                                $completedAt = is_array($score) ? $score['completed_at'] : $score->completed_at;
                            @endphp
                            <div class="text-sm font-semibold text-gray-900">
                                {{ $completedAt->format('d M Y') }}
                            </div>
                            <div class="text-xs text-gray-500 font-medium">
                                {{ $completedAt->format('H:i') }}
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Card View (Mobile) -->
        <div class="md:hidden p-4 space-y-4">
            @foreach($paginatedScores as $index => $score)
            @php
                $scoreType = is_array($score) ? $score['type'] : $score->type;
                $gameTitle = is_array($score) ? $score['game_title'] : $score->game_title;
                $scorePercentage = is_array($score) ? $score['score_percentage'] : $score->score_percentage;
                $correctAnswers = is_array($score) ? $score['correct_answers'] : $score->correct_answers;
                $totalQuestions = is_array($score) ? $score['total_questions'] : $score->total_questions;
                $completedAt = is_array($score) ? $score['completed_at'] : $score->completed_at;
            @endphp
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-5 shadow-lg border-2 border-gray-200 hover:border-emerald-300 transition-all">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br 
                            @if($scoreType == 'listening') from-purple-400 to-indigo-500
                            @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'tebak_gambar') from-pink-400 to-red-500
                            @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'kosakata_tempat') from-blue-400 to-indigo-500
                            @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'pilihan_ganda') from-emerald-400 to-teal-500
                            @else from-amber-400 to-orange-500
                            @endif
                            flex items-center justify-center text-2xl shadow-md">
                            @if($scoreType == 'listening')
                                🎧
                            @elseif($scoreType == 'regular' && isset($score->game))
                                @if($score->game->type == 'tebak_gambar')
                                    🖼️
                                @elseif($score->game->type == 'kosakata_tempat')
                                    🏫
                                @elseif($score->game->type == 'pilihan_ganda')
                                    ✅
                                @else
                                    💬
                                @endif
                            @else
                                🎮
                            @endif
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">{{ $gameTitle }}</div>
                            <div class="text-xs text-gray-500 font-medium">
                                @if($scoreType == 'listening')
                                    Listening Game
                                @elseif($scoreType == 'regular' && isset($score->game))
                                    {{ ucfirst(str_replace('_', ' ', $score->game->type)) }}
                                @else
                                    Game
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 text-xs font-bold text-emerald-700">
                        #{{ ($paginatedScores->currentPage() - 1) * $paginatedScores->perPage() + $index + 1 }}
                    </span>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-3 mb-3">
                    <div class="text-center">
                        <div class="text-xs text-gray-500 font-semibold mb-1">Skor</div>
                        <div class="px-3 py-1.5 rounded-lg text-sm font-bold
                            @if($scorePercentage >= 80) bg-gradient-to-r from-green-100 to-emerald-100 text-green-700
                            @elseif($scorePercentage >= 60) bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700
                            @else bg-gradient-to-r from-orange-100 to-red-100 text-orange-700
                            @endif
                        ">
                            {{ number_format($scorePercentage, 0) }}%
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-500 font-semibold mb-1">Benar</div>
                        <div class="text-lg font-bold text-emerald-600">{{ $correctAnswers }}/{{ $totalQuestions }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-500 font-semibold mb-1">Tanggal</div>
                        <div class="text-xs font-bold text-gray-900">{{ $completedAt->format('d M') }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t-2 border-gray-200">
            {{ $paginatedScores->links() }}
        </div>

        @else
        
        <!-- Empty State -->
        <div class="p-12 text-center">
            <div class="inline-block mb-6">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-300 to-teal-300 rounded-full blur-2xl opacity-30 animate-pulse"></div>
                    <div class="relative text-9xl animate-bounce">📊</div>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-3">Belum Ada Riwayat</h3>
            <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">
                Kamu belum memainkan game apapun. Ayo mulai bermain dan raih skor terbaikmu! 🎯
            </p>
            <a href="{{ route('santri.games.index') }}"
               class="inline-flex items-center gap-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold px-8 py-4 rounded-xl transition-all shadow-xl hover:shadow-2xl hover:scale-105 active:scale-95">
                <span class="text-2xl">🎮</span>
                <span>Lihat Game</span>
            </a>
        </div>

        @endif

    </div>
</div>

<!-- Tips Section -->
@if($paginatedScores->count() > 0)
<div class="mt-8 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-3xl shadow-2xl p-8 text-white">
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <div class="text-5xl">💡</div>
        <div class="text-center sm:text-left">
            <h3 class="text-2xl font-bold mb-1">Tips Meningkatkan Skor</h3>
            <p class="text-emerald-50">Mainkan game secara rutin dan pelajari dari kesalahan untuk meningkatkan performamu!</p>
        </div>
    </div>
</div>
@endif

<style>
@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}
</style>

@endsection