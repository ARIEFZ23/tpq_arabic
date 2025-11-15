@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome, {{ auth()->user()->name }}!</h2>
        <p class="text-gray-600 mb-6">You're logged in as: <strong>{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</strong></p>

        <!-- Quick Links berdasarkan Role -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if(auth()->user()->isAdmin())
                <!-- Admin Links -->
                <a href="{{ route('admin.users.index') }}" class="block p-6 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-2">Manage Users</h3>
                    <p class="text-sm">Add, edit, or delete users</p>
                </a>
                <a href="{{ route('admin.games.index') }}" class="block p-6 bg-green-500 hover:bg-green-600 text-white rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-2">Manage Games</h3>
                    <p class="text-sm">Create and manage learning games</p>
                </a>
                <a href="{{ route('admin.questions.index') }}" class="block p-6 bg-purple-500 hover:bg-purple-600 text-white rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-2">Manage Questions</h3>
                    <p class="text-sm">Add questions to games</p>
                </a>
            @endif

            @if(auth()->user()->isTeacher())
                <!-- Teacher Links -->
                <a href="{{ route('ustadz.games.index') }}" class="block p-6 bg-green-500 hover:bg-green-600 text-white rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-2">Manage Games</h3>
                    <p class="text-sm">Create and manage learning games</p>
                </a>
                <a href="{{ route('ustadz.questions.index') }}" class="block p-6 bg-purple-500 hover:bg-purple-600 text-white rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-2">Manage Questions</h3>
                    <p class="text-sm">Add questions to games</p>
                </a>
            @endif

            @if(auth()->user()->isSantri())
                <!-- Santri Links -->
                <a href="{{ route('santri.games') }}" class="block p-6 bg-green-500 hover:bg-green-600 text-white rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-2">Play Games</h3>
                    <p class="text-sm">Start learning Arabic</p>
                </a>
                <a href="{{ route('santri.scores') }}" class="block p-6 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-2">My Scores</h3>
                    <p class="text-sm">View your learning progress</p>
                </a>
            @endif
        </div>
    </div>
</div>


@endsection@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Header dengan Gradient -->
<div class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 rounded-2xl shadow-2xl overflow-hidden mb-8">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="relative px-8 py-12">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="flex-1 text-white">
                <h1 class="text-4xl font-bold mb-2 drop-shadow-lg">Assalamu'alaikum, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-xl opacity-90 mb-4">Selamat datang di Sistem Pembelajaran TPQ Arabic</p>
                <div class="inline-flex items-center gap-3 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full border border-white/30">
                    <span class="text-2xl">
                        @if(auth()->user()->isAdmin()) 🛠️
                        @elseif(auth()->user()->isTeacher()) 📚  
                        @elseif(auth()->user()->isSantri()) 🎓
                        @endif
                    </span>
                    <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</span>
                </div>
            </div>
            <div class="mt-6 md:mt-0">
                <div class="text-6xl animate-bounce">
                    @if(auth()->user()->isAdmin()) 🏆
                    @elseif(auth()->user()->isTeacher()) 👨‍🏫
                    @elseif(auth()->user()->isSantri()) 📖
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 opacity-20">
        <svg class="w-32 h-32" viewBox="0 0 200 200" fill="currentColor">
            <path d="M100,20 L110,50 L140,50 L115,70 L125,100 L100,80 L75,100 L85,70 L60,50 L90,50 Z"/>
        </svg>
    </div>
    <div class="absolute bottom-0 left-0 opacity-20">
        <svg class="w-24 h-24" viewBox="0 0 200 200" fill="currentColor">
            <path d="M100,20 L110,50 L140,50 L115,70 L125,100 L100,80 L75,100 L85,70 L60,50 L90,50 Z"/>
        </svg>
    </div>
</div>

