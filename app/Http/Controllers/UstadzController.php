<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Question;
use App\Models\Score;
use App\Models\User;
use App\Models\AnswerLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UstadzController extends Controller
{
    /**
     * Dashboard Ustadz
     */
    public function dashboard()
    {
        $user = Auth::user();
        $totalGames = Game::where('created_by', $user->id)->count();
        $totalQuestions = Question::whereHas('game', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })->count();
        
        $totalScores = Score::whereHas('game', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })->count();
        
        $averageScore = Score::whereHas('game', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })->avg('score') ?? 0;
        
        $recentGames = Game::where('created_by', $user->id)
            ->withCount('questions')
            ->latest()
            ->take(5)
            ->get();

        return view('ustadz.dashboard', compact(
            'totalGames', 
            'totalQuestions', 
            'totalScores', 
            'averageScore',
            'recentGames'
        ));
    }

    /**
     * List semua game yang dibuat oleh ustadz
     */
    public function games()
    {
        $games = Game::where('created_by', Auth::id())
            ->withCount('questions')
            ->withCount('scores')
            ->latest()
            ->paginate(10);

        return view('ustadz.games.index', compact('games'));
    }

    /**
     * Show form create game
     */
    public function createGame()
    {
        $gameTypes = [
            'tebak_gambar' => 'Tebak Kosakata dari Gambar 🖼️',
            'kosakata_tempat' => 'Kosakata di 30 Tempat 🏠', 
            'pilihan_ganda' => 'Pilihan Ganda Melengkapi Kalimat ✅',
            'percakapan' => 'Percakapan di 20 Tempat 💬'
        ];

        return view('ustadz.games.create', compact('gameTypes'));
    }

    /**
     * Store new game
     */
    public function storeGame(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:tebak_gambar,kosakata_tempat,pilihan_ganda,percakapan',
            'description' => 'nullable|string'
        ]);

        try {
            Game::create([
                'title' => $request->title,
                'type' => $request->type,
                'description' => $request->description,
                'created_by' => Auth::id()
            ]);

            return redirect()->route('ustadz.games.index')
                ->with('success', 'Game berhasil dibuat!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat game: ' . $e->getMessage());
        }
    }

    /**
     * Show form edit game
     */
    public function editGame($id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($id);
        $gameTypes = [
            'tebak_gambar' => 'Tebak Kosakata dari Gambar 🖼️',
            'kosakata_tempat' => 'Kosakata di 30 Tempat 🏠',
            'pilihan_ganda' => 'Pilihan Ganda Melengkapi Kalimat ✅',
            'percakapan' => 'Percakapan di 20 Tempat 💬'
        ];

        return view('ustadz.games.edit', compact('game', 'gameTypes'));
    }

    /**
     * Update game
     */
    public function updateGame(Request $request, $id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:tebak_gambar,kosakata_tempat,pilihan_ganda,percakapan',
            'description' => 'nullable|string'
        ]);

        try {
            $game->update([
                'title' => $request->title,
                'type' => $request->type,
                'description' => $request->description
            ]);

            return redirect()->route('ustadz.games.index')
                ->with('success', 'Game berhasil diupdate!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate game: ' . $e->getMessage());
        }
    }

    /**
     * Delete game
     */
    public function destroyGame($id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($id);

        try {
            $game->delete();
            return redirect()->route('ustadz.games.index')
                ->with('success', 'Game berhasil dihapus!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus game: ' . $e->getMessage());
        }
    }

    /**
     * Show game detail
     */
    public function showGame($id)
    {
        $game = Game::where('created_by', Auth::id())
            ->withCount('questions')
            ->withCount('scores')
            ->findOrFail($id);

        $questions = $game->questions()->latest()->paginate(10);

        return view('ustadz.games.show', compact('game', 'questions'));
    }

    /**
     * List questions untuk game tertentu
     */
    public function questions($game_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);
        $questions = $game->questions()->latest()->paginate(10);

        return view('ustadz.questions.index', compact('game', 'questions'));
    }

    /**
     * Show form create question
     */
    public function createQuestion($game_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);
        
        $locationOptions = [
            'Masjid', 'Rumah', 'Sekolah', 'Pasar', 'Kantor', 'Restoran', 
            'Taman', 'Perpustakaan', 'Klinik', 'Stasiun', 'Bandara', 'Pelabuhan',
            'Hotel', 'Mall', 'Bioskop', 'Lapangan', 'Kantin', 'Laboratorium',
            'Workshop', 'Kelas', 'Perpustakaan', 'Musholla', 'Kamar Mandi', 'Dapur',
            'Kamar Tidur', 'Ruang Tamu', 'Teras', 'Kebun', 'Garasi', 'Ruang Meeting'
        ];

        return view('ustadz.questions.create', compact('game', 'locationOptions'));
    }

    /**
     * Store new question
     */
    public function storeQuestion(Request $request, $game_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);

        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options' => 'nullable|array',
            'options.*' => 'string|max:255',
            'location_name' => 'nullable|string|max:255'
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('questions', 'public');
            }

            $options = null;
            if ($request->filled('options') && is_array($request->options)) {
                $options = json_encode(array_filter($request->options));
            }

            Question::create([
                'game_id' => $game->id,
                'question_text' => $request->question_text,
                'correct_answer' => $request->correct_answer,
                'image_path' => $imagePath,
                'options' => $options,
                'location_name' => $request->location_name
            ]);

            return redirect()->route('ustadz.games.questions.index', $game->id)
                ->with('success', 'Pertanyaan berhasil dibuat!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat pertanyaan: ' . $e->getMessage());
        }
    }

    /**
     * Show form edit question
     */
    public function editQuestion($game_id, $question_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);
        $question = $game->questions()->findOrFail($question_id);
        
        $locationOptions = [
            'Masjid', 'Rumah', 'Sekolah', 'Pasar', 'Kantor', 'Restoran', 
            'Taman', 'Perpustakaan', 'Klinik', 'Stasiun', 'Bandara', 'Pelabuhan',
            'Hotel', 'Mall', 'Bioskop', 'Lapangan', 'Kantin', 'Laboratorium',
            'Workshop', 'Kelas', 'Perpustakaan', 'Musholla', 'Kamar Mandi', 'Dapur',
            'Kamar Tidur', 'Ruang Tamu', 'Teras', 'Kebun', 'Garasi', 'Ruang Meeting'
        ];

        $options = [];
        if ($question->options) {
            $options = json_decode($question->options, true) ?? [];
        }

        return view('ustadz.questions.edit', compact('game', 'question', 'locationOptions', 'options'));
    }

    /**
     * Update question
     */
    public function updateQuestion(Request $request, $game_id, $question_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);
        $question = $game->questions()->findOrFail($question_id);

        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options' => 'nullable|array',
            'options.*' => 'string|max:255',
            'location_name' => 'nullable|string|max:255'
        ]);

        try {
            $imagePath = $question->image_path;
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file('image')->store('questions', 'public');
            }

            $options = null;
            if ($request->filled('options') && is_array($request->options)) {
                $options = json_encode(array_filter($request->options));
            }

            $question->update([
                'question_text' => $request->question_text,
                'correct_answer' => $request->correct_answer,
                'image_path' => $imagePath,
                'options' => $options,
                'location_name' => $request->location_name
            ]);

            return redirect()->route('ustadz.games.questions.index', $game->id)
                ->with('success', 'Pertanyaan berhasil diupdate!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate pertanyaan: ' . $e->getMessage());
        }
    }

    /**
     * Delete question
     */
    public function destroyQuestion($game_id, $question_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);
        $question = $game->questions()->findOrFail($question_id);

        try {
            // Delete image if exists
            if ($question->image_path && Storage::disk('public')->exists($question->image_path)) {
                Storage::disk('public')->delete($question->image_path);
            }

            $question->delete();

            return redirect()->route('ustadz.games.questions.index', $game->id)
                ->with('success', 'Pertanyaan berhasil dihapus!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus pertanyaan: ' . $e->getMessage());
        }
    }

    /**
     * View scores untuk semua game ustadz
     */
    public function scores()
    {
        $user = Auth::user();
        $scores = Score::whereHas('game', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })
        ->with(['user', 'game'])
        ->latest()
        ->paginate(15);

        $games = Game::where('created_by', $user->id)->get();

        return view('ustadz.scores.index', compact('scores', 'games'));
    }

    /**
     * View scores untuk game tertentu
     */
    public function gameScores($game_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);
        $scores = $game->scores()
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('ustadz.scores.game', compact('game', 'scores'));
    }

    /**
     * View detail jawaban santri
     */
    public function scoreDetail($score_id)
    {
        $score = Score::with(['user', 'game', 'answerLogs.question'])
            ->whereHas('game', function($query) {
                $query->where('created_by', Auth::id());
            })
            ->findOrFail($score_id);

        $answerLogs = $score->answerLogs()
            ->with('question')
            ->orderBy('question_id')
            ->get();

        return view('ustadz.scores.detail', compact('score', 'answerLogs'));
    }

    /**
 * Matrix Review - Lihat semua jawaban semua santri dalam 1 matrix (FIXED!)
 */
public function reviewMatrix($game_id)
{
    $game = Game::where('created_by', Auth::id())
        ->with('questions')
        ->findOrFail($game_id);

    // Ambil semua santri yang PERNAH mengerjakan game ini
    $santriList = \App\Models\User::whereHas('scores', function($q) use ($game_id) {
        $q->where('game_id', $game_id);
    })
    ->where(function($query) {
        $query->where('role', 'santri_putra')
              ->orWhere('role', 'santri_putri');
    })
    ->get();

    // Group answer logs by user_id-question_id key (FIX BUG!)
    $answerLogs = AnswerLog::where('game_id', $game_id)
        ->whereIn('user_id', $santriList->pluck('id'))
        ->get()
        ->groupBy(function($log) {
            return $log->user_id . '-' . $log->question_id;
        });

    return view('ustadz.scores.matrix', compact('game', 'santriList', 'answerLogs'));
}
}