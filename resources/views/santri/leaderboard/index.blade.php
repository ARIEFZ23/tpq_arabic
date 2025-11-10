@extends('layouts.santri')

@section('title', 'Papan Peringkat')

@section('content')
<style>
    @keyframes crown-bounce {
        0%, 100% { transform: translateY(0) rotate(-5deg); }
        50% { transform: translateY(-5px) rotate(5deg); }
    }
    .animate-crown { animation: crown-bounce 2s ease-in-out infinite; }

    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(234, 179, 8, 0.4); }
        50% { box-shadow: 0 0 40px rgba(234, 179, 8, 0.6); }
    }
    .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
</style>

<!-- Header -->
<div class="text-center mb-10"
     x-data="{ show: false }" 
     x-init="setTimeout(() => show = true, 100)"
     x-show="show"
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-[-20px]">
    <div class="inline-block mb-4">
        <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-3xl blur-xl opacity-60 animate-pulse"></div>
            <div class="relative bg-gradient-to-br from-yellow-400 to-orange-500 rounded-3xl p-6 shadow-2xl">
                <span class="text-7xl animate-crown">🏆</span>
            </div>
        </div>
    </div>
    <h1 class="text-4xl sm:text-5xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent mb-3">
        Papan Peringkat
    </h1>
    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
        Lihat santri teratas dengan XP tertinggi dan raih posisi terbaikmu! 🌟
    </p>
</div>

