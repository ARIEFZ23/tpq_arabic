@extends('layouts.santri')

@section('title', 'Survival Quiz')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-red-500 to-orange-500 rounded-lg shadow-lg p-6 mb-6 text-white">
        <h1 class="text-3xl font-bold mb-2">🔥 Survival Quiz</h1>
        <p class="text-lg">Jawab sebanyak mungkin sebelum waktu habis!</p>
        <p class="mt-2">High Score Anda: <span class="font-bold text-yellow-300">{{ $highScore }}</span></p>
    </div>

    <!-- Game Stats -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-gray-600 text-sm mb-1">Skor</div>
            <div id="score-display" class="text-3xl font-bold text-blue-600">0</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-gray-600 text-sm mb-1">Waktu</div>
            <div id="timer-display" class="text-3xl font-bold text-red-600">30</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-gray-600 text-sm mb-1">Lives</div>
            <div id="lives-display" class="text-3xl font-bold text-green-600">❤️❤️❤️</div>
        </div>
    </div>

    <!-- Game Container -->
    <div id="game-container" class="bg-white rounded-lg shadow-lg p-8">
        <!-- Start Screen -->
        <div id="start-screen" class="text-center">
            <div class="mb-6">
                <div class="text-6xl mb-4">🎮</div>
                <h2 class="text-2xl font-bold mb-4">Siap Bermain?</h2>
                <p class="text-gray-600 mb-2">• Jawab soal dengan benar untuk dapat poin</p>
                <p class="text-gray-600 mb-2">• Jawaban salah mengurangi nyawa</p>
                <p class="text-gray-600 mb-2">• Habis nyawa = Game Over</p>
                <p class="text-gray-600 mb-6">• Dapatkan XP untuk naik level! ⭐</p>
            </div>
            <button 
                type="button"
                id="start-game-btn"
                class="bg-gradient-to-r from-green-500 to-blue-500 text-white px-8 py-4 rounded-lg font-bold text-xl hover:from-green-600 hover:to-blue-600 transition-all transform hover:scale-105 cursor-pointer">
                🚀 MULAI GAME
            </button>
        </div>

        <!-- Question Screen -->
        <div id="question-screen" class="hidden">
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">Soal ke-<span id="question-number">1</span></span>
                    <span class="text-sm text-gray-500">Kategori: Survival Quiz</span>
                </div>
                <h3 id="question-text" class="text-xl font-bold mb-6"></h3>
            </div>

            <div id="options-container" class="space-y-3">
                <!-- Options akan di-generate oleh JavaScript -->
            </div>

            <div id="feedback-message" class="mt-6 p-4 rounded-lg text-center font-bold hidden"></div>
        </div>
    </div>
</div>

