@php
    // Safe variable defaults - mencegah undefined variable
    $scoreValue = $scoreValue ?? $score ?? 0;
    $correctAnswers = $correctAnswers ?? 0;
    $totalQuestions = $totalQuestions ?? 1;
    $xpEarned = $xpEarned ?? 0;
    $newLevel = $newLevel ?? auth()->user()->level ?? 1;
    $levelName = $levelName ?? 'Pemula';
    $levelInfo = $levelInfo ?? ['progress_percentage' => 0, 'current_xp' => 0, 'max_xp' => 100];
    $badge = $badge ?? ['emoji' => '⭐', 'name' => 'Beginner'];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Game - TPQ Arabic Learning</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .celebration {
            animation: celebrate 0.6s ease-in-out;
        }
        @keyframes celebrate {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 to-blue-50 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-purple-600">🕌 TPQ Arabic</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Result Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="
                @if($scoreValue >= 80) bg-gradient-to-br from-green-400 to-emerald-500
                @elseif($scoreValue >= 60) bg-gradient-to-br from-blue-400 to-indigo-500
                @else bg-gradient-to-br from-orange-400 to-red-500
                @endif
                p-12 text-center text-white
            ">
                <!-- Celebration Icon -->
                <div class="text-9xl mb-6 celebration">
                    @if($scoreValue >= 80)
                        🎉
                    @elseif($scoreValue >= 60)
                        👏
                    @else
                        💪
                    @endif
                </div>

                <!-- Title -->
                <h1 class="text-4xl font-bold mb-4">
                    @if($scoreValue >= 80)
                        Luar Biasa!
                    @elseif($scoreValue >= 60)
                        Bagus Sekali!
                    @else
                        Jangan Menyerah!
                    @endif
                </h1>

                <!-- Game Title -->
                <p class="text-xl opacity-90">{{ $game->title }}</p>
            </div>

            <!-- Score Section -->
            <div class="p-8">
                
                <!-- Main Score -->
                <div class="text-center mb-8">
                    <div class="text-7xl font-bold mb-2
                        @if($scoreValue >= 80) text-green-600
                        @elseif($scoreValue >= 60) text-blue-600
                        @else text-orange-600
                        @endif
                    ">
                        {{ number_format($scoreValue, 0) }}%
                    </div>
                    <div class="text-2xl text-gray-600 font-semibold">
                        {{ $correctAnswers }} dari {{ $totalQuestions }} benar
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    
                    <!-- XP Earned -->
                    <div class="bg-purple-50 rounded-2xl p-6 text-center">
                        <div class="text-5xl mb-3">⭐</div>
                        <div class="text-3xl font-bold text-purple-600 mb-1">+{{ $xpEarned }}</div>
                        <div class="text-sm text-gray-600 font-medium">XP Didapat</div>
                    </div>

                    <!-- Level -->
                    <div class="bg-blue-50 rounded-2xl p-6 text-center">
                        <div class="text-5xl mb-3">
                            @php
                                $levelIcons = [1 => '🌱', 2 => '📚', 3 => '⭐', 4 => '🏆', 5 => '👑'];
                                $icon = $levelIcons[$newLevel] ?? '⭐';
                            @endphp
                            {{ $icon }}
                        </div>
                        <div class="text-3xl font-bold text-blue-600 mb-1">Level {{ $newLevel }}</div>
                        <div class="text-sm text-gray-600 font-medium">{{ $levelName }}</div>
                    </div>

                    <!-- Badge -->
                    <div class="bg-yellow-50 rounded-2xl p-6 text-center">
                        <div class="text-5xl mb-3">{{ $badge['emoji'] }}</div>
                        <div class="text-xl font-bold text-yellow-600 mb-1">{{ $badge['name'] }}</div>
                        <div class="text-sm text-gray-600 font-medium">Badge</div>
                    </div>

                </div>

                <!-- Progress Bar -->
                <div class="bg-gray-100 rounded-2xl p-6 mb-8">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-semibold text-gray-700">Progress ke Level Berikutnya</span>
                        <span class="text-sm font-bold text-purple-600">{{ $levelInfo['progress_percentage'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-4 rounded-full transition-all duration-500" 
                             style="width: {{ $levelInfo['progress_percentage'] }}%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-2 text-center">
                        {{ $levelInfo['current_xp'] }} / {{ $levelInfo['max_xp'] }} XP
                    </p>
                </div>

                <!-- Motivational Message -->
                <div class="bg-gradient-to-r from-purple-100 to-pink-100 rounded-2xl p-6 text-center mb-8">
                    <p class="text-xl font-semibold text-gray-800 mb-2">
                        @if($scoreValue >= 90)
                            "الْمَاهِرُ بِالْقُرْآنِ مَعَ السَّفَرَةِ الْكِرَامِ الْبَرَرَةِ"
                        @elseif($scoreValue >= 70)
                            "مَنْ سَلَكَ طَرِيقًا يَلْتَمِسُ فِيهِ عِلْمًا"
                        @else
                            "طَلَبُ الْعِلْمِ فَرِيضَةٌ عَلَى كُلِّ مُسْلِمٍ"
                        @endif
                    </p>
                    <p class="text-gray-600">
                        @if($scoreValue >= 90)
                            Orang yang mahir membaca Al-Quran bersama malaikat yang mulia
                        @elseif($scoreValue >= 70)
                            Barangsiapa menempuh jalan untuk mencari ilmu
                        @else
                            Menuntut ilmu adalah kewajiban bagi setiap muslim
                        @endif
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <!-- Play Again -->
                    <a href="{{ route('santri.games.play', $game->id) }}" 
                       class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white text-center font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        🔄 Main Lagi
                    </a>

                    <!-- Back to Games -->
                    <a href="{{ route('santri.games') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white text-center font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        🎮 Game Lain
                    </a>

                    <!-- Back to Dashboard -->
                    <a href="{{ route('santri.dashboard') }}" 
                       class="bg-green-500 hover:bg-green-600 text-white text-center font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        🏠 Dashboard
                    </a>

                </div>

            </div>

        </div>

        <!-- Fun Facts -->
        <div class="mt-8 bg-white rounded-2xl shadow-xl p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">📊 Statistik Game Ini</h3>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <div class="text-3xl font-bold text-purple-600">{{ $totalQuestions }}</div>
                    <div class="text-sm text-gray-600">Total Soal</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-green-600">{{ $correctAnswers }}</div>
                    <div class="text-sm text-gray-600">Benar</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-red-600">{{ $totalQuestions - $correctAnswers }}</div>
                    <div class="text-sm text-gray-600">Salah</div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>