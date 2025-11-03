<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Question;
use App\Models\Score;
use App\Models\AnswerLog;
use App\Helpers\LevelSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SantriController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $levelInfo = LevelSystem::getLevelInfo($user->experience_points ?? 0);
        $badge = LevelSystem::getBadge($user->total_games_completed ?? 0);
        $nextBadge = LevelSystem::getNextBadgeRequirement($user->total_games_completed ?? 0);
        
        $recentScores = Score::where('user_id', $user->id)
            ->with('game')
            ->orderBy('completed_at', 'desc')
            ->take(5)
            ->get();
        
        $totalGames = Game::count();
        $averageScore = Score::where('user_id', $user->id)->count() > 0
            ? Score::where('user_id', $user->id)->avg(DB::raw('(correct_answers / total_questions) * 100'))
            : 0;
        
        return view('santri.dashboard', compact(
            'user', 'levelInfo', 'badge', 'nextBadge', 
            'recentScores', 'totalGames', 'averageScore'
        ));
    }

    public function games()
    {
        $games = Game::withCount('questions')->get();
        $user = Auth::user();
        
        foreach ($games as $game) {
            $game->completed = Score::where('user_id', $user->id)
                ->where('game_id', $game->id)
                ->exists();
            
            $game->best_score = Score::where('user_id', $user->id)
                ->where('game_id', $game->id)
                ->max('score');
        }
        
        return view('santri.games.index', compact('games'));
    }

    public function playGame($id)
    {
        $game = Game::with('questions')->findOrFail($id);
        
        if ($game->questions->count() == 0) {
            return redirect()->route('santri.games')
                ->with('error', 'Game ini belum memiliki soal.');
        }
        
        $questions = $game->questions->shuffle();
        return view('santri.games.play', compact('game', 'questions'));
    }

    public function submitGame(Request $request, $id)
    {
        try {
            $game = Game::with('questions')->findOrFail($id);
            $user = Auth::user();
            
            $answers = $request->input('answers', []);
            $correctAnswers = 0;
            $totalQuestions = $game->questions->count();
            
            if ($totalQuestions == 0) {
                return redirect()->route('santri.games')
                    ->with('error', 'Game tidak memiliki soal.');
            }
            
            // Hitung jawaban benar
            foreach ($game->questions as $question) {
                $userAnswer = $answers[$question->id] ?? null;
                if ($userAnswer && strtolower(trim($userAnswer)) == strtolower(trim($question->correct_answer))) {
                    $correctAnswers++;
                }
            }
            
            $scorePercentage = round(($correctAnswers / $totalQuestions) * 100, 2);
            $xpEarned = LevelSystem::calculateXP($correctAnswers, $totalQuestions);
            
            // Update user stats dengan cara yang aman
            $user->experience_points = ($user->experience_points ?? 0) + $xpEarned;
            $user->total_score = ($user->total_score ?? 0) + $scorePercentage;
            
            // HANYA +1 jika first time (FIX BUG!)
            if ($isFirstTime) {
                $user->total_games_completed = ($user->total_games_completed ?? 0) + 1;
            }
            
            $levelInfo = LevelSystem::getLevelInfo($user->experience_points);
            $user->level = $levelInfo['level'];
            $user->save();
            
            // Save score to database
            $score = Score::create([
                'user_id' => $user->id,
                'game_id' => $game->id,
                'score' => $scorePercentage,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'completed_at' => now()
            ]);
            
            // Save answer logs untuk setiap pertanyaan
            foreach ($game->questions as $question) {
                $userAnswer = $answers[$question->id] ?? '';
                $isCorrect = strtolower(trim($userAnswer)) == strtolower(trim($question->correct_answer));
                
                AnswerLog::create([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                    'score_id' => $score->id,
                    'question_id' => $question->id,
                    'user_answer' => $userAnswer,
                    'correct_answer' => $question->correct_answer,
                    'is_correct' => $isCorrect
                ]);
            }
            
            return redirect()->route('santri.games.result', $game->id)
                ->with([
                    'scoreValue' => $scorePercentage,
                    'correctAnswers' => $correctAnswers,
                    'totalQuestions' => $totalQuestions,
                    'xpEarned' => $xpEarned,
                    'newLevel' => $levelInfo['level'],
                    'levelName' => $levelInfo['name']
                ]);
                
        } catch (\Exception $e) {
            return redirect()->route('santri.games')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function gameResult($id)
    {
        $game = Game::findOrFail($id);
        $user = Auth::user();
        
        // Safe retrieval with defaults
        $scoreValue = session('scoreValue', 0);
        $correctAnswers = session('correctAnswers', 0);
        $totalQuestions = session('totalQuestions', 1);
        $xpEarned = session('xpEarned', 0);
        $newLevel = session('newLevel', $user->level ?? 1);
        $levelName = session('levelName', 'Pemula');
        
        $levelInfo = LevelSystem::getLevelInfo($user->experience_points ?? 0);
        $badge = LevelSystem::getBadge($user->total_games_completed ?? 0);
        
        return view('santri.games.result', compact(
            'game', 'scoreValue', 'correctAnswers', 'totalQuestions',
            'xpEarned', 'newLevel', 'levelName', 'levelInfo', 'badge'
        ));
    }

    public function scores()
    {
        $user = Auth::user();
        
        $scores = Score::where('user_id', $user->id)
            ->with('game')
            ->orderBy('completed_at', 'desc')
            ->paginate(10);
        
        $totalGamesPlayed = Score::where('user_id', $user->id)->count();
        $averageScore = $totalGamesPlayed > 0
            ? Score::where('user_id', $user->id)->avg(DB::raw('(correct_answers / total_questions) * 100'))
            : 0;
        $bestScore = Score::where('user_id', $user->id)->max('score') ?? 0;
        
        return view('santri.scores.index', compact(
            'scores', 'totalGamesPlayed', 'averageScore', 'bestScore'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        
        $levelInfo = LevelSystem::getLevelInfo($user->experience_points ?? 0);
        $badge = LevelSystem::getBadge($user->total_games_completed ?? 0);
        
        $recentScores = Score::where('user_id', $user->id)
            ->with('game')
            ->orderBy('completed_at', 'desc')
            ->take(5)
            ->get();
        
        return view('santri.profile', compact('user', 'levelInfo', 'badge', 'recentScores'));
    }

    /**
     * UPDATE PROFILE PHOTO (NEW METHOD - FIX BUG!)
     */
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $user = Auth::user();

            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
            $user->save();

            return redirect()->route('santri.profile')
                ->with('success', 'Foto profil berhasil diupdate!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }
    }

    /**
     * DELETE PROFILE PHOTO (NEW METHOD - FIX BUG!)
     */
    public function deleteProfilePhoto()
    {
        try {
            $user = Auth::user();

            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->profile_photo = null;
            $user->save();

            return redirect()->route('santri.profile')
                ->with('success', 'Foto profil berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus foto: ' . $e->getMessage());
        }
    }
}