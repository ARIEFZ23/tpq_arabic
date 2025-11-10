@extends('layouts.santri')

@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <!-- Profile Header - Islamic Theme with Enhanced Visuals -->
    <div class="bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-3xl shadow-2xl p-6 sm:p-8 text-white mb-6 relative overflow-hidden transform hover:scale-[1.02] transition-all duration-300">
        <!-- Animated Decorative Patterns -->
        <div class="absolute top-0 right-0 opacity-10 animate-pulse">
            <svg class="w-48 h-48" viewBox="0 0 200 200" fill="currentColor">
                <path d="M100,20 L110,50 L140,50 L115,70 L125,100 L100,80 L75,100 L85,70 L60,50 L90,50 Z"/>
            </svg>
        </div>
        <div class="absolute bottom-0 left-0 opacity-10 animate-pulse" style="animation-delay: 1s;">
            <svg class="w-32 h-32" viewBox="0 0 200 200" fill="currentColor">
                <path d="M100,20 L110,50 L140,50 L115,70 L125,100 L100,80 L75,100 L85,70 L60,50 L90,50 Z"/>
            </svg>
        </div>
        
        <!-- Floating particles effect -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-2 h-2 bg-white rounded-full opacity-20 animate-float" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float" style="top: 60%; left: 80%; animation-delay: 2s;"></div>
            <div class="absolute w-1.5 h-1.5 bg-white rounded-full opacity-25 animate-float" style="top: 40%; left: 30%; animation-delay: 4s;"></div>
        </div>
        
        <div class="relative flex flex-col md:flex-row items-center md:items-start md:space-x-6 space-y-4 md:space-y-0">
            
            <!-- Avatar dengan Upload - Enhanced -->
            <div class="relative group flex-shrink-0">
                <div class="absolute -inset-1 bg-gradient-to-r from-pink-300 via-purple-300 to-indigo-300 rounded-full blur opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-pulse"></div>
                
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                         alt="Profile Photo" 
                         class="relative w-28 h-28 sm:w-32 sm:h-32 rounded-full object-cover border-4 border-white shadow-xl transform group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="relative w-28 h-28 sm:w-32 sm:h-32 bg-white rounded-full flex items-center justify-center text-5xl sm:text-6xl border-4 border-white shadow-xl transform group-hover:scale-105 transition-transform duration-300">
                        {{ $user->role == 'santri_putra' ? '👦' : '👧' }}
                    </div>
                @endif
                
                <!-- Upload Button Overlay - Enhanced -->
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-teal-600 bg-opacity-90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-sm"
                     x-data="{ showModal: false }">
                    <button @click="showModal = true" class="text-white text-sm font-bold px-3 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transform hover:scale-110 transition-all duration-200 shadow-lg">
                        📸 Ubah
                    </button>
                    
                    <!-- Modal Upload Photo - Enhanced -->
                    <div x-show="showModal" 
                         @click.away="showModal = false"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-90"
                         class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4 backdrop-blur-sm"
                         style="display: none;">
                        <div class="bg-white rounded-2xl p-6 max-w-md w-full transform shadow-2xl" @click.stop>
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <span class="text-2xl">📸</span> Upload Foto Profil
                            </h3>
                            
                            <form action="{{ route('santri.profile.photo.update') }}" 
                                  method="POST" 
                                  enctype="multipart/form-data"
                                  class="space-y-4">
                                @csrf
                                
                                <div class="relative">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Pilih Foto
                                    </label>
                                    <input type="file" 
                                           name="profile_photo" 
                                           accept="image/*"
                                           required
                                           class="block w-full text-sm text-gray-600
                                                  file:mr-4 file:py-2.5 file:px-4
                                                  file:rounded-lg file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-gradient-to-r file:from-emerald-50 file:to-teal-50 file:text-emerald-700
                                                  hover:file:from-emerald-100 hover:file:to-teal-100 cursor-pointer
                                                  transition-all duration-200">
                                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                        <span>ℹ️</span> Format: JPG, PNG, GIF • Maksimal: 2MB
                                    </p>
                                </div>
                                
                                <div class="flex gap-3">
                                    <button type="submit" 
                                            class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-200 active:scale-95 shadow-lg hover:shadow-xl">
                                        ✨ Upload
                                    </button>
                                    <button type="button" 
                                            @click="showModal = false"
                                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-4 rounded-xl transition-all duration-200 active:scale-95">
                                        Batal
                                    </button>
                                </div>
                            </form>
                            
                            @if($user->profile_photo)
                                <form action="{{ route('santri.profile.photo.delete') }}" 
                                      method="POST" 
                                      class="mt-4"
                                      onsubmit="return confirm('Hapus foto profil?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-200 active:scale-95 shadow-lg hover:shadow-xl">
                                        🗑️ Hapus Foto
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Info - Enhanced -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-2xl sm:text-3xl font-bold mb-2 drop-shadow-lg">{{ $user->name }}</h1>
                <p class="text-base sm:text-lg opacity-90 mb-3 flex items-center justify-center md:justify-start gap-2">
                    <span>✉️</span> {{ $user->email }}
                </p>
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm shadow-lg border border-white/30">
                    <span>{{ $user->role == 'santri_putra' ? '👨‍🎓 Santri Putra' : '👩‍🎓 Santri Putri' }}</span>
                    @if($user->class_id)
                        <span>•</span>
                        <span class="font-semibold">{{ $user->class_id }}</span>
                    @endif
                </div>
            </div>
            
            <!-- Level Badge - Enhanced -->
            <div class="text-center bg-white/10 backdrop-blur-md rounded-2xl p-4 md:p-5 border-2 border-white/20 shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="text-4xl sm:text-5xl mb-2 animate-bounce">
                    @php
                        $levelEmoji = ['🌱', '📚', '⭐', '🏆', '👑'];
                        echo $levelEmoji[min($user->level - 1, 4)] ?? '🌱';
                    @endphp
                </div>
                <div class="text-xl sm:text-2xl font-bold drop-shadow-lg">Level {{ $user->level }}</div>
                <div class="text-xs sm:text-sm opacity-90 font-semibold mt-1">
                    @php
                        $levelNames = ['Pemula', 'Pelajar', 'Mahir', 'Juara', 'Master'];
                        echo $levelNames[min($user->level - 1, 4)] ?? 'Pemula';
                    @endphp
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Grid - Enhanced -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        
        <!-- Total XP -->
        <div class="group bg-white rounded-2xl shadow-lg p-5 text-center border-t-4 border-amber-400 hover:shadow-2xl transition-all duration-300 active:scale-95 cursor-pointer relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-amber-100 to-amber-50 rounded-full flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                    <span class="text-3xl animate-pulse">⚡</span>
                </div>
                <div class="text-3xl font-bold bg-gradient-to-r from-amber-600 to-amber-500 bg-clip-text text-transparent mb-1">{{ number_format($user->experience_points) }}</div>
                <div class="text-sm font-semibold text-gray-600">Total XP</div>
            </div>
        </div>

        <!-- Games Completed -->
        <div class="group bg-white rounded-2xl shadow-lg p-5 text-center border-t-4 border-blue-400 hover:shadow-2xl transition-all duration-300 active:scale-95 cursor-pointer relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                    <span class="text-3xl">🎮</span>
                </div>
                <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent mb-1">{{ $user->total_games_completed }}</div>
                <div class="text-sm font-semibold text-gray-600">Games Selesai</div>
            </div>
        </div>

        <!-- Current Badge -->
        <div class="group bg-white rounded-2xl shadow-lg p-5 text-center border-t-4 border-purple-400 hover:shadow-2xl transition-all duration-300 active:scale-95 cursor-pointer relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-purple-100 to-purple-50 rounded-full flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                    <span class="text-3xl group-hover:animate-spin">
                        @if($user->current_badge == 'bronze') 🥉
                        @elseif($user->current_badge == 'silver') 🥈
                        @elseif($user->current_badge == 'gold') 🥇
                        @elseif($user->current_badge == 'diamond') 💎
                        @else 🎖️
                        @endif
                    </span>
                </div>
                <div class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-purple-500 bg-clip-text text-transparent mb-1">{{ ucfirst($user->current_badge ?? 'None') }}</div>
                <div class="text-sm font-semibold text-gray-600">Badge Saat Ini</div>
            </div>
        </div>
    </div>

    <!-- Progress to Next Level - Enhanced -->
    <div class="bg-white rounded-2xl shadow-lg p-5 sm:p-6 mb-6 border-l-4 border-emerald-500 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-100 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        
        <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center gap-2 relative">
            <span class="text-2xl">📈</span> Progress ke Level Berikutnya
        </h2>
        
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
            <div class="relative">
                <div class="flex justify-between text-sm font-semibold text-gray-600 mb-2">
                    <span class="flex items-center gap-1">
                        <span>🎯</span> Level {{ $currentLevel }}
                    </span>
                    <span class="flex items-center gap-1">
                        Level {{ $currentLevel + 1 }} <span>🎯</span>
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-8 overflow-hidden shadow-inner relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-shimmer"></div>
                    <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-500 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold transition-all duration-500 shadow-lg relative overflow-hidden"
                         style="width: {{ $percentage }}%">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-20 animate-pulse"></div>
                        <span class="relative">{{ number_format($percentage, 1) }}%</span>
                    </div>
                </div>
                <div class="text-center mt-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg py-2 px-4">
                    <span class="text-sm text-gray-700 font-medium">{{ $xpInLevel }} / {{ $xpNeeded }} XP</span>
                    <span class="text-sm font-bold ml-2 bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                        🎯 {{ $nextLevelXP - $currentXP }} XP lagi!
                    </span>
                </div>
            </div>
        @else
            <div class="text-center py-6 bg-gradient-to-br from-amber-50 via-yellow-50 to-amber-100 rounded-xl shadow-inner relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-transparent via-white to-transparent animate-shimmer"></div>
                </div>
                <div class="text-5xl mb-3 animate-bounce">👑</div>
                <div class="text-xl font-bold bg-gradient-to-r from-amber-600 to-yellow-600 bg-clip-text text-transparent mb-2">Level Maksimal Tercapai!</div>
                <div class="text-gray-700 font-medium">Terus bermain untuk mempertahankan status Master-mu! 🌟</div>
            </div>
        @endif
    </div>

    <!-- Achievements & Badges - Enhanced -->
    <div class="bg-white rounded-2xl shadow-lg p-5 sm:p-6 mb-6 border-l-4 border-amber-500 hover:shadow-2xl transition-all duration-300">
        <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center gap-2">
            <span class="text-2xl">🏆</span> Pencapaian & Badge
        </h2>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            
            <!-- Bronze Badge -->
            <div class="text-center p-4 rounded-xl transform hover:scale-105 hover:-rotate-2 transition-all duration-300 active:scale-95 cursor-pointer relative overflow-hidden
                        {{ $user->total_games_completed >= 10 ? 'bg-gradient-to-br from-orange-100 to-orange-50 border-2 border-orange-300 shadow-md' : 'bg-gray-100 opacity-60' }}">
                @if($user->total_games_completed >= 10)
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-shimmer"></div>
                @endif
                <div class="w-16 h-16 mx-auto mb-2 flex items-center justify-center bg-white rounded-full shadow-md relative">
                    <span class="text-4xl {{ $user->total_games_completed >= 10 ? 'animate-bounce' : '' }}">🥉</span>
                </div>
                <div class="font-bold text-gray-800">Bronze</div>
                <div class="text-xs text-gray-600 mb-2 font-semibold">10 Games</div>
                @if($user->total_games_completed >= 10)
                    <div class="text-xs font-bold text-green-600 bg-green-50 py-1 px-2 rounded-full border border-green-200">✓ Terbuka!</div>
                @else
                    <div class="text-xs text-gray-500 font-medium">{{ 10 - $user->total_games_completed }} lagi</div>
                @endif
            </div>

            <!-- Silver Badge -->
            <div class="text-center p-4 rounded-xl transform hover:scale-105 hover:rotate-2 transition-all duration-300 active:scale-95 cursor-pointer relative overflow-hidden
                        {{ $user->total_games_completed >= 25 ? 'bg-gradient-to-br from-gray-200 to-gray-50 border-2 border-gray-400 shadow-md' : 'bg-gray-100 opacity-60' }}">
                @if($user->total_games_completed >= 25)
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-shimmer"></div>
                @endif
                <div class="w-16 h-16 mx-auto mb-2 flex items-center justify-center bg-white rounded-full shadow-md relative">
                    <span class="text-4xl {{ $user->total_games_completed >= 25 ? 'animate-bounce' : '' }}">🥈</span>
                </div>
                <div class="font-bold text-gray-800">Silver</div>
                <div class="text-xs text-gray-600 mb-2 font-semibold">25 Games</div>
                @if($user->total_games_completed >= 25)
                    <div class="text-xs font-bold text-green-600 bg-green-50 py-1 px-2 rounded-full border border-green-200">✓ Terbuka!</div>
                @else
                    <div class="text-xs text-gray-500 font-medium">{{ 25 - $user->total_games_completed }} lagi</div>
                @endif
            </div>

            <!-- Gold Badge -->
            <div class="text-center p-4 rounded-xl transform hover:scale-105 hover:-rotate-2 transition-all duration-300 active:scale-95 cursor-pointer relative overflow-hidden
                        {{ $user->total_games_completed >= 50 ? 'bg-gradient-to-br from-yellow-200 to-yellow-50 border-2 border-yellow-400 shadow-md' : 'bg-gray-100 opacity-60' }}">
                @if($user->total_games_completed >= 50)
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-shimmer"></div>
                @endif
                <div class="w-16 h-16 mx-auto mb-2 flex items-center justify-center bg-white rounded-full shadow-md relative">
                    <span class="text-4xl {{ $user->total_games_completed >= 50 ? 'animate-bounce' : '' }}">🥇</span>
                </div>
                <div class="font-bold text-gray-800">Gold</div>
                <div class="text-xs text-gray-600 mb-2 font-semibold">50 Games</div>
                @if($user->total_games_completed >= 50)
                    <div class="text-xs font-bold text-green-600 bg-green-50 py-1 px-2 rounded-full border border-green-200">✓ Terbuka!</div>
                @else
                    <div class="text-xs text-gray-500 font-medium">{{ 50 - $user->total_games_completed }} lagi</div>
                @endif
            </div>

            <!-- Diamond Badge -->
            <div class="text-center p-4 rounded-xl transform hover:scale-105 hover:rotate-2 transition-all duration-300 active:scale-95 cursor-pointer relative overflow-hidden
                        {{ $user->total_games_completed >= 100 ? 'bg-gradient-to-br from-blue-200 to-cyan-50 border-2 border-blue-400 shadow-md' : 'bg-gray-100 opacity-60' }}">
                @if($user->total_games_completed >= 100)
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-shimmer"></div>
                @endif
                <div class="w-16 h-16 mx-auto mb-2 flex items-center justify-center bg-white rounded-full shadow-md relative">
                    <span class="text-4xl {{ $user->total_games_completed >= 100 ? 'animate-bounce' : '' }}">💎</span>
                </div>
                <div class="font-bold text-gray-800">Diamond</div>
                <div class="text-xs text-gray-600 mb-2 font-semibold">100 Games</div>
                @if($user->total_games_completed >= 100)
                    <div class="text-xs font-bold text-green-600 bg-green-50 py-1 px-2 rounded-full border border-green-200">✓ Terbuka!</div>
                @else
                    <div class="text-xs text-gray-500 font-medium">{{ 100 - $user->total_games_completed }} lagi</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity - Enhanced -->
    <div class="bg-white rounded-2xl shadow-lg p-5 sm:p-6 mb-6 border-l-4 border-teal-500 hover:shadow-2xl transition-all duration-300">
        <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center gap-2">
            <span class="text-2xl">📅</span> Aktivitas Terakhir
        </h2>
        
        @if($recentScores->count() > 0)
            <div class="space-y-3">
                @foreach($recentScores as $score)
                    <div class="group flex items-center justify-between p-3 sm:p-4 bg-gradient-to-r from-gray-50 to-white border-2 border-gray-100 rounded-xl hover:shadow-lg hover:border-teal-200 transition-all duration-300 active:scale-[0.98] cursor-pointer relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-teal-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="flex items-center gap-3 flex-1 min-w-0 relative">
                            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-gradient-to-br from-teal-100 to-emerald-100 rounded-lg group-hover:scale-110 transition-transform duration-300 shadow-md">
                                <span class="text-2xl">
                                    @if($score->game->type == 'tebak_gambar') 🖼️
                                    @elseif($score->game->type == 'kosakata_tempat') 🏫
                                    @elseif($score->game->type == 'pilihan_ganda') ✅
                                    @else 💬
                                    @endif
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-800 text-sm truncate group-hover:text-teal-700 transition-colors">{{ $score->game->title }}</div>
                                <div class="text-xs text-gray-500 flex items-center gap-1">
                                    <span>⏰</span> {{ $score->completed_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0 ml-3 relative">
                            <div class="text-xl font-bold bg-gradient-to-r from-teal-600 to-emerald-600 bg-clip-text text-transparent">{{ $score->score }}%</div>
                            <div class="text-xs text-gray-500 font-medium">{{ $score->correct_answers }}/{{ $score->total_questions }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('santri.scores') }}" 
                   class="inline-flex items-center gap-2 text-teal-600 hover:text-teal-700 font-semibold text-sm px-6 py-3 rounded-xl hover:bg-teal-50 transition-all duration-200 active:scale-95 border-2 border-teal-200 hover:border-teal-300 shadow-sm hover:shadow-md">
                    <span>📊</span> Lihat Semua Nilai <span>→</span>
                </a>
            </div>
        @else
            <div class="text-center py-8 sm:py-12 relative">
                <div class="absolute inset-0 bg-gradient-to-br from-teal-50 to-emerald-50 rounded-xl opacity-50"></div>
                <div class="relative">
                    <div class="text-5xl sm:text-6xl mb-4 animate-bounce">🎮</div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-700 mb-2">Belum Ada Aktivitas</h3>
                    <p class="text-gray-600 mb-6 text-sm sm:text-base">Mulai bermain untuk melihat aktivitasmu di sini!</p>
                    <a href="{{ route('santri.games') }}" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold px-6 sm:px-8 py-3 rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-300 active:scale-95 shadow-lg">
                        <span>🎮</span> Mulai Bermain Sekarang! <span>✨</span>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Motivational Quote - Islamic Enhanced -->
    <div class="bg-gradient-to-br from-teal-50 via-emerald-50 to-cyan-50 rounded-2xl shadow-lg p-6 sm:p-8 text-center border-2 border-emerald-200 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
        <!-- Decorative corners -->
        <div class="absolute top-0 left-0 w-20 h-20 border-t-4 border-l-4 border-emerald-300 rounded-tl-2xl opacity-50"></div>
        <div class="absolute top-0 right-0 w-20 h-20 border-t-4 border-r-4 border-emerald-300 rounded-tr-2xl opacity-50"></div>
        <div class="absolute bottom-0 left-0 w-20 h-20 border-b-4 border-l-4 border-emerald-300 rounded-bl-2xl opacity-50"></div>
        <div class="absolute bottom-0 right-0 w-20 h-20 border-b-4 border-r-4 border-emerald-300 rounded-br-2xl opacity-50"></div>
        
        <div class="relative">
            <div class="mb-4 animate-pulse">
                <span class="text-5xl drop-shadow-lg">📖</span>
            </div>
            <div class="mb-3 bg-white/50 backdrop-blur-sm rounded-xl py-3 px-4 inline-block">
                <p class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-emerald-800 to-teal-700 bg-clip-text text-transparent font-arabic">
                    من جدّ وجد
                </p>
            </div>
            <p class="text-base sm:text-lg text-gray-700 font-semibold mb-3">
                "Barangsiapa bersungguh-sungguh, pasti berhasil."
            </p>
            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-100 to-teal-100 px-4 py-2 rounded-full border border-emerald-200">
                <span class="text-2xl">💪</span>
                <p class="text-sm font-bold text-emerald-800">
                    Terus semangat dalam belajar!
                </p>
                <span class="text-2xl">✨</span>
            </div>
        </div>
    </div>

</div>

<style>
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(100%);
        }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    .animate-shimmer {
        animation: shimmer 3s infinite;
    }

    /* Custom hover effects */
    .group:hover .group-hover\:animate-spin {
        animation: spin 1s linear infinite;
    }
</style>

@endsection