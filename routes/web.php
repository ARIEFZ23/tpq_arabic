<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    📊 Review Matrix: {{ $game->title }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Lihat semua jawaban santri dalam satu tabel</p>
            </div>
            <a href="{{ route('ustadz.scores.game', $game->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            
            @if($latestScores->count() > 0 && $game->questions->count() > 0)
                <!-- Matrix Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6">
                        <h2 class="text-2xl font-bold text-white">Matrix Koreksi Jawaban</h2>
                        <p class="text-white text-sm opacity-90 mt-1">{{ $latestScores->count() }} Santri • {{ $game->questions->count() }} Soal</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider sticky left-0 bg-gray-100 z-10">
                                        Nama Santri
                                    </th>
                                    @foreach($game->questions as $index => $question)
                                        <th class="px-4 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider min-w-[100px]">
                                            <div class="flex flex-col items-center">
                                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full mb-1">Soal {{ $index + 1 }}</span>
                                                <span class="text-xs font-normal text-gray-500 normal-case">{{ Str::limit($question->question_text, 30) }}</span>
                                            </div>
                                        </th>
                                    @endforeach
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-blue-50">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($latestScores as $score)
                                    <tr class="hover:bg-gray-50 transition">
                                        <!-- Nama Santri (Sticky Column) -->
                                        <td class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white z-10 border-r border-gray-200">
                                            <div class="flex items-center">
                                                <div class="text-2xl mr-3">
                                                    @if($score->user->role === 'santri_putra') 👨‍🎓
                                                    @else 👩‍🎓
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900">{{ $score->user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $score->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Jawaban per Soal -->
                                        @php
                                            // Buat map jawaban berdasarkan question_id untuk akses cepat
                                            $answersMap = $score->answerLogs->keyBy('question_id');
                                        @endphp

                                        @foreach($game->questions as $question)
                                            @php
                                                $answer = $answersMap->get($question->id);
                                            @endphp
                                            <td class="px-4 py-4 text-center">
                                                @if($answer)
                                                    @if($answer->is_correct)
                                                        <!-- Jawaban Benar -->
                                                        <div class="inline-flex flex-col items-center">
                                                            <span class="text-3xl">✅</span>
                                                            <span class="text-xs text-green-600 font-medium mt-1">Benar</span>
                                                        </div>
                                                    @else
                                                        <!-- Jawaban Salah -->
                                                        <div class="inline-flex flex-col items-center">
                                                            <span class="text-3xl">❌</span>
                                                            <span class="text-xs text-red-600 font-medium mt-1">Salah</span>
                                                            <div class="mt-2 p-2 bg-red-50 rounded text-xs">
                                                                <p class="text-gray-500">Jawab:</p>
                                                                <p class="font-semibold text-red-700">{{ $answer->user_answer ?: '-' }}</p>
                                                                <p class="text-gray-500 mt-1">Benar:</p>
                                                                <p class="font-semibold text-green-700">{{ $answer->correct_answer }}</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <!-- Tidak Dijawab -->
                                                    <div class="inline-flex flex-col items-center">
                                                        <span class="text-3xl">⚪</span>
                                                        <span class="text-xs text-gray-400 font-medium mt-1">Kosong</span>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach

                                        <!-- Total Score -->
                                        <td class="px-6 py-4 text-center bg-blue-50">
                                            @php
                                                $scoreValue = ($score->correct_answers / $score->total_questions) * 100;
                                            @endphp
                                            <div class="flex flex-col items-center">
                                                @if($scoreValue >= 80)
                                                    <span class="px-4 py-2 inline-flex text-2xl font-bold rounded-full bg-green-100 text-green-800">
                                                        {{ number_format($scoreValue, 0) }}
                                                    </span>
                                                    <span class="text-xs text-green-600 font-medium mt-1">🌟 Excellent</span>
                                                @elseif($scoreValue >= 60)
                                                    <span class="px-4 py-2 inline-flex text-2xl font-bold rounded-full bg-blue-100 text-blue-800">
                                                        {{ number_format($scoreValue, 0) }}
                                                    </span>
                                                    <span class="text-xs text-blue-600 font-medium mt-1">👍 Good</span>
                                                @else
                                                    <span class="px-4 py-2 inline-flex text-2xl font-bold rounded-full bg-purple-100 text-purple-800">
                                                        {{ number_format($scoreValue, 0) }}
                                                    </span>
                                                    <span class="text-xs text-purple-600 font-medium mt-1">💪 Keep Going</span>
                                                @endif
                                                <p class="text-xs text-gray-500 mt-1">{{ $score->correct_answers }}/{{ $score->total_questions }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Legend -->
                <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Keterangan:</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">✅</span>
                            <div>
                                <p class="font-semibold text-green-700">Jawaban Benar</p>
                                <p class="text-xs text-gray-500">Santri menjawab dengan benar</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">❌</span>
                            <div>
                                <p class="font-semibold text-red-700">Jawaban Salah</p>
                                <p class="text-xs text-gray-500">Santri menjawab tapi salah</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">⚪</span>
                            <div>
                                <p class="font-semibold text-gray-700">Tidak Dijawab</p>
                                <p class="text-xs text-gray-500">Santri tidak menjawab soal</p>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-lg p-16 text-center">
                    <div class="text-6xl mb-4">📊</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data</h3>
                    <p class="text-gray-500 mb-6">
                        @if($game->questions->count() == 0)
                            Game ini belum memiliki soal. Tambahkan soal terlebih dahulu.
                        @else
                            Belum ada santri yang mengerjakan game ini.
                        @endif
                    </p>
                    <a href="{{ route('ustadz.games.show', $game->id) }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition">
                        📝 Kelola Game Ini
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>