<!-- Game Over Modal -->
<div id="game-over-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-2xl p-8 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="text-6xl mb-4">🎮</div>
            <h2 class="text-3xl font-bold mb-4">Game Over!</h2>
            
            <div class="bg-gray-100 rounded-lg p-6 mb-6">
                <p class="text-gray-600 mb-2">Skor Akhir</p>
                <p id="final-score" class="text-5xl font-bold text-blue-600 mb-4">0</p>
                <div id="high-score-message" class="text-lg"></div>
            </div>

            <div class="space-y-3">
                <button 
                    type="button"
                    onclick="location.reload()" 
                    class="w-full bg-gradient-to-r from-green-500 to-blue-500 text-white px-6 py-3 rounded-lg font-bold hover:from-green-600 hover:to-blue-600 transition-all cursor-pointer">
                    🔄 Main Lagi
                </button>
                <a href="{{ route('santri.dashboard') }}" class="block w-full bg-gray-500 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-600 transition-all">
                    🏠 Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Game Data
    const questions = @json($questions);
    let currentQuestionIndex = 0;
    let score = 0;
    let lives = 3;
    let timeLeft = 30;
    let timerInterval;
    let gameOver = false;

    // Initialize game when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Game initialized with', questions.length, 'questions');
        
        // Shuffle questions
        shuffleArray(questions);
        
        // Add event listener to start button
        const startBtn = document.getElementById('start-game-btn');
        if (startBtn) {
            startBtn.addEventListener('click', function() {
                console.log('Start button clicked');
                startGame();
            });
        }
    });

    // Game Functions
    function startGame() {
        console.log('Starting game...');
        
        document.getElementById('start-screen').classList.add('hidden');
        document.getElementById('question-screen').classList.remove('hidden');
        
        currentQuestionIndex = 0;
        score = 0;
        lives = 3;
        timeLeft = 30;
        gameOver = false;
        
        updateDisplay();
        loadQuestion();
        startTimer();
    }

    function startTimer() {
        timerInterval = setInterval(() => {
            timeLeft--;
            document.getElementById('timer-display').textContent = timeLeft;
            
            // Warning effect saat waktu < 10 detik
            if (timeLeft <= 10) {
                document.getElementById('timer-display').classList.add('animate-pulse');
            }
            
            if (timeLeft <= 0) {
                endGame();
            }
        }, 1000);
    }

    function loadQuestion() {
        if (currentQuestionIndex >= questions.length) {
            // Jika soal habis, muat ulang soal dari awal
            currentQuestionIndex = 0;
            shuffleArray(questions);
        }

        const question = questions[currentQuestionIndex];
        document.getElementById('question-number').textContent = currentQuestionIndex + 1;
        document.getElementById('question-text').textContent = question.question_text;
        
        // Reset feedback message
        const feedbackEl = document.getElementById('feedback-message');
        feedbackEl.classList.add('hidden');
        
        // ⭐ ACAK PILIHAN JAWABAN SEBELUM DITAMPILKAN
        shuffleArray(question.options);
        
        // Load options
        const optionsContainer = document.getElementById('options-container');
        optionsContainer.innerHTML = '';
        
        question.options.forEach((option, index) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'w-full bg-gray-100 hover:bg-blue-100 border-2 border-gray-300 hover:border-blue-500 rounded-lg p-4 text-left font-semibold transition-all transform hover:scale-102 cursor-pointer';
            button.textContent = option;
            button.addEventListener('click', function() {
                checkAnswer(option, question.correct_answer);
            });
            optionsContainer.appendChild(button);
        });
    }

    function checkAnswer(userAnswer, correctAnswer) {
        if (gameOver) return;

        const feedbackEl = document.getElementById('feedback-message');
        const isCorrect = userAnswer.toLowerCase().trim() === correctAnswer.toLowerCase().trim();

        if (isCorrect) {
            // Jawaban Benar
            score++;
            timeLeft += 5; // Bonus waktu
            
            feedbackEl.textContent = '✅ Benar! +5 detik bonus';
            feedbackEl.className = 'mt-6 p-4 rounded-lg text-center font-bold bg-green-100 text-green-800';
            feedbackEl.classList.remove('hidden');
            
            updateDisplay();
            
            setTimeout(() => {
                currentQuestionIndex++;
                loadQuestion();
            }, 1000);
            
        } else {
            // Jawaban Salah
            lives--;
            
            feedbackEl.textContent = `❌ Salah! Jawaban: ${correctAnswer}`;
            feedbackEl.className = 'mt-6 p-4 rounded-lg text-center font-bold bg-red-100 text-red-800';
            feedbackEl.classList.remove('hidden');
            
            updateDisplay();
            
            if (lives <= 0) {
                setTimeout(() => {
                    endGame();
                }, 1500);
            } else {
                setTimeout(() => {
                    currentQuestionIndex++;
                    loadQuestion();
                }, 1500);
            }
        }
    }

    function updateDisplay() {
        document.getElementById('score-display').textContent = score;
        document.getElementById('timer-display').textContent = timeLeft;
        
        // Update lives display
        const heartsArray = Array(lives).fill('❤️');
        const emptyHearts = Array(3 - lives).fill('🖤');
        document.getElementById('lives-display').textContent = heartsArray.concat(emptyHearts).join('');
    }

    function endGame() {
        gameOver = true;
        clearInterval(timerInterval);
        
        // 📤 SUBMIT SCORE KE BACKEND (DENGAN XP & LEVEL SYSTEM)
        fetch('{{ route("santri.survival.submit") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                score: score,
                correct_answers: score,           // ⭐ KIRIM JUMLAH JAWABAN BENAR
                total_questions: questions.length  // ⭐ KIRIM TOTAL SOAL
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response:', data);
            
            // 📊 TAMPILKAN HASIL (DENGAN XP & LEVEL INFO)
            document.getElementById('final-score').textContent = score;
            
            let message = '';
            if (data.is_new_record) {
                message = '<span class="text-yellow-500 font-bold text-xl">🎉 REKOR BARU!</span><br><br>';
            }
            message += `<div class="text-gray-700 mb-2">High Score: <span class="font-bold text-2xl">${data.high_score}</span></div>`;
            message += `<div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-3 mt-3 mb-2">`;
            message += `<span class="text-blue-600 font-bold text-lg">⭐ +${data.xp_earned} XP</span>`;
            message += `</div>`;
            message += `<div class="bg-purple-50 border-2 border-purple-300 rounded-lg p-3">`;
            message += `<span class="text-purple-600 font-bold">🎯 Level ${data.new_level}: ${data.level_name}</span><br>`;
            message += `<span class="text-purple-500 text-sm">Total XP: ${data.total_xp}</span>`;
            message += `</div>`;
            
            document.getElementById('high-score-message').innerHTML = message;
            document.getElementById('game-over-modal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan skor');
            document.getElementById('game-over-modal').classList.remove('hidden');
        });
    }

    // Utility function to shuffle array
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }
</script>
@endsection