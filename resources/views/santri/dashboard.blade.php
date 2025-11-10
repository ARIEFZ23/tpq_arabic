@extends('layouts.santri')

@section('title', 'Dashboard Santri')

@section('content')
@php
    $user = $user ?? auth()->user();
    $levelInfo = $levelInfo ?? \App\Helpers\LevelSystem::getLevelInfo($user->experience_points ?? 0);
    $badge = $badge ?? \App\Helpers\LevelSystem::getBadge($user->total_games_completed ?? 0);
    $nextBadge = $nextBadge ?? \App\Helpers\LevelSystem::getNextBadgeRequirement($user->total_games_completed ?? 0);
    $recentScores = $recentScores ?? collect();
    $averageScore = $averageScore ?? 0;
@endphp

<!-- Welcome Section - Nuansa Edukasi Islam -->
<div class="bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-3xl shadow-2xl p-6 sm:p-8 mb-6 text-white relative overflow-hidden">
    <!-- Decorative Pattern -->
    <div class="absolute top-0 right-0 opacity-10">
        <svg class="w-48 h-48" viewBox="0 0 200 200" fill="currentColor">
            <path d="M100,20 L110,50 L140,50 L115,70 L125,100 L100,80 L75,100 L85,70 L60,50 L90,50 Z"/>
        </svg>
    </div>
    
    <div class="relative">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <h1 class="text-2xl sm:text-4xl font-bold mb-2 flex items-center gap-2">
                    <span>السلام عليكم</span>
                    <span class="text-3xl sm:text-4xl">📚</span>
                </h1>
                <p class="text-xl sm:text-2xl font-semibold mb-1">{{ $user->name }}</p>
                <p class="text-base sm:text-lg opacity-90">Mari belajar bahasa Arab dengan semangat!</p>
            </div>
            <div class="hidden sm:flex flex-col items-center gap-2">
                <div class="text-6xl">🕌</div>
                <div class="text-xs font-semibold bg-white/20 px-3 py-1 rounded-full">
                    Level {{ $levelInfo['level'] }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats & Progress Cards - Lebih Compact & Clear -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    
    <!-- Level Card -->
    <div class="bg-white rounded-2xl shadow-lg p-5 border-t-4 border-emerald-500 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-bold text-gray-800">📊 Level Belajar</h3>
            @php
                $levelIcons = [1 => '🌱', 2 => '📚', 3 => '⭐', 4 => '🏆', 5 => '👑'];
                $icon = $levelIcons[$levelInfo['level']] ?? '⭐';
            @endphp
            <span class="text-3xl">{{ $icon }}</span>
        </div>
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 rounded-full mb-2">
                <span class="text-3xl font-bold text-emerald-600">{{ $levelInfo['level'] }}</span>
            </div>
            <div class="text-lg font-semibold text-gray-700 mb-3">{{ $levelInfo['name'] }}</div>
            
            <!-- Progress Bar -->
            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-2.5 rounded-full transition-all duration-500" 
                     style="width: {{ $levelInfo['progress_percentage'] }}%"></div>
            </div>
            <p class="text-sm font-medium text-gray-600">
                {{ $levelInfo['current_xp'] }} / {{ $levelInfo['max_xp'] }} XP
            </p>
        </div>
    </div>

    <!-- Badge Card -->
    <div class="bg-white rounded-2xl shadow-lg p-5 border-t-4 border-amber-500 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-bold text-gray-800">🏆 Prestasi</h3>
            <span class="text-2xl">{{ $badge['emoji'] }}</span>
        </div>
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-amber-50 rounded-full mb-2">
                <span class="text-5xl">{{ $badge['emoji'] }}</span>
            </div>
            <div class="text-lg font-bold text-gray-800">{{ $badge['name'] }}</div>
            <div class="mt-2 bg-amber-50 rounded-lg p-2">
                <p class="text-sm font-semibold text-amber-700">
                    {{ $user->total_games_completed }} / {{ $nextBadge['target'] }} games
                </p>
                @if($nextBadge['remaining'] > 0)
                    <p class="text-xs text-amber-600 mt-1">
                        🎯 {{ $nextBadge['remaining'] }} lagi untuk naik!
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="bg-white rounded-2xl shadow-lg p-5 border-t-4 border-blue-500 hover:shadow-xl transition-shadow duration-300 sm:col-span-2 lg:col-span-1">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-bold text-gray-800">📈 Statistik</h3>
            <span class="text-2xl">📊</span>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between items-center p-2 bg-blue-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">Total XP</span>
                <span class="text-xl font-bold text-blue-600">{{ $user->experience_points }}</span>
            </div>
            <div class="flex justify-between items-center p-2 bg-emerald-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">Games Selesai</span>
                <span class="text-xl font-bold text-emerald-600">{{ $user->total_games_completed }}</span>
            </div>
            <div class="flex justify-between items-center p-2 bg-amber-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">Rata-rata Nilai</span>
                <span class="text-xl font-bold text-amber-600">{{ number_format($averageScore ?? 0, 1) }}%</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
@if($recentScores->count() > 0)
<div class="bg-white rounded-2xl shadow-lg p-5 mb-6 border-l-4 border-teal-500">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
            <span>📝</span> Aktivitas Terakhir
        </h2>
        <a href="{{ route('santri.scores') }}" 
           class="text-sm font-semibold text-teal-600 hover:text-teal-700 px-3 py-1 rounded-lg hover:bg-teal-50 transition-colors">
            Lihat Semua →
        </a>
    </div>
    <div class="space-y-2">
        @foreach($recentScores->take(3) as $score)
        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-white border border-gray-100 rounded-xl hover:shadow-md transition-all duration-200">
            <div class="flex items-center gap-3 flex-1 min-w-0">
                <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-gradient-to-br from-teal-100 to-emerald-100 rounded-lg">
                    <span class="text-2xl">
                        @if($score->game->type == 'tebak_gambar') 🖼️
                        @elseif($score->game->type == 'kosakata_tempat') 🏫
                        @elseif($score->game->type == 'pilihan_ganda') ✅
                        @else 💬
                        @endif
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-gray-800 text-sm truncate">{{ $score->game->title }}</h4>
                    <p class="text-xs text-gray-500">{{ $score->completed_at->diffForHumans() }}</p>
                </div>
            </div>
            <div class="text-right flex-shrink-0 ml-3">
                <div class="text-xl font-bold text-teal-600">{{ number_format($score->score, 0) }}%</div>
                <div class="text-xs text-gray-500">{{ $score->correct_answers }}/{{ $score->total_questions }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Quick Actions Section - DITAMBAHKAN -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2 mb-4">
        <span>⚡</span> Akses Cepat
    </h2>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        
        <!-- Leaderboard Card - BARU! -->
        <a href="{{ route('santri.leaderboard') }}" 
           class="group bg-gradient-to-br from-yellow-400 via-orange-400 to-red-500 rounded-2xl shadow-lg p-4 sm:p-5 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95 relative overflow-hidden">
            <!-- Shine Effect -->
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 translate-x-full group-hover:translate-x-[-200%] transition-transform duration-1000"></div>
            
            <div class="text-center relative z-10">
                <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors backdrop-blur-sm">
                    <span class="text-4xl animate-bounce">🏆</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold mb-1">Papan Peringkat</h3>
                <p class="text-xs sm:text-sm opacity-90">Lihat ranking</p>
            </div>
        </a>

        <!-- Scores Card -->
        <a href="{{ route('santri.scores') }}" 
           class="group bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl shadow-lg p-4 sm:p-5 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                    <span class="text-4xl">📊</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold mb-1">Riwayat Skor</h3>
                <p class="text-xs sm:text-sm opacity-90">Lihat nilai</p>
            </div>
        </a>

        <!-- Profile Card -->
        <a href="{{ route('santri.profile') }}" 
           class="group bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl shadow-lg p-4 sm:p-5 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                    <span class="text-4xl">👤</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold mb-1">Profil Saya</h3>
                <p class="text-xs sm:text-sm opacity-90">Edit profil</p>
            </div>
        </a>

        <!-- All Games Card -->
        <a href="{{ route('santri.games') }}" 
           class="group bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl shadow-lg p-4 sm:p-5 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                    <span class="text-4xl">🎮</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold mb-1">Semua Game</h3>
                <p class="text-xs sm:text-sm opacity-90">Main sekarang</p>
            </div>
        </a>

    </div>
</div>

<!-- Games Section - More Accessible -->
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <span>🎮</span> Pilih Game Belajar
        </h2>
        <a href="{{ route('santri.games') }}" 
           class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 px-4 py-2 rounded-lg hover:bg-emerald-50 transition-colors">
            Semua Game →
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        
        <!-- Game Card 1 -->
        <a href="{{ route('santri.games') }}" 
           class="group bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl shadow-lg p-4 sm:p-5 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                    <span class="text-4xl">🖼️</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold mb-1">Tebak Gambar</h3>
                <p class="text-xs sm:text-sm opacity-90">Tebak kosakata</p>
            </div>
        </a>

        <!-- Game Card 2 -->
        <a href="{{ route('santri.games') }}" 
           class="group bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl shadow-lg p-4 sm:p-5 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                    <span class="text-4xl">🏫</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold mb-1">Kosakata Tempat</h3>
                <p class="text-xs sm:text-sm opacity-90">30 tempat</p>
            </div>
        </a>

        <!-- Game Card 3 -->
        <a href="{{ route('santri.games') }}" 
           class="group bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl shadow-lg p-4 sm:p-5 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                    <span class="text-4xl">✅</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold mb-1">Pilihan Ganda</h3>
                <p class="text-xs sm:text-sm opacity-90">Lengkapi kalimat</p>
            </div>
        </a>

        <!-- Game Card 4 -->
        <a href="{{ route('santri.games') }}" 
           class="group bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl shadow-lg p-4 sm:p-5 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                    <span class="text-4xl">💬</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold mb-1">Percakapan</h3>
                <p class="text-xs sm:text-sm opacity-90">20 dialog</p>
            </div>
        </a>

    </div>
</div>

<!-- Motivational Quote - Islamic Theme -->
<div class="bg-gradient-to-br from-teal-50 to-emerald-50 rounded-2xl shadow-lg p-6 sm:p-8 text-center border-2 border-emerald-200">
    <div class="mb-3">
        <span class="text-4xl">📖</span>
    </div>
    <p class="text-xl sm:text-3xl font-bold text-emerald-800 mb-2 font-arabic">
        من جدّ وجد
    </p>
    <p class="text-base sm:text-lg text-gray-700 font-semibold">
        "Siapa yang bersungguh-sungguh, pasti berhasil!"
    </p>
    <p class="text-sm text-gray-500 mt-2">
        Tetap semangat belajar! 🌟
    </p>
</div>
@endsection