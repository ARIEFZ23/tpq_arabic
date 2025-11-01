<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Santri - TPQ Arabic Learning</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts - Poppins (Fun & Modern) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 to-blue-50 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-purple-600">🕌 TPQ Arabic</span>
                </div>
                
                <!-- Navigation -->
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('santri.dashboard') }}" class="text-purple-600 font-semibold border-b-2 border-purple-600 px-3 py-2">
                        Dashboard
                    </a>
                    <a href="{{ route('santri.games') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2">
                        Games
                    </a>
                    <a href="{{ route('santri.scores') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2">
                        Skor Saya
                    </a>
                    <a href="{{ route('santri.profile') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2">
                        Profile
                    </a>
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 font-medium">{{ $user->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Welcome Section -->
        <div class="gradient-bg rounded-2xl shadow-2xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Assalamu'alaikum, {{ $user->name }}! 👋</h1>
                    <p class="text-xl opacity-90">Semangat belajar bahasa Arab hari ini!</p>
                </div>
                <div class="text-6xl">🌟</div>
            </div>
        </div>

        <!-- Stats & Level Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Level Card -->
            <div class="bg-white rounded-2xl shadow-xl p-6 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Level Kamu</h3>
                    @php
                        // Icon berdasarkan level
                        $levelIcons = [
                            1 => '🌱',
                            2 => '📚', 
                            3 => '⭐',
                            4 => '🏆',
                            5 => '👑'
                        ];
                        $icon = $levelIcons[$levelInfo['level']] ?? '⭐';
                    @endphp
                    <span class="text-3xl">{{ $icon }}</span>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">{{ $levelInfo['level'] }}</div>
                    <div class="text-xl font-semibold text-gray-700 mb-4">{{ $levelInfo['name'] }}</div>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-3 rounded-full" 
                             style="width: {{ $levelInfo['progress_percentage'] }}%"></div>
                    </div>
                    <p class="text-sm text-gray-600">
                        {{ $levelInfo['current_xp'] }} / {{ $levelInfo['max_xp'] }} XP
                    </p>
                </div>
            </div>

            <!-- Badge Card -->
            <div class="bg-white rounded-2xl shadow-xl p-6 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Badge</h3>
                    <span class="text-3xl">🏆</span>
                </div>
                <div class="text-center">
                    <div class="text-5xl mb-3">{{ $badge['emoji'] }}</div>
                    <div class="text-xl font-bold text-gray-800">{{ $badge['name'] }}</div>
                    <p class="text-sm text-gray-600 mt-2">
                        {{ $user->games_completed }} / {{ $nextBadge['target'] }} games
                    </p>
                    @if($nextBadge['remaining'] > 0)
                        <p class="text-xs text-purple-600 mt-1">
                            {{ $nextBadge['remaining'] }} lagi untuk badge berikutnya!
                        </p>
                    @endif
                </div>
            </div>

            <!-- Stats Card -->
            <div class="bg-white rounded-2xl shadow-xl p-6 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Statistik</h3>
                    <span class="text-3xl">📊</span>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total XP</span>
                        <span class="text-xl font-bold text-purple-600">{{ $user->experience_points }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Games Selesai</span>
                        <span class="text-xl font-bold text-blue-600">{{ $user->games_completed }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Rata-rata</span>
                        <span class="text-xl font-bold text-green-600">{{ number_format($averageScore ?? 0, 1) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Scores -->
        @if($recentScores->count() > 0)
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">📈 Aktivitas Terakhir</h2>
                <a href="{{ route('santri.scores') }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-3">
                @foreach($recentScores as $score)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="text-3xl">
                            @if($score->game->type == 'tebak_gambar')
                                🖼️
                            @elseif($score->game->type == 'kosakata_tempat')
                                🏫
                            @elseif($score->game->type == 'pilihan_ganda')
                                ✅
                            @else
                                💬
                            @endif
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $score->game->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $score->completed_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-purple-600">{{ number_format($score->score, 0) }}%</div>
                        <div class="text-sm text-gray-600">{{ $score->correct_answers }}/{{ $score->total_questions }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Games Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-gray-800">🎮 Pilih Game</h2>
                <a href="{{ route('santri.games') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Game Card 1: Tebak Gambar -->
                <a href="{{ route('santri.games') }}" class="bg-gradient-to-br from-pink-400 to-red-500 rounded-2xl shadow-xl p-6 text-white card-hover">
                    <div class="text-center">
                        <div class="text-6xl mb-4">🖼️</div>
                        <h3 class="text-xl font-bold mb-2">Tebak Gambar</h3>
                        <p class="text-sm opacity-90">Tebak kosakata dari gambar</p>
                    </div>
                </a>

                <!-- Game Card 2: Kosakata Tempat -->
                <a href="{{ route('santri.games') }}" class="bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl shadow-xl p-6 text-white card-hover">
                    <div class="text-center">
                        <div class="text-6xl mb-4">🏫</div>
                        <h3 class="text-xl font-bold mb-2">Kosakata Tempat</h3>
                        <p class="text-sm opacity-90">Belajar kosakata 30 tempat</p>
                    </div>
                </a>

                <!-- Game Card 3: Pilihan Ganda -->
                <a href="{{ route('santri.games') }}" class="bg-gradient-to-br from-green-400 to-teal-500 rounded-2xl shadow-xl p-6 text-white card-hover">
                    <div class="text-center">
                        <div class="text-6xl mb-4">✅</div>
                        <h3 class="text-xl font-bold mb-2">Pilihan Ganda</h3>
                        <p class="text-sm opacity-90">Lengkapi kalimat Arab</p>
                    </div>
                </a>

                <!-- Game Card 4: Percakapan -->
                <a href="{{ route('santri.games') }}" class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl shadow-xl p-6 text-white card-hover">
                    <div class="text-center">
                        <div class="text-6xl mb-4">💬</div>
                        <h3 class="text-xl font-bold mb-2">Percakapan</h3>
                        <p class="text-sm opacity-90">Latihan percakapan 20 tempat</p>
                    </div>
                </a>

            </div>
        </div>

        <!-- Motivational Quote -->
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <p class="text-2xl font-semibold text-gray-800 mb-2">
                "من جدّ وجد"
            </p>
            <p class="text-lg text-gray-600">
                Siapa yang bersungguh-sungguh, pasti berhasil!
            </p>
        </div>

    </div>

</body>
</html>