<!-- Statistics Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @if(auth()->user()->isAdmin())
    <!-- Admin Statistics -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Users</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\User::count() }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <span class="text-2xl text-blue-600">👥</span>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <span>📈 Active</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Games</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Game::count() }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <span class="text-2xl text-green-600">🎮</span>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <span>🚀 Published</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Questions</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Question::count() }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full">
                <span class="text-2xl text-purple-600">❓</span>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <span>📊 Available</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-orange-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Scores</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Score::count() }}</p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full">
                <span class="text-2xl text-orange-600">📈</span>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <span>🎯 Recorded</span>
        </div>
    </div>

    @elseif(auth()->user()->isTeacher())
    <!-- Teacher Statistics -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">My Games</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Game::where('created_by', auth()->id())->count() }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <span class="text-2xl text-green-600">🎮</span>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <span>📚 Created</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Active Students</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\User::whereIn('role', ['santri_putra', 'santri_putri'])->count() }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <span class="text-2xl text-blue-600">👨‍🎓</span>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <span>🎓 Learning</span>
        </div>
    </div>

    @elseif(auth()->user()->isSantri())
    <!-- Santri Statistics -->
    @php
        $user = auth()->user();
        $totalScores = \App\Models\Score::where('user_id', $user->id)->count();
        $averageScore = $totalScores > 0 ? \App\Models\Score::where('user_id', $user->id)->avg('score') : 0;
        $bestScore = \App\Models\Score::where('user_id', $user->id)->max('score') ?? 0;
    @endphp

    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-emerald-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">My Level</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $user->level ?? 1 }}</p>
            </div>
            <div class="p-3 bg-emerald-100 rounded-full">
                <span class="text-2xl text-emerald-600">⭐</span>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <span>📈 Progress</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Games Played</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalScores }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <span class="text-2xl text-blue-600">🎯</span>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <span>🏆 Completed</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Average Score</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($averageScore, 1) }}%</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full">
                <span class="text-2xl text-purple-600">📊</span>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <span>✨ Performance</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-amber-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Best Score</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($bestScore, 1) }}%</p>
            </div>
            <div class="p-3 bg-amber-100 rounded-full">
                <span class="text-2xl text-amber-600">🏅</span>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-green-600">
            <span>🚀 Personal Best</span>
        </div>
    </div>
    @endif
</div>

<!-- Quick Actions Section -->
<div class="bg-white rounded-2xl shadow-lg p-8 mb-8 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
        <span class="text-3xl">⚡</span> Quick Actions
    </h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if(auth()->user()->isAdmin())
        <!-- Admin Quick Actions -->
        <a href="{{ route('admin.users.index') }}" class="group p-6 bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <span class="text-2xl">👥</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">Manage Users</h3>
                    <p class="text-blue-100 text-sm">Add, edit, or delete users</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm opacity-90">Access Control</span>
                <span class="text-2xl group-hover:translate-x-1 transition-transform">→</span>
            </div>
        </a>

        <a href="{{ route('admin.games.index') }}" class="group p-6 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <span class="text-2xl">🎮</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">Manage Games</h3>
                    <p class="text-green-100 text-sm">Create and manage learning games</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm opacity-90">Game Library</span>
                <span class="text-2xl group-hover:translate-x-1 transition-transform">→</span>
            </div>
        </a>

        <a href="{{ route('admin.questions.index') }}" class="group p-6 bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <span class="text-2xl">❓</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">Manage Questions</h3>
                    <p class="text-purple-100 text-sm">Add questions to games</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm opacity-90">Question Bank</span>
                <span class="text-2xl group-hover:translate-x-1 transition-transform">→</span>
            </div>
        </a>

        @elseif(auth()->user()->isTeacher())
        <!-- Teacher Quick Actions -->
        <a href="{{ route('ustadz.games.index') }}" class="group p-6 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <span class="text-2xl">🎮</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">My Games</h3>
                    <p class="text-green-100 text-sm">Manage your learning games</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm opacity-90">Game Management</span>
                <span class="text-2xl group-hover:translate-x-1 transition-transform">→</span>
            </div>
        </a>

        <a href="{{ route('ustadz.questions.index') }}" class="group p-6 bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <span class="text-2xl">📝</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">Questions</h3>
                    <p class="text-purple-100 text-sm">Manage game questions</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm opacity-90">Question Bank</span>
                <span class="text-2xl group-hover:translate-x-1 transition-transform">→</span>
            </div>
        </a>

        <a href="{{ route('ustadz.scores.index') }}" class="group p-6 bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <span class="text-2xl">📊</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">Student Scores</h3>
                    <p class="text-blue-100 text-sm">View student progress</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm opacity-90">Performance Tracking</span>
                <span class="text-2xl group-hover:translate-x-1 transition-transform">→</span>
            </div>
        </a>

        @elseif(auth()->user()->isSantri())
        <!-- Santri Quick Actions -->
        <a href="{{ route('santri.games.index') }}" class="group p-6 bg-gradient-to-br from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <span class="text-2xl">🎮</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">Play Games</h3>
                    <p class="text-emerald-100 text-sm">Start learning Arabic</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm opacity-90">Learning Center</span>
                <span class="text-2xl group-hover:translate-x-1 transition-transform">→</span>
            </div>
        </a>

        <a href="{{ route('santri.scores') }}" class="group p-6 bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <span class="text-2xl">📈</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">My Scores</h3>
                    <p class="text-blue-100 text-sm">View your learning progress</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm opacity-90">Progress Tracking</span>
                <span class="text-2xl group-hover:translate-x-1 transition-transform">→</span>
            </div>
        </a>

        <a href="{{ route('santri.leaderboard') }}" class="group p-6 bg-gradient-to-br from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <span class="text-2xl">🏆</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">Leaderboard</h3>
                    <p class="text-amber-100 text-sm">Compare with other students</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm opacity-90">Competition</span>
                <span class="text-2xl group-hover:translate-x-1 transition-transform">→</span>
            </div>
        </a>
        @endif
    </div>
