<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Choice extends Model
{
    protected $fillable = ['title', 'is_correct', 'order', 'description', 'explanation'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
