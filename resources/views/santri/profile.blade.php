@extends('layouts.santri')

@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg shadow-lg p-8 text-white mb-6">
        <div class="flex flex-col md:flex-row items-center md:space-x-6 space-y-4 md:space-y-0">
            <!-- Avatar dengan Upload -->
            <div class="relative group">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                         alt="Profile Photo" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                @else
                    <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center text-6xl border-4 border-white shadow-lg">
                        {{ $user->role == 'santri_putra' ? '👦' : '👧' }}
                    </div>
                @endif
                
                <!-- Upload Button Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer"
                     x-data="{ showModal: false }">
                    <button @click="showModal = true" class="text-white text-sm font-bold">
                        📸 Change
                    </button>
                    
                    <!-- Modal Upload Photo -->
                    <div x-show="showModal" 
                         @click.away="showModal = false"
                         x-transition
                         class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
                         style="display: none;">
                        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4" @click.stop>
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Upload Profile Photo</h3>
                            
                            <form action="{{ route('santri.profile.photo.update') }}" 
                                  method="POST" 
                                  enctype="multipart/form-data"
                                  class="space-y-4">
                                @csrf
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Choose Photo
                                    </label>
                                    <input type="file" 
                                           name="profile_photo" 
                                           accept="image/*"
                                           required
                                           class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-full file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-blue-50 file:text-blue-700
                                                  hover:file:bg-blue-100">
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF (Max: 2MB)</p>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <button type="submit" 
                                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition">
                                        Upload
                                    </button>
                                    <button type="button" 
                                            @click="showModal = false"
                                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded-lg transition">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                            
                            @if($user->profile_photo)
                                <form action="{{ route('santri.profile.photo.delete') }}" 
                                      method="POST" 
                                      class="mt-4"
                                      onsubmit="return confirm('Remove profile photo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition">
                                        🗑️ Remove Photo
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Info -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl font-bold mb-2">{{ $user->name }}</h1>
                <p class="text-lg opacity-90">{{ $user->email }}</p>
                <p class="text-sm opacity-75 mt-1">
                    {{ $user->role == 'santri_putra' ? 'Santri Putra' : 'Santri Putri' }}
                    @if($user->class_id)
                        • {{ $user->class_id }}
                    @endif
                </p>
            </div>
            
            <!-- Level Badge -->
            <div class="text-center">
                <div class="text-5xl mb-2">
                    @php
                        $levelEmoji = ['🌱', '📚', '⭐', '🏆', '👑'];
                        echo $levelEmoji[min($user->level - 1, 4)] ?? '🌱';
                    @endphp
                </div>
                <div class="text-2xl font-bold">Level {{ $user->level }}</div>
                <div class="text-sm opacity-75">
                    @php
                        $levelNames = ['Pemula', 'Pelajar', 'Mahir', 'Juara', 'Master'];
                        echo $levelNames[min($user->level - 1, 4)] ?? 'Pemula';
                    @endphp
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total XP -->
        <div class="bg-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition">
            <div class="text-4xl mb-2">⚡</div>
            <div class="text-3xl font-bold text-yellow-600">{{ number_format($user->experience_points) }}</div>
            <div class="text-gray-600">Total XP</div>
        </div>

        <!-- Games Completed -->
        <div class="bg-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition">
            <div class="text-4xl mb-2">🎮</div>
            <div class="text-3xl font-bold text-blue-600">{{ $user->total_games_completed }}</div>
            <div class="text-gray-600">Games Completed</div>
        </div>

        <!-- Current Badge -->
        <div class="bg-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition">
            <div class="text-4xl mb-2">
                @if($user->current_badge == 'bronze')
                    🥉
                @elseif($user->current_badge == 'silver')
                    🥈
                @elseif($user->current_badge == 'gold')
                    🥇
                @elseif($user->current_badge == 'diamond')
                    💎
                @else
                    🎖️
                @endif
            </div>
            <div class="text-3xl font-bold text-purple-600">{{ ucfirst($user->current_badge ?? 'None') }}</div>
            <div class="text-gray-600">Current Badge</div>
        </div>
    </div>

    <!-- Progress to Next Level -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">📈 Progress to Next Level</h2>
        
        @php
            $currentXP = $user->experience_points;
            $levelThresholds = [0, 100, 300, 600, 1000];
            $currentLevel = $user->level;
            
            if ($currentLevel < 5) {
                $currentLevelXP = $levelThresholds[$currentLevel - 1];
                $nextLevelXP = $levelThresholds[$currentLevel];
                $xpInLevel = $currentXP - $currentLevelXP;
                $xpNeeded = $nextLevelXP - $currentLevelXP;
                $percentage = ($xpInLevel / $xpNeeded) * 100;
            } else {
                $percentage = 100;
                $xpInLevel = $currentXP;
                $xpNeeded = $currentXP;
            }
        @endphp

        @if($currentLevel < 5)
            <div class="mb-2">
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Level {{ $currentLevel }}</span>
                    <span>Level {{ $currentLevel + 1 }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold transition-all duration-500"
                         style="width: {{ $percentage }}%">
                        {{ number_format($percentage, 1) }}%
                    </div>
                </div>
                <div class="text-center mt-2 text-gray-600">
                    {{ $xpInLevel }} / {{ $xpNeeded }} XP
                    <span class="text-yellow-600 font-bold">({{ $nextLevelXP - $currentXP }} XP to go!)</span>
                </div>
            </div>
        @else
            <div class="text-center py-4">
                <div class="text-4xl mb-2">👑</div>
                <div class="text-xl font-bold text-yellow-600">You've reached MAX LEVEL!</div>
                <div class="text-gray-600">Keep playing to maintain your Master status!</div>
            </div>
        @endif
    </div>

    <!-- Achievements & Badges -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">🏆 Achievements & Badges</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Bronze Badge -->
            <div class="text-center p-4 rounded-lg transform hover:scale-105 transition {{ $user->total_games_completed >= 10 ? 'bg-orange-100 border-2 border-orange-300' : 'bg-gray-100 opacity-50' }}">
                <div class="text-5xl mb-2">🥉</div>
                <div class="font-bold">Bronze</div>
                <div class="text-sm text-gray-600">10 Games</div>
                @if($user->total_games_completed >= 10)
                    <div class="text-xs text-green-600 mt-1">✓ Unlocked!</div>
                @else
                    <div class="text-xs text-gray-500 mt-1">{{ 10 - $user->total_games_completed }} to go</div>
                @endif
            </div>

            <!-- Silver Badge -->
            <div class="text-center p-4 rounded-lg transform hover:scale-105 transition {{ $user->total_games_completed >= 25 ? 'bg-gray-100 border-2 border-gray-400' : 'bg-gray-100 opacity-50' }}">
                <div class="text-5xl mb-2">🥈</div>
                <div class="font-bold">Silver</div>
                <div class="text-sm text-gray-600">25 Games</div>
                @if($user->total_games_completed >= 25)
                    <div class="text-xs text-green-600 mt-1">✓ Unlocked!</div>
                @else
                    <div class="text-xs text-gray-500 mt-1">{{ 25 - $user->total_games_completed }} to go</div>
                @endif
            </div>

            <!-- Gold Badge -->
            <div class="text-center p-4 rounded-lg transform hover:scale-105 transition {{ $user->total_games_completed >= 50 ? 'bg-yellow-100 border-2 border-yellow-400' : 'bg-gray-100 opacity-50' }}">
                <div class="text-5xl mb-2">🥇</div>
                <div class="font-bold">Gold</div>
                <div class="text-sm text-gray-600">50 Games</div>
                @if($user->total_games_completed >= 50)
                    <div class="text-xs text-green-600 mt-1">✓ Unlocked!</div>
                @else
                    <div class="text-xs text-gray-500 mt-1">{{ 50 - $user->total_games_completed }} to go</div>
                @endif
            </div>

            <!-- Diamond Badge -->
            <div class="text-center p-4 rounded-lg transform hover:scale-105 transition {{ $user->total_games_completed >= 100 ? 'bg-blue-100 border-2 border-blue-400' : 'bg-gray-100 opacity-50' }}">
                <div class="text-5xl mb-2">💎</div>
                <div class="font-bold">Diamond</div>
                <div class="text-sm text-gray-600">100 Games</div>
                @if($user->total_games_completed >= 100)
                    <div class="text-xs text-green-600 mt-1">✓ Unlocked!</div>
                @else
                    <div class="text-xs text-gray-500 mt-1">{{ 100 - $user->total_games_completed }} to go</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">📅 Recent Activity</h2>
        
        @if($recentScores->count() > 0)
            <div class="space-y-3">
                @foreach($recentScores as $score)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex items-center space-x-4">
                            <div class="text-3xl">
                                @if($score->game->type == 'tebak_gambar')
                                    🖼️
                                @elseif($score->game->type == 'kosakata_tempat')
                                    📍
                                @elseif($score->game->type == 'pilihan_ganda')
                                    ✅
                                @else
                                    💬
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $score->game->title }}</div>
                                <div class="text-sm text-gray-600">
                                    {{ $score->completed_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-green-600">{{ $score->score }}%</div>
                            <div class="text-xs text-gray-600">{{ $score->correct_answers }}/{{ $score->total_questions }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('santri.scores') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                    View All Scores →
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">🎮</div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No Activity Yet</h3>
                <p class="text-gray-600 mb-6">Start playing games to see your activity here!</p>
                <a href="{{ route('santri.games') }}" 
                   class="inline-block bg-gradient-to-r from-blue-500 to-purple-500 text-white font-bold px-8 py-3 rounded-lg hover:shadow-lg transform hover:scale-105 transition">
                    🎮 Start Playing Now!
                </a>
            </div>
        @endif
    </div>

    <!-- Motivational Quote -->
    <div class="bg-gradient-to-r from-green-400 to-blue-500 rounded-lg shadow-lg p-6 text-white text-center">
        <div class="text-3xl mb-2">💪</div>
        <div class="tex