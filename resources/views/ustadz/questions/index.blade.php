<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Kelola Pertanyaan
                </h2>
                <p class="text-sm text-gray-600 mt-1">Game: {{ $game->title }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('ustadz.games.questions.create', $game->id) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    ➕ Tambah Soal
                </a>
                <a href="{{ route('ustadz.games.show', $game->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Error!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Game Info Card -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="text-5xl">
                            @if($game->type === 'tebak_gambar') 🖼️
                            @elseif($game->type === 'kosakata_tempat') 🏠
                            @elseif($game->type === 'pilihan_ganda') ✅
                            @else 💬
                            @endif
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">{{ $game->title }}</h1>
                            <p class="text-sm opacity-90">Total: {{ $questions->total() }} Pertanyaan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions List -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                @if($questions->count() > 0)
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($questions as $index => $question)
                                <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-purple-300 transition">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <!-- Header -->
                                            <div class="flex items-center mb-3">
                                                <span class="bg-purple-100 text-purple-800 text-sm font-bold px-3 py-1 rounded-full mr-3">
                                                    Soal #{{ $questions->firstItem() + $index }}
                                                </span>
                                                @if($question->location_name)
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                                        📍 {{ $question->location_name }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <!-- Question Text -->
                                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 border-l-4 border-purple-500 p-4 rounded-lg mb-4">
                                                <p class="text-gray-800 font-medium">{{ $question->question_text }}</p>
                                            </div>
                                            
                                            <!-- Image -->
                                            @if($question->image_path)
                                                <div class="mb-4">
                                                    <p class="text-sm font-bold text-gray-700 mb-2">Gambar:</p>
                                                    <img src="{{ asset('storage/' . $question->image_path) }}" alt="Question Image" class="w-48 h-48 object-cover rounded-lg border-4 border-gray-300 shadow-md">
                                                </div>
                                            @endif
                                            
                                            <!-- Correct Answer -->
                                            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-4">
                                                <p class="text-sm">
                                                    <span class="font-bold text-green-700">✓ Jawaban Benar:</span> 
                                                    <span class="text-gray-800 font-medium">{{ $question->correct_answer }}</span>
                                                </p>
                                            </div>

                                            <!-- Options (for multiple choice) -->
                                            @if($question->options)
                                                @php
                                                    $options = json_decode($question->options, true);
                                                @endphp
                                                @if(is_array($options) && count($options) > 0)
                                                    <div>
                                                        <p class="text-sm font-bold text-gray-700 mb-2">Pilihan Jawaban:</p>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                            @foreach($options as $optIndex => $option)
                                                                <div class="bg-gray-100 border border-gray-300 px-4 py-2 rounded-lg text-sm flex items-center">
                                                                    <span class="bg-gray-300 text-gray-700 font-bold px-2 py-1 rounded mr-2 text-xs">
                                                                        {{ chr(65 + $optIndex) }}
                                                                    </span>
                                                                    {{ $option }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                            <!-- Timestamp -->
                                            <div class="mt-4 text-xs text-gray-500">
                                                Dibuat: {{ $question->created_at->format('d M Y H:i') }}
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex flex-col space-y-2 ml-4">
                                            <a href="{{ route('ustadz.games.questions.edit', [$game->id, $question->id]) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-center">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('ustadz.games.questions.destroy', [$game->id, $question->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pertanyaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
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
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">📝</div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Pertanyaan</h3>
                        <p class="text-gray-500 mb-6">Mulai tambahkan pertanyaan untuk game "{{ $game->title }}"</p>
                        <a href="{{ route('ustadz.games.questions.create', $game->id) }}" class="inline-block px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:from-green-600 hover:to-teal-600 transition">
                            ➕ Tambah Pertanyaan Pertama
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>