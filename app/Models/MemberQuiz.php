<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberQuiz extends Model
{
    protected $table = 'member_quizzes';

    protected $fillable = [
        'member_id', 'quiz_id', 'score', 'passed', 'started',
    ];

    // Define any relationships or additional methods as needed
}
