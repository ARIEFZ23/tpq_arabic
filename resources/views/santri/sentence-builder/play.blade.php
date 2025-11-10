@extends('layouts.santri')

@section('title', 'Arabic Sentence Builder')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-500 to-indigo-500 rounded-lg shadow-lg p-6 mb-6 text-white">
        <h1 class="text-3xl font-bold mb-2">🧩 Arabic Sentence Builder</h1>
        <p class="text-lg">Susun kata-kata acak menjadi kalimat Bahasa Arab yang benar!</p>
    </div>

    <!-- Game Stats -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-gray-600 text-sm mb-1">Skor</div>
            <div id="score-display" class="text-3xl font-bold text-purple-600">0</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-gray-600 text-sm mb-1">Soal</div>
            <div id="question-counter" class="text-3xl font-bold text-indigo-600">1/10</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-gray-600 text-sm mb-1">Nyawa</div>
            <div id="lives-display" class="text-3xl font-bold text-red-600">❤️❤️❤️</div>
        </div>
    </div>

    <!-- Game Container -->
    <div id="game-container" class="bg-white rounded-lg shadow-lg p-8">
        <!-- Start Screen -->
        <div id="start-screen" class="text-center">
            <div class="mb-6">
                <div class="text-6xl mb-4">🧩</div>
                <h2 class="text-2xl font-bold mb-4">Siap Membangun Kalimat?</h2>
                <p class="text-gray-600 mb-2">• Pilih kata untuk menyusun kalimat dari kanan ke kiri.</p>
                <p class="text-gray-600 mb-2">• Gunakan "Hint" jika kesulitan (-10 poin).</p>
                <p class="text-gray-600 mb-2">• Jawaban benar: +20 poin, salah: -5 poin & -1 nyawa.</p>
            </div>
            <button 
                type="button"
                id="start-game-btn"
                class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white px-8 py-4 rounded-lg font-bold text-xl hover:from-purple-600 hover:to-indigo-600 transition-all transform hover:scale-105 cursor-pointer">
                🚀 MULAI GAME
            </button>
        </div>

        <!-- Question Screen -->
        <div id="question-screen" class="hidden">
            <!-- Translation -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg border-2 border-blue-200">
                <p class="text-center text-lg text-blue-800 font-semibold" id="translation-text">Terjemahan akan muncul di sini.</p>
            </div>

            <!-- Sentence Builder Area -->
            <div class="mb-6 p-6 bg-gray-100 rounded-lg border-2 border-dashed border-gray-400 min-h-[80px] flex flex-wrap items-center justify-center gap-2" id="sentence-builder">
                <!-- Kata-kata akan ditambahkan di sini oleh JavaScript -->
                <p class="text-gray-500">Klik kata di bawah untuk mulai menyusun...</p>
            </div>

            <!-- Scrambled Words -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3 text-gray-700">Kata-kata Acak:</h3>
                <div id="scrambled-words" class="flex flex-wrap gap-3 justify-center">
                    <!-- Kata-kata acak akan dibuat di sini oleh JavaScript -->
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center gap-4">
                <button 
                    type="button"
                    id="hint-btn"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg font-bold transition-all">
                    💡 Hint (-10 Poin)
                </button>
                <button 
                    type="button"
                    id="check-btn"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-bold transition-all">
                    ✔️ Cek Jawaban
                </button>
            </div>

            <!-- Feedback Message -->
            <div id="feedback-message" class="mt-6 p-4 rounded-lg text-center font-bold hidden"></div>
        </div>
    </div>
</div>

