<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'TPQ Arabic') }}</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen">

    <!-- Navigation Bar -->
    <nav class="bg-white/90 backdrop-blur-md shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl">🕌</span>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        TPQ Arabic
                    </span>
                </a>
                
                <!-- Back to Home -->
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-purple-600 font-medium transition-colors">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-block p-4 bg-gradient-to-br from-purple-600 to-pink-600 rounded-3xl shadow-xl mb-4">
                    <span class="text-6xl">🔐</span>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">
                    Login
                </h1>
                <p class="text-lg text-gray-600">
                    Masuk ke akun TPQ Arabic Learning
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 border-4 border-purple-200">
                
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 rounded-lg">
                        <p class="text-green-700 font-medium">{{ session('status') }}</p>
                    </div>
                @endif

                <!-- Success Message -->
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 rounded-lg">
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring focus:ring-purple-200 transition-colors @error('email') border-red-500 @enderror"
                            placeholder="contoh@email.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring focus:ring-purple-200 transition-colors @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            name="remember"
                            class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                        >
                        <label for="remember_me" class="ml-2 text-sm text-gray-600">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-700 underline">
                                Lupa password?
                            </a>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div>
                        <button 
                            type="submit"
                            class="w-full px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all"
                        >
                            🔐 Login
                        </button>
                    </div>

                    <!-- Register Links -->
                    <div class="space-y-3 pt-4 border-t-2 border-gray-200">
                        <!-- Daftar Santri Baru -->
                        <div class="text-center">
                            <p class="text-gray-600 mb-2">
                                Belum punya akun?
                            </p>
                            <a href="{{ route('register.santri') }}" class="inline-block w-full px-6 py-3 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                                🎓 Daftar Santri Baru
                            </a>
                        </div>
                        
                        <!-- Info untuk Ustadz/Admin -->
                        <div class="text-center pt-2">
                            <p class="text-xs text-gray-500">
                                Ustadz/Ustadzah/Admin? Hubungi admin untuk mendapatkan akun
                            </p>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="py-8 text-center text-gray-600">
        <p>© {{ date('Y') }} TPQ Arabic Learning. All rights reserved.</p>
    </footer>

</body>
</html>