</div>

<!-- Recent Activity Section -->
@if(auth()->user()->isSantri())
<div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
        <span class="text-3xl">📅</span> Recent Activity
    </h2>
    
    @php
        $recentScores = \App\Models\Score::where('user_id', auth()->id())
            ->with('game')
            ->orderBy('completed_at', 'desc')
            ->take(5)
            ->get();
    @endphp

    @if($recentScores->count() > 0)
    <div class="space-y-4">
        @foreach($recentScores as $score)
        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white border-2 border-gray-100 rounded-xl hover:shadow-lg hover:border-blue-200 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <span class="text-xl text-blue-600">
                        @if($score->game->type == 'tebak_gambar') 🖼️
                        @elseif($score->game->type == 'kosakata_tempat') 🏫
                        @elseif($score->game->type == 'pilihan_ganda') ✅
                        @else 💬
                        @endif
                    </span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">{{ $score->game->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $score->completed_at->diffForHumans() }}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    {{ $score->score }}%
                </div>
                <div class="text-sm text-gray-600">{{ $score->correct_answers }}/{{ $score->total_questions }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12">
        <div class="text-6xl mb-4">🎮</div>
        <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Aktivitas</h3>
        <p class="text-gray-600 mb-6">Mulai bermain game untuk melihat aktivitasmu di sini!</p>
        <a href="{{ route('santri.games.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold px-6 py-3 rounded-xl hover:shadow-xl transition-all duration-300">
            <span>🚀</span> Mulai Belajar Sekarang
        </a>
    </div>
    @endif
</div>
@endif

<!-- Motivational Quote -->
<div class="mt-8 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-lg p-8 border border-indigo-100">
    <div class="text-center">
        <div class="text-5xl mb-4 animate-pulse">📖</div>
        <div class="mb-4 bg-white/50 backdrop-blur-sm rounded-xl py-4 px-6 inline-block">
            <p class="text-2xl font-bold bg-gradient-to-r from-indigo-800 to-purple-700 bg-clip-text text-transparent font-arabic">
                وَقُل رَّبِّ زِدْنِي عِلْمًا
            </p>
        </div>
        <p class="text-lg text-gray-700 font-semibold mb-3">"Dan katakanlah: Ya Tuhanku, tambahkanlah kepadaku ilmu pengetahuan."</p>
        <p class="text-gray-600">(QS. Thaha: 114)</p>
    </div>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.font-arabic {
    font-family: 'Traditional Arabic', 'Scheherazade New', serif;
    font-size: 1.5em;
}
</style>
@endsection