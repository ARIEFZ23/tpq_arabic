<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Skor Santri
            </h2>
            <a href="{{ route('ustadz.dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                ← Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filter by Game -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Filter berdasarkan Game</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('ustadz.scores.index') }}" class="px-4 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600 transition text-center font-medium">
                        📊 Semua Game
                    </a>
                    @foreach($games as $game)
                        <a href="{{ route('ustadz.scores.game', $game->id) }}" class="px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition text-center">
                            <div class="text-2xl mb-1">
                                @if($game->type === 'tebak_gambar') 🖼️
                                @elseif($game->type === 'kosakata_tempat') 🏠
                                @elseif($game->type === 'pilihan_ganda') ✅
                                @else 💬
                                @endif
                            </div>
                            <div class="text-sm font-medium text-gray-800">{{ Str::limit($game->title, 20) }}</div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Scores List -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6">
                    <h2 class="text-2xl font-bold text-white">Semua Skor</h2>
                    <p class="text-white text-sm opacity-90 mt-1">Total: {{ $scores->total() }} pengerjaan</p>
                </div>

                @if($scores->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Santri
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Game
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Skor
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Benar/Total
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Waktu
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($scores as $score)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
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
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="text-2xl mr-2">
                                                    @if($score->game->type === 'tebak_gambar') 🖼️
                                                    @elseif($score->game->type === 'kosakata_tempat') 🏠
                                                    @elseif($score->game->type === 'pilihan_ganda') ✅
                                                    @else 💬
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $score->game->title }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        @if($score->game->type === 'tebak_gambar') Tebak Gambar
                                                        @elseif($score->game->type === 'kosakata_tempat') Kosakata
                                                        @elseif($score->game->type === 'pilihan_ganda') Pilihan Ganda
                                                        @else Percakapan
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $scoreValue = ($score->correct_answers / $score->total_questions) * 100;
                                            @endphp
                                            @if($scoreValue >= 80)
                                                <span class="px-4 py-2 inline-flex text-lg leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                                    {{ number_format($scoreValue, 0) }}
                                                </span>
                                            @elseif($scoreValue >= 60)
                                                <span class="px-4 py-2 inline-flex text-lg leading-5 font-bold rounded-full bg-blue-100 text-blue-800">
                                                    {{ number_format($scoreValue, 0) }}
                                                </span>
                                            @else
                                                <span class="px-4 py-2 inline-flex text-lg leading-5 font-bold rounded-full bg-purple-100 text-purple-800">
                                                    {{ number_format($scoreValue, 0) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm font-bold text-gray-900">
                                                {{ $score->correct_answers }}/{{ $score->total_questions }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ number_format(($score->correct_answers / $score->total_questions) * 100, 1) }}%
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div>{{ $score->completed_at->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $score->completed_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <a href="{{ route('ustadz.scores.detail', $score->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-medium inline-block">
                                                👁️ Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50">
                        {{ $scores->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">📊</div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Skor</h3>
                        <p class="text-gray-500">Belum ada santri yang mengerjakan game Anda</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>