<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tambah Pertanyaan Baru
                </h2>
                <p class="text-sm text-gray-600 mt-1">Game: {{ $game->title }}</p>
            </div>
            <a href="{{ route('ustadz.games.questions.index', $game->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Error!</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Error!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Game Info Card -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl p-6 mb-6 text-white">
                <div class="flex items-center space-x-4">
                    <div class="text-5xl">
                        @if($game->type === 'tebak_gambar') 🖼️
                        @elseif($game->type === 'kosakata_tempat') 🏠
                        @elseif($game->type === 'pilihan_ganda') ✅
                        @else 💬
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $game->title }}</h1>
                        <p class="text-sm opacity-90">
                            @if($game->type === 'tebak_gambar') Tebak Kosakata dari Gambar
                            @elseif($game->type === 'kosakata_tempat') Kosakata di 30 Tempat
                            @elseif($game->type === 'pilihan_ganda') Pilihan Ganda Melengkapi Kalimat
                            @else Percakapan di 20 Tempat
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Form Pertanyaan</h3>
                    <p class="text-gray-600">Isi form di bawah untuk menambah pertanyaan baru</p>
                </div>

                <form action="{{ route('ustadz.games.questions.store', $game->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Pertanyaan -->
                    <div class="mb-6">
                        <label for="question_text" class="block text-sm font-bold text-gray-700 mb-2">
                            Pertanyaan <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="question_text" 
                            id="question_text" 
                            rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                            placeholder="Contoh: Apa bahasa Arab dari 'rumah'?"
                            required
                        >{{ old('question_text') }}</textarea>
                        @error('question_text')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Gambar (untuk tebak_gambar) -->
                    @if($game->type === 'tebak_gambar' || $game->type === 'kosakata_tempat')
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-bold text-gray-700 mb-2">
                                Upload Gambar @if($game->type === 'tebak_gambar')<span class="text-red-500">*</span>@endif
                            </label>
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                accept="image/*"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                                @if($game->type === 'tebak_gambar') required @endif
                            >
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Nama Lokasi (untuk kosakata_tempat dan percakapan) -->
                    @if($game->type === 'kosakata_tempat' || $game->type === 'percakapan')
                        <div class="mb-6">
                            <label for="location_name" class="block text-sm font-bold text-gray-700 mb-2">
                                Nama Tempat <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="location_name" 
                                id="location_name" 
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                                required
                            >
                                <option value="">-- Pilih Tempat --</option>
                                @foreach($locationOptions as $location)
                                    <option value="{{ $location }}" {{ old('location_name') == $location ? 'selected' : '' }}>
                                        {{ $location }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Pilihan Jawaban (untuk pilihan_ganda) -->
                    @if($game->type === 'pilihan_ganda')
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Pilihan Jawaban <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                @for($i = 0; $i < 4; $i++)
                                    <div class="flex items-center space-x-2">
                                        <span class="bg-gray-200 text-gray-700 font-bold px-3 py-2 rounded">{{ chr(65 + $i) }}</span>
                                        <input 
                                            type="text" 
                                            name="options[]" 
                                            value="{{ old('options.' . $i) }}"
                                            class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                                            placeholder="Pilihan {{ chr(65 + $i) }}"
                                            required
                                        >
                                    </div>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500 mt-2">Isi minimal 2 pilihan, maksimal 4 pilihan</p>
                            @error('options')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Jawaban yang Benar -->
                    <div class="mb-6">
                        <label for="correct_answer" class="block text-sm font-bold text-gray-700 mb-2">
                            Jawaban yang Benar <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="correct_answer" 
                            id="correct_answer" 
                            value="{{ old('correct_answer') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                            placeholder="Contoh: بَيْتٌ"
                            required
                        >
                        @if($game->type === 'pilihan_ganda')
                            <p class="text-sm text-gray-500 mt-1">Harus sama persis dengan salah satu pilihan di atas</p>
                        @endif
                        @error('correct_answer')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                        <div class="flex items-start">
                            <div class="text-2xl mr-3">💡</div>
                            <div>
                                <p class="font-bold text-blue-800 mb-1">Tips:</p>
                                <ul class="text-sm text-blue-700 list-disc list-inside space-y-1">
                                    @if($game->type === 'tebak_gambar')
                                        <li>Gunakan gambar yang jelas dan mudah dipahami</li>
                                        <li>Pastikan jawaban sesuai dengan gambar</li>
                                    @elseif($game->type === 'kosakata_tempat')
                                        <li>Pilih kosakata yang relevan dengan tempat yang dipilih</li>
                                        <li>Gambar bersifat opsional untuk membantu visualisasi</li>
                                    @elseif($game->type === 'pilihan_ganda')
                                        <li>Buat pilihan yang menantang tapi tidak terlalu sulit</li>
                                        <li>Jawaban benar harus sama persis dengan salah satu pilihan</li>
                                    @else
                                        <li>Buat percakapan yang natural dan sesuai konteks</li>
                                        <li>Pilih tempat yang sesuai dengan situasi percakapan</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('ustadz.games.questions.index', $game->id) }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:from-green-600 hover:to-teal-600 transition font-medium">
                            ✅ Simpan Pertanyaan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>