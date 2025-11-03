<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TPQ Arabic Learning') }} - Belajar Bahasa Arab Jadi Mudah</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Gradient animation */
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
        
        /* Float animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen">
    
    <!-- Navigation Bar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl">🕌</span>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        TPQ Arabic
                    </span>
                </div>
                
                <!-- Navigation Links -->
                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2 text-gray-700 hover:text-purple-600 font-medium transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2 text-gray-700 hover:text-purple-600 font-medium transition-colors">
                                Login
                            </a>
                            
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                <!-- Left Content -->
                <div class="space-y-8" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                    <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                        <!-- Badge -->
                        <div class="inline-block px-4 py-2 bg-purple-100 rounded-full mb-6">
                            <span class="text-purple-600 font-semibold text-sm">🎮 Belajar dengan Gamifikasi</span>
                        </div>
                        
                        <!-- Main Heading -->
                        <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight">
                            <span class="bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent animate-gradient">
                                Belajar Bahasa Arab
                            </span>
                            <br>
                            <span class="text-gray-800">Jadi Lebih Mudah!</span>
                        </h1>
                        
                        <!-- Description -->
                        <p class="text-xl text-gray-600 leading-relaxed">
                            Platform pembelajaran bahasa Arab interaktif dengan sistem level, badge, dan games yang menyenangkan. Cocok untuk santri TPQ semua usia! 🕌✨
                        </p>
                        
                        <!-- Features -->
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <span class="text-xl">🎯</span>
                                </div>
                                <span class="font-semibold text-gray-700">4 Jenis Games</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-xl">⭐</span>
                                </div>
                                <span class="font-semibold text-gray-700">Sistem Level & Badge</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <span class="text-xl">📊</span>
                                </div>
                                <span class="font-semibold text-gray-700">Track Progress</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                                    <span class="text-xl">🏆</span>
                                </div>
                                <span class="font-semibold text-gray-700">Leaderboard</span>
                            </div>
                        </div>
                        
                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            @guest
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="group px-10 py-5 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl font-bold text-lg shadow-2xl hover:shadow-purple-500/50 hover:scale-105 transition-all flex items-center justify-center space-x-3">
                                        <span>🎓 Daftar Santri Baru</span>
                                        <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </a>
                                @endif
                                
                                <a href="{{ route('login') }}" class="px-10 py-5 bg-white border-4 border-purple-600 text-purple-600 rounded-2xl font-bold text-lg shadow-lg hover:shadow-xl hover:bg-purple-50 transition-all flex items-center justify-center space-x-3">
                                    <span>🔐 Sudah Punya Akun? Login</span>
                                </a>
                            @else
                                <a href="{{ url('/dashboard') }}" class="px-10 py-5 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl font-bold text-lg shadow-2xl hover:shadow-purple-500/50 hover:scale-105 transition-all flex items-center justify-center space-x-3">
                                    <span>Dashboard</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Illustration -->
                <div class="relative" x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)">
                    <div x-show="show" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                        <!-- Main Card -->
                        <div class="relative z-10 bg-white rounded-3xl shadow-2xl p-8 border-4 border-purple-200 animate-float">
                            <div class="text-center space-y-6">
                                <!-- Icon -->
                                <div class="inline-block p-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-3xl shadow-xl">
                                    <span class="text-8xl">📚</span>
                                </div>
                                
                                <!-- Title -->
                                <h3 class="text-3xl font-bold text-gray-800">
                                    Mulai Belajar Sekarang!
                                </h3>
                                
                                <!-- Stats -->
                                <div class="grid grid-cols-3 gap-4 pt-4">
                                    <div class="bg-gradient-to-br from-green-100 to-green-200 rounded-2xl p-4">
                                        <div class="text-3xl font-bold text-green-700">4</div>
                                        <div class="text-sm text-green-600 font-medium">Games</div>
                                    </div>
                                    <div class="bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl p-4">
                                        <div class="text-3xl font-bold text-blue-700">5</div>
                                        <div class="text-sm text-blue-600 font-medium">Levels</div>
                                    </div>
                                    <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-2xl p-4">
                                        <div class="text-3xl font-bold text-yellow-700">5</div>
                                        <div class="text-sm text-yellow-600 font-medium">Badges</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Elements -->
                        <div class="absolute top-0 right-0 -mr-4 -mt-4 w-20 h-20 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg animate-float" style="animation-delay: 0.5s">
                            <span class="text-3xl">⭐</span>
                        </div>
                        <div class="absolute bottom-0 left-0 -ml-4 -mb-4 w-16 h-16 bg-pink-400 rounded-full flex items-center justify-center shadow-lg animate-float" style="animation-delay: 1s">
                            <span class="text-2xl">🏆</span>
                        </div>
                        <div class="absolute top-1/2 left-0 -ml-8 w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center shadow-lg animate-float" style="animation-delay: 1.5s">
                            <span class="text-xl">💎</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    Kenapa Belajar di <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">TPQ Arabic?</span>
                </h2>
                <p class="text-xl text-gray-600">Platform lengkap dengan fitur-fitur menarik untuk belajar bahasa Arab</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl hover:scale-105 transition-all border-4 border-transparent hover:border-purple-200">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-400 to-pink-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <span class="text-4xl">🖼️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Tebak Gambar</h3>
                    <p class="text-gray-600">Belajar kosakata dengan menebak gambar yang menarik dan mudah diingat</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl hover:scale-105 transition-all border-4 border-transparent hover:border-blue-200">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <span class="text-4xl">🏠</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Kosakata Tempat</h3>
                    <p class="text-gray-600">Pelajari kosakata di 30 tempat berbeda dengan konteks yang jelas</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl hover:scale-105 transition-all border-4 border-transparent hover:border-green-200">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <span class="text-4xl">✅</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Pilihan Ganda</h3>
                    <p class="text-gray-600">Melengkapi kalimat dengan pilihan jawaban yang tepat</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl hover:scale-105 transition-all border-4 border-transparent hover:border-yellow-200">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <span class="text-4xl">💬</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Percakapan</h3>
                    <p class="text-gray-600">Praktik percakapan bahasa Arab di 20 situasi berbeda</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <div class="bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 rounded-3xl shadow-2xl p-12 animate-gradient">
                <h2 class="text-4xl font-bold text-white mb-4">
                    Siap Mulai Belajar?
                </h2>
                <p class="text-xl text-white/90 mb-8">
                    Bergabunglah dengan ribuan santri lainnya yang sudah belajar bahasa Arab dengan cara yang menyenangkan!
                </p>
                @guest
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-block px-12 py-5 bg-white text-purple-600 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all">
                            🚀 Daftar Gratis Sekarang!
                        </a>
                    @endif
                @else
                    <a href="{{ url('/dashboard') }}" class="inline-block px-12 py-5 bg-white text-purple-600 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all">
                        Ke Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex items-center justify-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-2xl">🕌</span>
                </div>
                <span class="text-2xl font-bold">TPQ Arabic Learning</span>
            </div>
            <p class="text-gray-400 mb-4">Platform Pembelajaran Bahasa Arab Interaktif</p>
            <p class="text-sm text-gray-500">© {{ date('Y') }} TPQ Arabic Learning. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>