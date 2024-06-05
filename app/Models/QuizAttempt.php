<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'member_id',
        'attempt_number',
        'score',
        'passed',
        'link'
    ];

    // Define the relationship with the Quiz model
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Define the relationship with the Member model
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
