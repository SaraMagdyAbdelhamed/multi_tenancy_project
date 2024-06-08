<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberQuiz extends Model
{
    protected $table = 'member_quizzes';

    protected $fillable = [
        'member_id', 'quiz_id', 'score', 'passed', 'time_taken'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    



    // Define any relationships or additional methods as needed
}
