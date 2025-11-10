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
// DITAMBAHKAN: Imports untuk Validasi Bulk
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
                // Status otomatis 'draft' by default dari migrasi
            ]);

            return redirect()->route('ustadz.games.index')
                ->with('success', 'Game berhasil dibuat! Silakan tambahkan pertanyaan.');

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
     * Publish/Unpublish Game
     */
    public function toggleStatus($id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($id);

        // Keamanan: Jangan biarkan game di-publish jika tidak ada soal
        if ($game->status == 'draft' && $game->questions()->count() == 0) {
            return back()->with('error', 'Game tidak bisa di-publish karena belum memiliki soal.');
        }

        // Toggle status
        if ($game->status == 'draft') {
            $game->status = 'published';
            $message = 'Game berhasil di-publish!';
        } else {
            $game->status = 'draft';
            $message = 'Game berhasil di-unpublish (disimpan sebagai draft).';
        }

        $game->save();

        return redirect()->route('ustadz.games.index')
            ->with('success', $message);
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
            'Workshop', 'Kelas', 'Musholla', 'Kamar Mandi', 'Dapur',
            'Kamar Tidur', 'Ruang Tamu', 'Teras', 'Kebun', 'Garasi', 'Ruang Meeting'
        ];

        return view('ustadz.questions.create', compact('game', 'locationOptions'));
    }

    /**
     * ======================================================
     * DIROMBAK TOTAL: Method storeQuestion (BULK)
     * ======================================================
     */
    public function storeQuestion(Request $request, $game_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);

        // 1. Validasi array 'questions'
        $rules = [
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.correct_answer' => 'required|string|max:255',
            'questions.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Hanya wajib jika game 'pilihan_ganda'
            'questions.*.options' => Rule::requiredIf($game->type == 'pilihan_ganda'),
            'questions.*.options.*' => 'nullable|string|max:255',
             // Hanya wajib jika game 'kosakata_tempat' atau 'percakapan'
            'questions.*.location_name' => Rule::requiredIf($game->type == 'kosakata_tempat' || $game->type == 'percakapan'),
        ];

        $messages = [
            'questions.*.question_text.required' => 'Teks pertanyaan untuk :attribute wajib diisi.',
            'questions.*.correct_answer.required' => 'Jawaban benar untuk :attribute wajib diisi.',
            'questions.*.image.image' => 'File yang diupload untuk :attribute harus berupa gambar.',
            'questions.*.options.required' => 'Pilihan jawaban untuk :attribute wajib diisi (untuk game Pilihan Ganda).',
            'questions.*.location_name.required' => 'Nama lokasi untuk :attribute wajib diisi (untuk game Kosakata/Percakapan).',
        ];

        // 1b. Validasi data input
        $validator = Validator::make($request->all(), $rules, $messages);

        // 1c. Menambahkan atribut nama yang manusiawi (Soal 1, Soal 2, dst.)
        $attributeNames = collect($request->get('questions', []))
            ->mapWithKeys(function ($item, $index) {
                $label = 'Soal ' . ($index + 1);
                return [
                    "questions.{$index}.question_text" => $label,
                    "questions.{$index}.correct_answer" => $label,
                    "questions.{$index}.image" => $label,
                    "questions.{$index}.options" => $label,
                    "questions.{$index}.location_name" => $label,
                ];
            })->all();

        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $allQuestionsData = $request->questions;
        $questionCount = 0;
        $uploadedImages = []; // Untuk melacak gambar jika terjadi rollback

        // 2. Gunakan DB Transaction (Agar aman)
        DB::beginTransaction();
        try {
            // 3. Looping untuk setiap soal yang di-submit
            foreach ($allQuestionsData as $index => $questionData) {

                $imagePath = null;
                // 4. Handle image upload (jika ada)
                if ($request->hasFile("questions.{$index}.image")) {
                    $imagePath = $request->file("questions.{$index}.image")->store('questions', 'public');
                    $uploadedImages[] = $imagePath; // Catat gambar
                }

                $options = null;
                // 5. Handle options (jika ada dan merupakan pilihan ganda)
                if ($game->type == 'pilihan_ganda' && !empty($questionData['options'])) {
                    // Filter pilihan yang kosong (misal: Ustadz hanya isi 2)
                    $filteredOptions = array_filter($questionData['options'], fn($value) => $value !== null && $value !== '');
                    if (!empty($filteredOptions)) {
                         $options = json_encode(array_values($filteredOptions)); // Re-index array
                    }
                }

                // 6. Simpan ke database
                Question::create([
                    'game_id' => $game->id,
                    'question_text' => $questionData['question_text'],
                    'correct_answer' => $questionData['correct_answer'],
                    'image_path' => $imagePath,
                    'options' => $options,
                    'location_name' => $questionData['location_name'] ?? null
                ]);

                $questionCount++;
            }

            // 7. Commit jika semua berhasil
            DB::commit();

            return redirect()->route('ustadz.games.questions.index', $game->id)
                ->with('success', "$questionCount pertanyaan baru berhasil ditambahkan!");

        } catch (\Exception $e) {
            // 8. Rollback jika ada error
            DB::rollBack();

            // Hapus gambar yang terlanjur di-upload
            foreach ($uploadedImages as $path) {
                Storage::disk('public')->delete($path);
            }

            return back()->with('error', 'Gagal menyimpan pertanyaan. Terjadi kesalahan: ' . $e->getMessage())->withInput();
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
            'Workshop', 'Kelas', 'Musholla', 'Kamar Mandi', 'Dapur',
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
            'options.*' => 'nullable|string|max:255',
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
            // DIPERBAIKI: Menghapus options kosong saat update
            if ($game->type == 'pilihan_ganda' && $request->filled('options') && is_array($request->options)) {
                $filteredOptions = array_filter($request->options, fn($value) => $value !== null && $value !== '');
                if (!empty($filteredOptions)) {
                     $options = json_encode(array_values($filteredOptions)); // Re-index array
                }
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
        $santriList = User::whereHas('scores', function($q) use ($game_id) {
            $q->where('game_id', $game_id);
        })
        ->where(function($query) {
            $query->where('role', 'santri_putra')
                  ->orWhere('role', 'santri_putri');
        })
        ->get();

        // Group answer logs by user_id-question_id key
        $answerLogs = AnswerLog::where('game_id', $game_id)
            ->whereIn('user_id', $santriList->pluck('id'))
            ->get()
            ->groupBy(function($log) {
                return $log->user_id . '-' . $log->question_id;
            });

        return view('ustadz.scores.matrix', compact('game', 'santriList', 'answerLogs'));
    }
}