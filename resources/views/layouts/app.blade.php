<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- ====================================================== -->
        <!--     PERBAIKAN: MENGGUNAKAN CDN, MENGHAPUS VITE     -->
        <!-- ====================================================== -->
        
        <!-- Fonts (DIGANTI: Menggunakan Poppins agar konsisten) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
        <!-- Scripts (DIGANTI: VITE diganti dengan CDN) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Defer sangat penting untuk Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
        <style>
            /* DITAMBAHKAN: Memastikan font Poppins diterapkan */
            body, [x-cloak] {
                font-family: 'Poppins', sans-serif;
            }
        </style>
        <!-- ====================================================== -->
        <!--              AKHIR DARI PERBAIKAN CDN                -->
        <!-- ====================================================== -->
    </head>
    
    <!-- DIUBAH: font-sans dihapus agar style di atas berlaku -->
    <body class="antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>