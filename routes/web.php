<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\UstadzController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Auth\RegisterSantriController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
// Home Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Registrasi Santri Routes (Public - Sebelum Login)
|--------------------------------------------------------------------------
*/
Route::get('/register-santri', [RegisterSantriController::class, 'create'])
    ->middleware('guest')
    ->name('register.santri');

Route::post('/register-santri', [RegisterSantriController::class, 'store'])
    ->middleware('guest')
    ->name('register.santri.store');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Dashboard Route (Auto Redirect berdasarkan Role)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isTeacher()) {
        return redirect()->route('ustadz.dashboard');
    } elseif ($user->isSantri()) {
        return redirect()->route('santri.dashboard');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes (All Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function() {
        $user = Auth::user();
        $totalUsers = \App\Models\User::count();
        $totalGames = \App\Models\Game::count();
        $totalQuestions = \App\Models\Question::count();
        $totalScores = \App\Models\Score::count();
        
        return view('dashboard', compact('totalUsers', 'totalGames', 'totalQuestions', 'totalScores'));
    })->name('dashboard');
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Game Management
    Route::resource('games', GameController::class);
    Route::post('/games/{game}/status', [GameController::class, 'toggleStatus'])->name('games.toggleStatus');
    
    // Question Management
    Route::resource('questions', QuestionController::class);
});

/*
|--------------------------------------------------------------------------
| Ustadz/Ustadzah Routes (Teacher)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'teacher'])->prefix('ustadz')->name('ustadz.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [UstadzController::class, 'dashboard'])->name('dashboard');
    
    // Games
    Route::get('/games', [UstadzController::class, 'games'])->name('games.index');
    Route::get('/games/create', [UstadzController::class, 'createGame'])->name('games.create');
    Route::post('/games', [UstadzController::class, 'storeGame'])->name('games.store');
    Route::get('/games/{id}', [UstadzController::class, 'showGame'])->name('games.show');
    Route::get('/games/{id}/edit', [UstadzController::class, 'editGame'])->name('games.edit');
    Route::put('/games/{id}', [UstadzController::class, 'updateGame'])->name('games.update');
    Route::delete('/games/{id}', [UstadzController::class, 'destroyGame'])->name('games.destroy');
    Route::post('/games/{id}/status', [UstadzController::class, 'toggleStatus'])->name('games.toggleStatus');

    // Questions
    Route::get('/games/{game_id}/questions', [UstadzController::class, 'questions'])->name('games.questions.index');
    Route::get('/games/{game_id}/questions/create', [UstadzController::class, 'createQuestion'])->name('games.questions.create');
    Route::post('/games/{game_id}/questions', [UstadzController::class, 'storeQuestion'])->name('games.questions.store');
    Route::get('/games/{game_id}/questions/{question_id}/edit', [UstadzController::class, 'editQuestion'])->name('games.questions.edit');
    Route::put('/games/{game_id}/questions/{question_id}', [UstadzController::class, 'updateQuestion'])->name('games.questions.update');
    Route::delete('/games/{game_id}/questions/{question_id}', [UstadzController::class, 'destroyQuestion'])->name('games.questions.destroy');
    
    // Scores
    Route::get('/scores', [UstadzController::class, 'scores'])->name('scores.index');
    Route::get('/scores/game/{game_id}', [UstadzController::class, 'gameScores'])->name('scores.game');
    Route::get('/scores/{score_id}/detail', [UstadzController::class, 'scoreDetail'])->name('scores.detail');
    Route::get('/scores/game/{game_id}/matrix', [UstadzController::class, 'reviewMatrix'])->name('scores.matrix');
});

/*
|--------------------------------------------------------------------------
| Santri Routes (Students)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'santri'])->prefix('santri')->name('santri.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [SantriController::class, 'dashboard'])->name('dashboard');
    
    // Games
    Route::get('/games', [SantriController::class, 'games'])->name('games');
    Route::get('/games/{id}/play', [SantriController::class, 'playGame'])->name('games.play');
    Route::post('/games/{id}/submit', [SantriController::class, 'submitGame'])->name('games.submit');
    Route::get('/games/{id}/result', [SantriController::class, 'gameResult'])->name('games.result');
    
    // ✅ Survival Quiz (Game Bawaan)
    Route::prefix('survival')->name('survival.')->group(function () {
        Route::get('/play', [SantriController::class, 'survivalGamePlay'])->name('play');
        Route::post('/submit', [SantriController::class, 'survivalGameSubmit'])->name('submit');
    });

    // ✅ Sentence Builder Game (Game Bawaan)
    Route::prefix('sentence-builder')->name('sentence-builder.')->group(function () {
        Route::get('/play', [SantriController::class, 'playSentenceBuilder'])->name('play');
        Route::post('/check', [SantriController::class, 'checkSentenceBuilder'])->name('check');
        Route::post('/submit', [SantriController::class, 'submitSentenceBuilder'])->name('submit');
        Route::get('/result', [SantriController::class, 'resultSentenceBuilder'])->name('result');
    });

    // Scores
    Route::get('/scores', [SantriController::class, 'scores'])->name('scores');
    
    // Leaderboard
    Route::get('/leaderboard', [SantriController::class, 'leaderboard'])->name('leaderboard');
    
    // Profile
    Route::get('/profile', [SantriController::class, 'profile'])->name('profile');

    // Profile Photo Upload
    Route::post('/profile/photo', function(\Illuminate\Http\Request $request) {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $user = Auth::user();
        
        if ($user->profile_photo && \Storage::disk('public')->exists($user->profile_photo)) {
            \Storage::disk('public')->delete($user->profile_photo);
        }
        
        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        $user->profile_photo = $path;
        $user->save();
        
        return back()->with('success', 'Foto profil berhasil diupdate!');
    })->name('profile.photo.update');
    
    Route::delete('/profile/photo', function() {
        $user = Auth::user();
        
        if ($user->profile_photo && \Storage::disk('public')->exists($user->profile_photo)) {
            \Storage::disk('public')->delete($user->profile_photo);
        }
        
        $user->profile_photo = null;
        $user->save();
        
        return back()->with('success', 'Foto profil berhasil dihapus!');
    })->name('profile.photo.delete');
});