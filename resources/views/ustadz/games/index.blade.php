<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Game
            </h2>
            <a href="{{ route('ustadz.games.create') }}" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition">
                ➕ Buat Game Baru
            </a>
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

            <!-- Games List -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                @if($games->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                        Game
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                        Tipe
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                        Pertanyaan
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                        Pengerjaan
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                        Dibuat
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-medium uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($games as $game)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-3xl mr-3">
                                                    @if($game->type === 'tebak_gambar') 🖼️
                                                    @elseif($game->type === 'kosakata_tempat') 🏠
                                                    @elseif($game->type === 'pilihan_ganda') ✅
                                                    @else 💬
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900">{{ $game->title }}</div>
                                                    <div class="text-xs text-gray-500">{{ Str::limit($game->description, 50) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($game->type === 'tebak_gambar')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-pink-100 text-pink-800">
                                                    Tebak Gambar
                                                </span>
                                            @elseif($game->type === 'kosakata_tempat')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Kosakata Tempat
                                                </span>
                                            @elseif($game->type === 'pilihan_ganda')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Pilihan Ganda
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Percakapan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $game->questions_count }}</div>
                                            <div class="text-xs text-gray-500">Soal</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $game->scores_count }}</div>
                                            <div class="text-xs text-gray-500">Kali dimainkan</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $game->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('ustadz.games.show', $game->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition" title="Detail">
                                                    👁️
                                                </a>
                                                <a href="{{ route('ustadz.games.questions.index', $game->id) }}" class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition" title="Kelola Soal">
                                                    📝
                                                </a>
                                                <a href="{{ route('ustadz.games.edit', $game->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition" title="Edit">
                                                    ✏️
                                                </a>
                                                <form action="{{ route('ustadz.games.destroy', $game->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus game ini? Semua pertanyaan akan ikut terhapus!')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition" title="Hapus">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50">
                        {{ $games->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">🎮</div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Game</h3>
                        <p class="text-gray-500 mb-6">Mulai buat game pembelajaran pertama Anda!</p>
                        <a href="{{ route('ustadz.games.create') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition">
                            ➕ Buat Game Sekarang
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>