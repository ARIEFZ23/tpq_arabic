<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGame
 */
class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'created_by'
    ];

    /**
     * Relationship: Game has many questions (generic)
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Relationship: Game has many listening questions (specific)
     */
    public function listeningQuestions()
    {
        return $this->hasMany(ListeningQuestion::class);
    }

    /**
     * Relationship: Game has many scores
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Relationship: Game has many answer logs
     */
    public function answerLogs()
    {
        return $this->hasMany(AnswerLog::class);
    }

    /**
     * Relationship: Game belongs to creator (user)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}