<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Ustadz
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl p-8 mb-6 text-white">
                <h1 class="text-3xl font-bold mb-2">Assalamu'alaikum, Ustadz {{ Auth::user()->name }}! 👋</h1>
                <p class="text-lg">Kelola game dan pertanyaan pembelajaran di sini</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Total Games -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Game</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalGames }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-4">
                            <span class="text-3xl">🎮</span>
                        </div>
                    </div>
                </div>

                <!-- Total Questions -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pertanyaan</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalQuestions }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-4">
                            <span class="text-3xl">❓</span>
                        </div>
                    </div>
                </div>

                <!-- Total Scores -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pengerjaan</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalScores }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-4">
                            <span class="text-3xl">📊</span>
                        </div>
                    </div>
                </div>

                <!-- Average Score -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Rata-rata Skor</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($averageScore, 1) }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-4">
                            <span class="text-3xl">⭐</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <a href="{{ route('ustadz.games.create') }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-xl p-6 shadow-lg transform hover:scale-105 transition-all">
                    <div class="text-4xl mb-3">➕</div>
                    <h3 class="text-xl font-bold mb-2">Buat Game Baru</h3>
                    <p class="text-sm opacity-90">Tambah game pembelajaran baru</p>
                </a>

                <a href="{{ route('ustadz.games.index') }}" class="bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white rounded-xl p-6 shadow-lg transform hover:scale-105 transition-all">
                    <div class="text-4xl mb-3">📚</div>
                    <h3 class="text-xl font-bold mb-2">Kelola Game</h3>
                    <p class="text-sm opacity-90">Edit dan kelola game yang ada</p>
                </a>

                <a href="{{ route('ustadz.scores.index') }}" class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white rounded-xl p-6 shadow-lg transform hover:scale-105 transition-all">
                    <div class="text-4xl mb-3">📈</div>
                    <h3 class="text-xl font-bold mb-2">Lihat Skor</h3>
                    <p class="text-sm opacity-90">Monitor progress santri</p>
                </a>
            </div>

            <!-- Recent Games -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Game Terbaru</h3>
                    <a href="{{ route('ustadz.games.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">Lihat Semua →</a>
                </div>

                @if($recentGames->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentGames as $game)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex items-center space-x-4">
                                    <div class="text-3xl">
                                        @if($game->type === 'tebak_gambar') 🖼️
                                        @elseif($game->type === 'kosakata_tempat') 🏠
                                        @elseif($game->type === 'pilihan_ganda') ✅
                                        @else 💬
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">{{ $game->title }}</h4>
                                        <p class="text-sm text-gray-500">{{ $game->questions_count }} Pertanyaan</p>
                                    </div>
                                </div>
                                <a href="{{ route('ustadz.games.show', $game->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                    Detail
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">📝</div>
                        <p class="text-gray-500 text-lg">Belum ada game. Buat game pertama Anda!</p>
                        <a href="{{ route('ustadz.games.create') }}" class="inline-block mt-4 px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Buat Game Sekarang
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>