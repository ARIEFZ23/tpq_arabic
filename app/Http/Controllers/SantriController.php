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

class SantriController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $levelInfo = LevelSystem::getLevelInfo($user->experience_points ?? 0);
        $badge = LevelSystem::getBadge($user->games_completed ?? 0);
        $nextBadge = LevelSystem::getNextBadgeRequirement($user->games_completed ?? 0);
        
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
            $user->games_completed = ($user->games_completed ?? 0) + 1;
            
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
                    'score' => $scorePercentage,
                    'correct_answers' => $correctAnswers,
                    'total_questions' => $totalQuestions,
                    'xp_earned' => $xpEarned,
                    'new_level' => $levelInfo['level'],
                    'level_name' => $levelInfo['name']
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
        
        $score = session('score', 0);
        $correctAnswers = session('correct_answers', 0);
        $totalQuestions = session('total_questions', 0);
        $xpEarned = session('xp_earned', 0);
        $newLevel = session('new_level', $user->level ?? 1);
        $levelName = session('level_name', 'Pemula');
        
        $levelInfo = LevelSystem::getLevelInfo($user->experience_points ?? 0);
        $badge = LevelSystem::getBadge($user->games_completed ?? 0);
        
        return view('santri.games.result', compact(
            'game', 'score', 'correctAnswers', 'totalQuestions',
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
        $badge = LevelSystem::getBadge($user->games_completed ?? 0);
        $nextBadge = LevelSystem::getNextBadgeRequirement($user->games_completed ?? 0);
        
        $allBadges = [
            ['name' => 'Bronze', 'emoji' => '🥉', 'required' => 10, 'earned' => ($user->games_completed ?? 0) >= 10],
            ['name' => 'Silver', 'emoji' => '🥈', 'required' => 25, 'earned' => ($user->games_completed ?? 0) >= 25],
            ['name' => 'Gold', 'emoji' => '🥇', 'required' => 50, 'earned' => ($user->games_completed ?? 0) >= 50],
            ['name' => 'Diamond', 'emoji' => '💎', 'required' => 100, 'earned' => ($user->games_completed ?? 0) >= 100],
        ];
        
        $totalGamesPlayed = Score::where('user_id', $user->id)->count();
        $averageScore = $totalGamesPlayed > 0
            ? Score::where('user_id', $user->id)->avg(DB::raw('(correct_answers / total_questions) * 100'))
            : 0;
        $bestScore = Score::where('user_id', $user->id)->max('score') ?? 0;
        $totalCorrectAnswers = Score::where('user_id', $user->id)->sum('correct_answers');
        
        $gameTypeStats = Score::where('user_id', $user->id)
            ->join('games', 'scores.game_id', '=', 'games.id')
            ->select('games.type', DB::raw('COUNT(*) as count'), DB::raw('AVG(scores.score) as avg_score'))
            ->groupBy('games.type')
            ->get();
        
        return view('santri.profile', compact(
            'user', 'levelInfo', 'badge', 'nextBadge', 'allBadges',
            'totalGamesPlayed', 'averageScore', 'bestScore', 
            'totalCorrectAnswers', 'gameTypeStats'
        ));
    }
}