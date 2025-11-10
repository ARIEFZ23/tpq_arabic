<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Ustadz
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Card - Islamic Theme dengan Emerald-Teal -->
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
                                <span class="text-3xl sm:text-4xl">👋</span>
                            </h1>
                            <p class="text-xl sm:text-2xl font-semibold mb-1">Ustadz {{ Auth::user()->name }}</p>
                            <p class="text-base sm:text-lg opacity-90">Kelola game dan pertanyaan pembelajaran di sini</p>
                        </div>
                        <div class="hidden sm:flex flex-col items-center gap-2">
                            <div class="text-6xl">🕌</div>
                            <div class="text-xs font-semibold bg-white/20 px-3 py-1 rounded-full">
                                Admin Panel
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards - Mengikuti pola Santri Dashboard -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                
                <!-- Total Games -->
                <div class="bg-white rounded-2xl shadow-lg p-5 border-t-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-bold text-gray-800">🎮 Total Game</h3>
                        <span class="text-3xl">🎮</span>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-2">
                            <span class="text-3xl font-bold text-blue-600">{{ $totalGames }}</span>
                        </div>
                        <div class="text-sm font-medium text-gray-600">Game Tersedia</div>
                    </div>
                </div>

                <!-- Total Questions -->
                <div class="bg-white rounded-2xl shadow-lg p-5 border-t-4 border-emerald-500 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-bold text-gray-800">❓ Total Soal</h3>
                        <span class="text-3xl">❓</span>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 rounded-full mb-2">
                            <span class="text-3xl font-bold text-emerald-600">{{ $totalQuestions }}</span>
                        </div>
                        <div class="text-sm font-medium text-gray-600">Pertanyaan Dibuat</div>
                    </div>
                </div>

                <!-- Total Scores -->
                <div class="bg-white rounded-2xl shadow-lg p-5 border-t-4 border-amber-500 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-bold text-gray-800">📊 Pengerjaan</h3>
                        <span class="text-3xl">📊</span>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-100 rounded-full mb-2">
                            <span class="text-3xl font-bold text-amber-600">{{ $totalScores }}</span>
                        </div>
                        <div class="text-sm font-medium text-gray-600">Total Dikerjakan</div>
                    </div>
                </div>

                <!-- Average Score -->
                <div class="bg-white rounded-2xl shadow-lg p-5 border-t-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-bold text-gray-800">⭐ Rata-rata</h3>
                        <span class="text-3xl">⭐</span>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-2">
                            <span class="text-2xl font-bold text-purple-600">{{ number_format($averageScore, 1) }}</span>
                        </div>
                        <div class="text-sm font-medium text-gray-600">Skor Santri</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions - Mengikuti pola dari Santri dengan gradasi serupa -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2 mb-4">
                    <span>⚡</span> Aksi Cepat
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    
                    <!-- Buat Game Baru -->
                    <a href="{{ route('ustadz.games.create') }}" 
                       class="group bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl shadow-lg p-5 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                                <span class="text-4xl">➕</span>
                            </div>
                            <h3 class="text-lg font-bold mb-1">Buat Game Baru</h3>
                            <p class="text-sm opacity-90">Tambah game pembelajaran baru</p>
                        </div>
                    </a>

                    <!-- Kelola Game -->
                    <a href="{{ route('ustadz.games.index') }}" 
                       class="group bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl shadow-lg p-5 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                                <span class="text-4xl">📚</span>
                            </div>
                            <h3 class="text-lg font-bold mb-1">Kelola Game</h3>
                            <p class="text-sm opacity-90">Edit dan kelola game yang ada</p>
                        </div>
                    </a>

                    <!-- Lihat Skor -->
                    <a href="{{ route('ustadz.scores.index') }}" 
                       class="group bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl shadow-lg p-5 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                                <span class="text-4xl">📈</span>
                            </div>
                            <h3 class="text-lg font-bold mb-1">Lihat Skor</h3>
                            <p class="text-sm opacity-90">Monitor progress santri</p>
                        </div>
                    </a>

                </div>
            </div>

            <!-- Recent Games - Mengikuti pola Recent Activity dari Santri -->
            <div class="bg-white rounded-2xl shadow-lg p-5 border-l-4 border-teal-500">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <span>📝</span> Game Terbaru
                    </h2>
                    <a href="{{ route('ustadz.games.index') }}" 
                       class="text-sm font-semibold text-teal-600 hover:text-teal-700 px-3 py-1 rounded-lg hover:bg-teal-50 transition-colors">
                        Lihat Semua →
                    </a>
                </div>

                @if($recentGames->count() > 0)
                    <div class="space-y-2">
                        @foreach($recentGames as $game)
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-white border border-gray-100 rounded-xl hover:shadow-md transition-all duration-200">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-gradient-to-br from-teal-100 to-emerald-100 rounded-lg">
                                    <span class="text-2xl">
                                        @if($game->type === 'tebak_gambar') 🖼️
                                        @elseif($game->type === 'kosakata_tempat') 🏫
                                        @elseif($game->type === 'pilihan_ganda') ✅
                                        @else 💬
                                        @endif
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-800 text-sm truncate">{{ $game->title }}</h4>
                                    <p class="text-xs text-gray-500">{{ $game->questions_count }} Pertanyaan</p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-3">
                                <a href="{{ route('ustadz.games.show', $game->id) }}" 
                                   class="px-4 py-2 bg-gradient-to-r from-teal-500 to-emerald-500 text-white text-sm font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-200">
                                    Detail
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">📝</div>
                        <p class="text-gray-500 text-lg mb-4">Belum ada game. Buat game pertama Anda!</p>
                        <a href="{{ route('ustadz.games.create') }}" 
                           class="inline-block px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-300">
                            Buat Game Sekarang
                        </a>
                    </div>
                @endif
            </div>

            <!-- Motivational Quote - Islamic Theme (Bonus!) -->
            <div class="bg-gradient-to-br from-teal-50 to-emerald-50 rounded-2xl shadow-lg p-6 sm:p-8 text-center border-2 border-emerald-200 mt-6">
                <div class="mb-3">
                    <span class="text-4xl">📖</span>
                </div>
                <p class="text-xl sm:text-3xl font-bold text-emerald-800 mb-2 font-arabic">
                    خَيْرُ النَّاسِ أَنْفَعُهُمْ لِلنَّاسِ
                </p>
                <p class="text-base sm:text-lg text-gray-700 font-semibold">
                    "Sebaik-baik manusia adalah yang paling bermanfaat bagi orang lain"
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Jazakumullahu khairan atas dedikasi Ustadz! 🌟
                </p>
            </div>

        </div>
    </div>
</x-app-layout>