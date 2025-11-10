<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-2">
            <div class="flex-1 min-w-0">
                <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <span>📝</span> <span class="hidden sm:inline">Kelola</span> Pertanyaan
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 mt-1 truncate">Game: {{ $game->title }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('ustadz.games.questions.create', $game->id) }}" 
                   class="px-3 py-2 sm:px-4 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 text-sm whitespace-nowrap">
                    ➕ <span class="hidden sm:inline">Tambah</span>
                </a>
                <a href="{{ route('ustadz.games.show', $game->id) }}" 
                   class="px-3 py-2 sm:px-4 bg-gradient-to-r from-gray-400 to-gray-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 text-sm whitespace-nowrap">
                    ← <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 sm:mb-6 bg-gradient-to-r from-emerald-50 to-teal-50 border-l-4 border-emerald-500 p-3 sm:p-4 rounded-xl shadow-md" role="alert">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <span class="text-2xl sm:text-3xl">✅</span>
                        <div>
                            <p class="font-bold text-sm sm:text-base text-emerald-800">Berhasil!</p>
                            <p class="text-xs sm:text-sm text-emerald-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 sm:mb-6 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-xl shadow-md" role="alert">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <span class="text-2xl sm:text-3xl">❌</span>
                        <div>
                            <p class="font-bold text-sm sm:text-base text-red-800">Error!</p>
                            <p class="text-xs sm:text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Game Info Card -->
            <div class="bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-2xl p-4 sm:p-6 mb-4 sm:mb-6 text-white shadow-xl">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="flex-shrink-0 w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center bg-white/20 rounded-2xl">
                        <span class="text-3xl sm:text-5xl">
                            @if($game->type === 'tebak_gambar') 🖼️
                            @elseif($game->type === 'kosakata_tempat') 🏫
                            @elseif($game->type === 'pilihan_ganda') ✅
                            @else 💬
                            @endif
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-lg sm:text-2xl font-bold truncate">{{ $game->title }}</h1>
                        <p class="text-xs sm:text-sm opacity-90">Total: {{ $questions->total() }} Pertanyaan</p>
                    </div>
                </div>
            </div>

            <!-- Questions List -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-emerald-500">
                @if($questions->count() > 0)
                    <div class="p-4 sm:p-6">
                        <div class="space-y-4">
                            @foreach($questions as $index => $question)
                                <div class="border-2 border-gray-200 rounded-2xl p-4 sm:p-6 hover:border-emerald-300 hover:shadow-lg transition-all duration-200">
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <!-- Header -->
                                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                                <span class="bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-800 text-xs sm:text-sm font-bold px-3 py-1.5 rounded-full border border-emerald-300">
                                                    📝 Soal #{{ $questions->firstItem() + $index }}
                                                </span>
                                                @if($question->location_name)
                                                    <span class="bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 text-xs font-bold px-2 py-1 rounded-full border border-blue-300">
                                                        📍 {{ $question->location_name }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <!-- Question Text -->
                                            <div class="bg-gradient-to-r from-teal-50 to-emerald-50 border-l-4 border-teal-500 p-3 sm:p-4 rounded-xl mb-3 sm:mb-4">
                                                <p class="text-sm sm:text-base text-gray-800 font-medium">{{ $question->question_text }}</p>
                                            </div>
                                            
                                            <!-- Image -->
                                            @if($question->image_path)
                                                <div class="mb-3 sm:mb-4">
                                                    <p class="text-xs sm:text-sm font-bold text-gray-700 mb-2">📷 Gambar:</p>
                                                    <img src="{{ asset('storage/' . $question->image_path) }}" 
                                                         alt="Question Image" 
                                                         class="w-32 h-32 sm:w-48 sm:h-48 object-cover rounded-xl border-4 border-emerald-200 shadow-md hover:scale-105 transition-transform">
                                                </div>
                                            @endif
                                            
                                            <!-- Correct Answer -->
                                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-l-4 border-emerald-500 p-3 sm:p-4 rounded-xl mb-3 sm:mb-4">
                                                <p class="text-xs sm:text-sm">
                                                    <span class="font-bold text-emerald-700">✓ Jawaban Benar:</span> 
                                                    <span class="text-gray-800 font-semibold">{{ $question->correct_answer }}</span>
                                                </p>
                                            </div>

                                            <!-- Options (for multiple choice) -->
                                            @if($question->options)
                                                @php
                                                    $options = json_decode($question->options, true);
                                                @endphp
                                                @if(is_array($options) && count($options) > 0)
                                                    <div>
                                                        <p class="text-xs sm:text-sm font-bold text-gray-700 mb-2">📋 Pilihan Jawaban:</p>
                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                            @foreach($options as $optIndex => $option)
                                                                <div class="bg-gray-50 border-2 border-gray-200 px-3 py-2 rounded-lg text-xs sm:text-sm flex items-center hover:border-emerald-300 transition-colors">
                                                                    <span class="bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 font-bold px-2 py-1 rounded mr-2 text-xs flex-shrink-0">
                                                                        {{ chr(65 + $optIndex) }}
                                                                    </span>
                                                                    <span class="line-clamp-2">{{ $option }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                            <!-- Timestamp -->
                                            <div class="mt-3 sm:mt-4 text-xs text-gray-500 flex items-center gap-1">
                                                <span>🕐</span>
                                                <span>Dibuat: {{ $question->created_at->format('d M Y H:i') }}</span>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex sm:flex-col gap-2 sm:gap-2 sm:ml-4">
                                            <a href="{{ route('ustadz.games.questions.edit', [$game->id, $question->id]) }}" 
                                               class="flex-1 sm:flex-none px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all text-center whitespace-nowrap">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('ustadz.games.questions.destroy', [$game->id, $question->id]) }}" 
                                                  method="POST" 
                                                  class="flex-1 sm:flex-none"
                                                  onsubmit="return confirm('Yakin ingin menghapus pertanyaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-full px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white text-sm font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all whitespace-nowrap">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $questions->links() }}
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12 sm:py-16 px-4">
                        <div class="mb-4">
                            <span class="text-6xl sm:text-7xl">📝</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Belum Ada Pertanyaan</h3>
                        <p class="text-sm sm:text-base text-gray-500 mb-6">Mulai tambahkan pertanyaan untuk game "{{ $game->title }}"</p>
                        <a href="{{ route('ustadz.games.questions.create', $game->id) }}" 
                           class="inline-flex items-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm sm:text-base font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                            <span>➕</span>
                            <span>Tambah Pertanyaan Pertama</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Info Card - Bonus -->
            <div class="mt-4 sm:mt-6 bg-gradient-to-br from-teal-50 to-emerald-50 rounded-2xl shadow-lg p-4 sm:p-6 border-2 border-emerald-200">
                <div class="flex items-start gap-3 sm:gap-4">
                    <span class="text-3xl sm:text-4xl">💡</span>
                    <div class="flex-1">
                        <h3 class="text-base sm:text-lg font-bold text-emerald-800 mb-2">Tips Kelola Pertanyaan</h3>
                        <ul class="text-xs sm:text-sm text-gray-700 space-y-1">
                            <li>• Buat pertanyaan yang jelas dan mudah dipahami</li>
                            <li>• Gunakan gambar berkualitas untuk game tebak gambar</li>
                            <li>• Pastikan jawaban benar sudah sesuai</li>
                            <li>• Minimal 5 pertanyaan untuk game yang berkualitas</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>