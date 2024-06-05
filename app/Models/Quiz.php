<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Quiz extends Model
{
    use HasSlug;

    protected $fillable = ['title', 'slug', 'description', 'start_time', 'end_time','mark'];

    protected $casts = [
        'mark' => 'integer',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function quizAttempts()
    {
        return $this->hasOne(QuizAttempt::class);
    }

    public function memberQuiz()
    {
        return $this->hasMany(MemberQuiz::class);
    }
}
