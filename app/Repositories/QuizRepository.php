<?php 
namespace App\Repositories;

use App\Models\Quiz;

class QuizRepository
{
    public function index()
    {
        return Quiz::all();
    }

    public function create(array $data)
    {
        return Quiz::create($data);
    }

    public function update(Quiz $quiz, array $data)
    {
        $quiz->update($data);
        return $quiz;
    }

    public function delete(Quiz $quiz)
    {
        $quiz->delete();
    }
}