<!-- Top 5 Overall -->
<div class="mb-12"
     x-data="{ show: false }" 
     x-init="setTimeout(() => show = true, 300)"
     x-show="show"
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 scale-95">
    <div class="bg-white rounded-3xl shadow-2xl border-4 border-yellow-300 overflow-hidden">
        <div class="relative bg-gradient-to-r from-yellow-400 via-orange-400 to-red-500 p-6 overflow-hidden">
            <div class="absolute inset-0 animate-shimmer"></div>
            <h2 class="relative text-3xl font-bold text-white text-center drop-shadow-lg">
                🌟 Top 5 Santri Keseluruhan 🌟
            </h2>
        </div>
        <div class="p-6 space-y-3">
            @forelse($topOverall as $index => $santri)
                <div class="group relative flex items-center justify-between p-5 rounded-2xl transition-all hover:scale-102
                    @if($santri->id == $currentUser->id)
                        bg-gradient-to-r from-yellow-100 to-orange-100 border-2 border-yellow-400 animate-pulse-glow
                    @elseif($index == 0)
                        bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-300 shadow-lg
                    @elseif($index == 1)
                        bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-300 shadow-md
                    @elseif($index == 2)
                        bg-gradient-to-r from-orange-50 to-red-50 border-2 border-orange-300 shadow-md
                    @else
                        bg-gray-50 border-2 border-gray-200 hover:border-emerald-300 hover:bg-emerald-50
                    @endif
                ">
                    <div class="flex items-center space-x-4">
                        <!-- Medal/Trophy -->
                        <div class="flex-shrink-0 w-12 text-center">
                            @if($index == 0)
                                <span class="text-5xl drop-shadow-lg">🥇</span>
                            @elseif($index == 1)
                                <span class="text-5xl drop-shadow-lg">🥈</span>
                            @elseif($index == 2)
                                <span class="text-5xl drop-shadow-lg">🥉</span>
                            @else
                                <span class="text-3xl font-bold text-gray-400">{{ $index + 1 }}</span>
                            @endif
                        </div>
                        <!-- Avatar & Info -->
                        <div class="flex items-center space-x-3">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-2xl shadow-lg">
                                @if($santri->role == 'santri_putri')
                                    👩‍🎓
                                @else
                                    👨‍🎓
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 text-lg flex items-center gap-2">
                                    <span>{{ $santri->name }}</span>
                                    @if($santri->role == 'santri_putri')
                                        <span class="text-pink-500">♀️</span>
                                    @else
                                        <span class="text-blue-500">♂️</span>
                                    @endif
                                    @if($santri->id == $currentUser->id)
                                        <span class="text-xs bg-emerald-500 text-white px-2 py-1 rounded-full">Kamu</span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-600 flex items-center gap-2">
                                    <span class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">Level {{ $santri->level }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- XP -->
                    <div class="text-right">
                        <div class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                            {{ number_format($santri->experience_points) }}
                        </div>
                        <div class="text-xs text-gray-500 font-semibold">XP</div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🎯</div>
                    <p class="text-gray-600">Belum ada data peringkat santri.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Leaderboard Grids -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <!-- Santri Putra -->
    <div x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 500)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-x-[-30px]">
        <div class="bg-white rounded-3xl shadow-2xl border-4 border-blue-200 overflow-hidden h-full">
            <div class="relative bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 p-6 overflow-hidden">
                <div class="absolute inset-0 animate-shimmer"></div>
                <h2 class="relative text-2xl font-bold text-white text-center drop-shadow-lg">
                    👨‍🎓 Top 10 Santri Putra
                </h2>
            </div>
            <div class="p-6 space-y-3">
                @forelse($topPutra as $index => $santri)
                    <div class="group flex items-center justify-between p-4 rounded-xl transition-all hover:scale-102
                        @if($santri->id == $currentUser->id)
                            bg-gradient-to-r from-blue-100 to-indigo-100 border-2 border-blue-400 shadow-lg
                        @elseif($index == 0)
                            bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-300 shadow-md
                        @elseif($index == 1)
                            bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-300
                        @elseif($index == 2)
                            bg-gradient-to-r from-orange-50 to-red-50 border-2 border-orange-300
                        @else
                            bg-gray-50 border-2 border-gray-200 hover:border-blue-300 hover:bg-blue-50
                        @endif
                    ">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-10 text-center">
                                @if($index < 3)
                                    <span class="text-3xl">{{ ['🥇', '🥈', '🥉'][$index] }}</span>
                                @else
                                    <span class="text-2xl font-bold text-gray-400">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-xl shadow-md">
                                👨‍🎓
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 flex items-center gap-2">
                                    {{ $santri->name }}
                                    @if($santri->id == $currentUser->id)
                                        <span class="text-xs bg-blue-500 text-white px-2 py-0.5 rounded-full">Kamu</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-600">
                                    <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full font-semibold">Lv {{ $santri->level }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-blue-600">{{ number_format($santri->experience_points) }}</div>
                            <div class="text-xs text-gray-500">XP</div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 text-center py-8">Belum ada data peringkat untuk santri putra.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Santri Putri -->
    <div x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 600)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-x-[30px]">
        <div class="bg-white rounded-3xl shadow-2xl border-4 border-pink-200 overflow-hidden h-full">
            <div class="relative bg-gradient-to-r from-pink-500 via-rose-500 to-red-500 p-6 overflow-hidden">
                <div class="absolute inset-0 animate-shimmer"></div>
                <h2 class="relative text-2xl font-bold text-white text-center drop-shadow-lg">
                    👩‍🎓 Top 10 Santri Putri
                </h2>
            </div>
            <div class="p-6 space-y-3">
                @forelse($topPutri as $index => $santri)
                    <div class="group flex items-center justify-between p-4 rounded-xl transition-all hover:scale-102
                        @if($santri->id == $currentUser->id)
                            bg-gradient-to-r from-pink-100 to-rose-100 border-2 border-pink-400 shadow-lg
                        @elseif($index == 0)
                            bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-300 shadow-md
                        @elseif($index == 1)
                            bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-300
                        @elseif($index == 2)
                            bg-gradient-to-r from-orange-50 to-red-50 border-2 border-orange-300
                        @else
                            bg-gray-50 border-2 border-gray-200 hover:border-pink-300 hover:bg-pink-50
                        @endif
                    ">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-10 text-center">
                                @if($index < 3)
                                    <span class="text-3xl">{{ ['🥇', '🥈', '🥉'][$index] }}</span>
                                @else
                                    <span class="text-2xl font-bold text-gray-400">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center text-xl shadow-md">
                                👩‍🎓
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 flex items-center gap-2">
                                    {{ $santri->name }}
                                    @if($santri->id == $currentUser->id)
                                        <span class="text-xs bg-pink-500 text-white px-2 py-0.5 rounded-full">Kamu</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-600">
                                    <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full font-semibold">Lv {{ $santri->level }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-pink-600">{{ number_format($santri->experience_points) }}</div>
                            <div class="text-xs text-gray-500">XP</div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 text-center py-8">Belum ada data peringkat untuk santri putri.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>

<!-- Motivational Quote -->
<div class="mt-12 text-center">
    <div class="inline-block bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border-2 border-emerald-200">
        <p class="text-xl font-arabic text-emerald-600 font-bold mb-2">
            وَسَارِعُوا إِلَىٰ مَغْفِرَةٍ مِّن رَّبِّكُمْ
        </p>
        <p class="text-sm text-gray-600">
            "Bersegeralah kamu kepada ampunan dari Tuhanmu"
        </p>
    </div>
</div>

@endsection