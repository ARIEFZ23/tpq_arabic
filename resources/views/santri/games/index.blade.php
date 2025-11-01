<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Game - TPQ Arabic Learning</title>
    
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
                    <a href="{{ route('santri.dashboard') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2">
                        Dashboard
                    </a>
                    <a href="{{ route('santri.games') }}" class="text-purple-600 font-semibold border-b-2 border-purple-600 px-3 py-2">
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
            <h1 class="text-4xl font-bold text-gray-800 mb-2">🎮 Pilih Game</h1>
            <p class="text-gray-600">Pilih game yang ingin kamu mainkan dan tingkatkan kemampuan bahasa Arabmu!</p>
        </div>

        <!-- Games Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @forelse($games as $game)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                
                <!-- Game Header (Colorful) -->
                <div class="
                    @if($game->type == 'tebak_gambar') bg-gradient-to-br from-pink-400 to-red-500
                    @elseif($game->type == 'kosakata_tempat') bg-gradient-to-br from-blue-400 to-indigo-500
                    @elseif($game->type == 'pilihan_ganda') bg-gradient-to-br from-green-400 to-teal-500
                    @else bg-gradient-to-br from-yellow-400 to-orange-500
                    @endif
                    p-8 text-center text-white
                ">
                    <!-- Icon -->
                    <div class="text-7xl mb-4">
                        @if($game->type == 'tebak_gambar')
                            🖼️
                        @elseif($game->type == 'kosakata_tempat')
                            🏫
                        @elseif($game->type == 'pilihan_ganda')
                            ✅
                        @else
                            💬
                        @endif
                    </div>
                    
                    <!-- Title -->
                    <h3 class="text-2xl font-bold mb-2">{{ $game->title }}</h3>
                    
                    <!-- Description -->
                    <p class="text-sm opacity-90">{{ Str::limit($game->description, 60) }}</p>
                </div>

                <!-- Game Body -->
                <div class="p-6">
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $game->questions_count }}</div>
                            <div class="text-xs text-gray-600">Soal</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $game->best_score ? number_format($game->best_score, 0) . '%' : '-' }}
                            </div>
                            <div class="text-xs text-gray-600">Best Score</div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    @if($game->completed)
                    <div class="flex items-center justify-center mb-4">
                        <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-semibold">
                            ✓ Sudah Dimainkan
                        </span>
                    </div>
                    @endif

                    <!-- Play Button -->
                    @if($game->questions_count > 0)
                    <a href="{{ route('santri.games.play', $game->id) }}" 
                       class="block w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white text-center font-bold py-3 rounded-xl transition-all">
                        {{ $game->completed ? '🔄 Main Lagi' : '🎮 Main Sekarang' }}
                    </a>
                    @else
                    <div class="block w-full bg-gray-300 text-gray-600 text-center font-bold py-3 rounded-xl cursor-not-allowed">
                        🔒 Belum Ada Soal
                    </div>
                    @endif

                </div>

            </div>
            @empty
            
            <!-- Empty State -->
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                    <div class="text-8xl mb-4">🎮</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Game</h3>
                    <p class="text-gray-600">Admin belum menambahkan game. Silakan cek lagi nanti!</p>
                </div>
            </div>

            @endforelse

        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('santri.dashboard') }}" class="inline-flex items-center space-x-2 text-purple-600 hover:text-purple-700 font-semibold">
                <span>←</span>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

    </div>

</body>
</html>
```
