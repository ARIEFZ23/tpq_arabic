@extends('layouts.admin')

@section('title', 'Manage Games')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manage Games</h2>
            <a href="{{ route('admin.games.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Add New Game
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Games Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Questions</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($games as $game)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $game->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $game->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($game->type == 'tebak_gambar') bg-blue-100 text-blue-800
                                    @elseif($game->type == 'kosakata_tempat') bg-green-100 text-green-800
                                    @elseif($game->type == 'pilihan_ganda') bg-yellow-100 text-yellow-800
                                    @else bg-purple-100 text-purple-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $game->type)) }}
                                </span>
                            </td>
                            
                            <!-- FIXED: Mengatasi null creator -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($game->creator)
                                    {{ $game->creator->name }}
                                @else
                                    <span class="text-gray-400 italic">Unknown</span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $game->questions->count() }} questions</td>
                            
                            <!-- Status Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($game->status == 'published')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Published
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">
                                        Draft
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Tombol Publish/Unpublish -->
                                <form action="{{ route('admin.games.toggleStatus', $game) }}" method="POST" class="inline">
                                    @csrf
                                    @if($game->status == 'published')
                                        <button type="submit" class="text-gray-500 hover:text-gray-700 mr-3" title="Unpublish (Jadikan Draft)">
                                            Draft ⤵️
                                        </button>
                                    @else
                                        <button type="submit" class="text-teal-600 hover:text-teal-900 mr-3" title="Publish (Tayangkan ke Santri)">
                                            Publish 🚀
                                        </button>
                                    @endif
                                </form>

                                <a href="{{ route('admin.games.show', $game) }}" class="text-green-600 hover:text-green-900 mr-3">View</a>
                                <a href="{{ route('admin.games.edit', $game) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                
                                <form action="{{ route('admin.games.destroy', $game) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure? This will also delete all questions in this game.')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No games found. Create your first game!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $games->links() }}
        </div>
    </div>
</div>
@endsection
