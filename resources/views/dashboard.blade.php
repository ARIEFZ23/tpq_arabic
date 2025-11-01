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
@endsection