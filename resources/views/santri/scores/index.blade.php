@php
    // Safe variable defaults
    $scores = $scores ?? collect();
    $totalGamesPlayed = $totalGamesPlayed ?? 0;
    $averageScore = $averageScore ?? 0;
    $bestScore = $bestScore ?? 0;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Skor - TPQ Arabic Learning</title>
    
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
                    <a href="{{ route('santri.dashboard') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2">
                        Dashboard
                    </a>
                    <a href="{{ route('santri.games') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2">
                        Games
                    </a>
                    <a href="{{ route('santri.scores') }}" class="text-purple-600 font-semibold border-b-2 border-purple-600 px-3 py-2">
                        Skor Saya
                    </a>
                    <a href="{{ route('santri.profile') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2">
                        Profile
                    </a>
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
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
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">📊 Riwayat Skor</h1>
            <p class="text-gray-600">Lihat semua hasil game yang sudah kamu mainkan</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Total Games -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold text-gray-600">Total Game Dimainkan</h3>
                    <span class="text-3xl">🎮</span>
                </div>
                <div class="text-4xl font-bold text-purple-600">{{ $totalGamesPlayed }}</div>
            </div>

            <!-- Average Score -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold text-gray-600">Rata-rata Skor</h3>
                    <span class="text-3xl">📈</span>
                </div>
                <div class="text-4xl font-bold text-blue-600">{{ number_format($averageScore, 1) }}%</div>
            </div>

            <!-- Best Score -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold text-gray-600">Skor Tertinggi</h3>
                    <span class="text-3xl">🏆</span>
                </div>
                <div class="text-4xl font-bold text-green-600">{{ number_format($bestScore, 0) }}%</div>
            </div>

        </div>

        <!-- Score History Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">Riwayat Lengkap</h2>
            </div>

            @if($scores->count() > 0)
            
            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                No
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Game
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Skor
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Benar/Total
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tanggal
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($scores as $index => $score)
                        <tr class="hover:bg-gray-50 transition-colors">
                            
                            <!-- Number -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ ($scores->currentPage() - 1) * $scores->perPage() + $index + 1 }}
                                </span>
                            </td>

                            <!-- Game Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
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
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $score->game->title }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ ucfirst(str_replace('_', ' ', $score->game->type)) }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Score -->
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                                    @if($score->score >= 80) bg-green-100 text-green-700
                                    @elseif($score->score >= 60) bg-blue-100 text-blue-700
                                    @else bg-orange-100 text-orange-700
                                    @endif
                                ">
                                    {{ number_format($score->score, 0) }}%
                                </span>
                            </td>

                            <!-- Correct/Total -->
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm text-gray-900 font-medium">
                                    {{ $score->correct_answers }} / {{ $score->total_questions }}
                                </span>
                            </td>

                            <!-- Date -->
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm text-gray-900">
                                    {{ $score->completed_at->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $score->completed_at->format('H:i') }}
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4">
                {{ $scores->links() }}
            </div>

            @else
            
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="text-8xl mb-4">📊</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Riwayat</h3>
                <p class="text-gray-600 mb-6">Kamu belum memainkan game apapun. Ayo mulai bermain!</p>
                <a href="{{ route('santri.games') }}" 
                   class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold px-8 py-3 rounded-xl transition-all shadow-lg hover:shadow-xl">
                    🎮 Lihat Game
                </a>
            </div>

            @endif

        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('santri.dashboard') }}" 
               class="inline-flex items-center space-x-2 text-purple-600 hover:text-purple-700 font-semibold">
                <span>←</span>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

    </div>

</body>
</html>