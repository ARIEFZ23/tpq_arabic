<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - TPQ Arabic Learning</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Arabic Font -->
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        .arabic-text {
            font-family: 'Amiri', serif;
            direction: rtl;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center">
                    <a href="{{ route('santri.dashboard') }}" class="flex items-center space-x-3">
                        <div class="text-3xl">📚</div>
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            TPQ Arabic
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('santri.dashboard') }}" 
                       class="px-4 py-2 rounded-lg font-semibold transition
                              {{ request()->routeIs('santri.dashboard') 
                                  ? 'bg-blue-500 text-white' 
                                  : 'text-gray-600 hover:bg-gray-100' }}">
                        🏠 Dashboard
                    </a>
                    
                    <a href="{{ route('santri.games') }}" 
                       class="px-4 py-2 rounded-lg font-semibold transition
                              {{ request()->routeIs('santri.games*') 
                                  ? 'bg-green-500 text-white' 
                                  : 'text-gray-600 hover:bg-gray-100' }}">
                        🎮 Games
                    </a>
                    
                    <a href="{{ route('santri.scores') }}" 
                       class="px-4 py-2 rounded-lg font-semibold transition
                              {{ request()->routeIs('santri.scores') 
                                  ? 'bg-purple-500 text-white' 
                                  : 'text-gray-600 hover:bg-gray-100' }}">
                        📊 Scores
                    </a>
                    
                    <a href="{{ route('santri.profile') }}" 
                       class="px-4 py-2 rounded-lg font-semibold transition
                              {{ request()->routeIs('santri.profile') 
                                  ? 'bg-pink-500 text-white' 
                                  : 'text-gray-600 hover:bg-gray-100' }}">
                        👤 Profile
                    </a>
                </div>

                <!-- User Menu -->
                <div class="flex items-center">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                     alt="Avatar" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-gray-300">
                            @else
                                <div class="text-2xl">
                                    {{ auth()->user()->role == 'santri_putra' ? '👦' : '👧' }}
                                </div>
                            @endif
                            <span class="font-semibold text-gray-700">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50"
                             style="display: none;">
                            
                            <div class="px-4 py-2 border-b">
                                <p class="text-sm text-gray-500">Level {{ auth()->user()->level ?? 1 }}</p>
                                <p class="text-xs text-gray-400">{{ auth()->user()->experience_points ?? 0 }} XP</p>
                            </div>
                            
                            <a href="{{ route('santri.profile') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                👤 My Profile
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition">
                                    🚪 Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden" x-data="{ mobileOpen: false }">
            <button @click="mobileOpen = !mobileOpen" 
                    class="w-full px-4 py-2 text-left text-gray-600 hover:bg-gray-100">
                ☰ Menu
            </button>
            
            <div x-show="mobileOpen" 
                 x-transition
                 class="border-t"
                 style="display: none;">
                <a href="{{ route('santri.dashboard') }}" class="block px-4 py-3 hover:bg-gray-100">
                    🏠 Dashboard
                </a>
                <a href="{{ route('santri.games') }}" class="block px-4 py-3 hover:bg-gray-100">
                    🎮 Games
                </a>
                <a href="{{ route('santri.scores') }}" class="block px-4 py-3 hover:bg-gray-100">
                    📊 Scores
                </a>
                <a href="{{ route('santri.profile') }}" class="block px-4 py-3 hover:bg-gray-100">
                    👤 Profile
                </a>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">✅ {{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">❌ {{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-gray-600">
            <p>© {{ date('Y') }} TPQ Arabic Learning. Made with ❤️ for better learning.</p>
        </div>
    </footer>

</body>
</html>