<!-- Game Over Modal (bisa kita tambahkan nanti) -->
<div id="game-over-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <!-- ... -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Game State
    let allQuestions = @json($questions); // Ambil soal dari controller
    let currentQuestionIndex = 0;
    let score = 0;
    let lives = 3;
    let gameOver = false;
    let currentSentence = []; // Menyimpan kata yang dipilih user
    let currentQuestion = null;
    let correctAnswersCount = 0; // Tracking jawaban benar yang akurat

    // DOM Elements
    const startScreen = document.getElementById('start-screen');
    const questionScreen = document.getElementById('question-screen');
    const startBtn = document.getElementById('start-game-btn');
    const scoreDisplay = document.getElementById('score-display');
    const questionCounter = document.getElementById('question-counter');
    const livesDisplay = document.getElementById('lives-display');
    const translationText = document.getElementById('translation-text');
    const sentenceBuilder = document.getElementById('sentence-builder');
    const scrambledWordsContainer = document.getElementById('scrambled-words');
    const hintBtn = document.getElementById('hint-btn');
    const checkBtn = document.getElementById('check-btn');
    const feedbackMessage = document.getElementById('feedback-message');

    // Shuffle questions at start
    shuffleArray(allQuestions);

    // Event Listeners
    startBtn.addEventListener('click', startGame);
    hintBtn.addEventListener('click', showHint);
    checkBtn.addEventListener('click', checkAnswer);

    // --- Game Functions ---
    function startGame() {
        startScreen.classList.add('hidden');
        questionScreen.classList.remove('hidden');

        // Reset state
        currentQuestionIndex = 0;
        score = 0;
        lives = 3;
        gameOver = false;
        currentSentence = [];
        
        updateDisplay();
        loadQuestion();
    }

    function loadQuestion() {
        if (currentQuestionIndex >= allQuestions.length) {
            // Game selesai, semua soal terjawab
            endGame(true);
            return;
        }

        currentQuestion = allQuestions[currentQuestionIndex];
        currentSentence = []; // Reset kalimat untuk soal baru

        // Update UI
        translationText.textContent = 'Terjemahan: ' + currentQuestion.translation;
        questionCounter.textContent = `${currentQuestionIndex + 1}/${allQuestions.length}`;

        // Clear previous elements
        sentenceBuilder.innerHTML = '<p class="text-gray-500">Klik kata di bawah untuk mulai menyusun...</p>';
        sentenceBuilder.style.direction = 'ltr'; // Reset direction
        scrambledWordsContainer.innerHTML = '';

        // Create and display scrambled words
        const scrambledWords = [...currentQuestion.scrambled];
        shuffleArray(scrambledWords);

        scrambledWords.forEach(word => {
            const wordBtn = document.createElement('button');
            wordBtn.type = 'button';
            wordBtn.className = 'bg-blue-100 hover:bg-blue-200 border-2 border-blue-300 rounded-lg px-4 py-2 font-bold text-blue-800 transition-all transform hover:scale-105 cursor-pointer';
            wordBtn.textContent = word;
            wordBtn.style.direction = 'rtl'; // Tampilkan teks Arab dari kanan ke kiri
            wordBtn.dataset.word = word; // Simpan kata di atribut data
            wordBtn.addEventListener('click', () => addWordToSentence(word, wordBtn));
            scrambledWordsContainer.appendChild(wordBtn);
        });

        hideFeedback();
    }

    function addWordToSentence(word, buttonElement) {
        if (gameOver) return;
        
        currentSentence.push(word);
        buttonElement.disabled = true; // Nonaktifkan tombol setelah dipilih
        buttonElement.classList.add('opacity-50', 'cursor-not-allowed');
        
        updateSentenceDisplay();
    }

    function updateSentenceDisplay() {
        if (currentSentence.length === 0) {
            sentenceBuilder.innerHTML = '<p class="text-gray-500">Klik kata di bawah untuk mulai menyusun...</p>';
            sentenceBuilder.style.direction = 'ltr';
        } else {
            // Tampilkan kalimat dari kanan ke kiri (RTL untuk bahasa Arab)
            sentenceBuilder.innerHTML = currentSentence.map(word => 
                `<span class="inline-block bg-yellow-100 border-2 border-yellow-300 rounded-lg px-4 py-2 font-bold text-yellow-800 mx-1" dir="rtl">${word}</span>`
            ).join('');
            // Set direction RTL untuk container
            sentenceBuilder.style.direction = 'rtl';
        }
    }
    
    function showHint() {
        if (gameOver) return;
        
        score = Math.max(0, score - 10); // Kurangi 10 poin
        updateDisplay();

        // Tampilkan jawaban Arab yang benar sebagai hint (dari kanan ke kiri)
        showFeedback('💡 Hint: ' + currentQuestion.correct, 'info');
    }

    function checkAnswer() {
        if (gameOver) return;

        const userSentence = currentSentence.join(' ');
        const correctSentence = currentQuestion.correct;

        if (userSentence === correctSentence) {
            // Jawaban Benar - TAMBAH SKOR
            score += 20; // Tambah 20 poin untuk jawaban benar
            updateDisplay(); // Update tampilan skor
            showFeedback('✅ Benar! +20 Poin', 'success');
            
            setTimeout(() => {
                currentQuestionIndex++;
                loadQuestion();
            }, 1500);

        } else {
            // Jawaban Salah - KURANGI NYAWA DAN SKOR
            lives--;
            score = Math.max(0, score - 5); // Kurangi 5 poin untuk jawaban salah
            showFeedback(`❌ Salah! -5 Poin. Jawaban yang benar: "${correctSentence}"`, 'error');
            
            updateDisplay();
            
            if (lives <= 0) {
                setTimeout(() => {
                    endGame(false); // Game Over karena nyawa habis
                }, 2000);
            } else {
                // Biarkan user mencoba lagi di soal yang sama
                // Reset kalimat dan aktifkan kembali tombol kata
                setTimeout(() => {
                    currentSentence = [];
                    updateSentenceDisplay();
                    const buttons = scrambledWordsContainer.querySelectorAll('button');
                    buttons.forEach(btn => {
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
                    hideFeedback();
                }, 2000);
            }
        }
    }

    function endGame(isCompleted) {
        gameOver = true;
        
        const totalQuestionsAnswered = isCompleted ? allQuestions.length : currentQuestionIndex;
        const correctAnswers = Math.floor(score / 20); // Karena 20 poin per jawaban benar
        
        // KIRIM SKOR KE BACKEND (MENGGUNAKAN LOGIKA YANG SAMA DENGAN GAME LAIN)
        fetch('/santri/sentence-builder/submit', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                answers: {}, // Tidak ada jawaban per soal, kita kirim data agregat
                score: score,
                correct_answers: correctAnswers,
                total_questions: totalQuestionsAnswered
            })
        })
        .then(response => response.json())
        .then(data => {
            // Arahkan ke halaman hasil atau tampilkan modal
            console.log('Score submitted:', data);
            // Bisa diarahkan ke halaman result umum atau modal khusus
            window.location.href = `/santri/sentence-builder/result`;
        })
        .catch(error => {
            console.error('Error submitting score:', error);
            alert('Terjadi kesalahan saat menyimpan skor.');
        });
    }


    // --- Helper Functions ---
    function updateDisplay() {
        scoreDisplay.textContent = score;
        const hearts = '❤️'.repeat(lives) + '🖤'.repeat(3 - lives);
        livesDisplay.textContent = hearts;
    }

    function showFeedback(message, type) {
        feedbackMessage.textContent = message;
        feedbackMessage.classList.remove('hidden', 'bg-green-100', 'text-green-800', 'bg-red-100', 'text-red-800', 'bg-blue-100', 'text-blue-800');
        
        if (type === 'success') {
            feedbackMessage.classList.add('bg-green-100', 'text-green-800');
        } else if (type === 'error') {
            feedbackMessage.classList.add('bg-red-100', 'text-red-800');
        } else {
            feedbackMessage.classList.add('bg-blue-100', 'text-blue-800');
        }
    }

    function hideFeedback() {
        feedbackMessage.classList.add('hidden');
    }

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }
});
</script>

@endsection