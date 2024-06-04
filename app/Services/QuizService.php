<?php 
namespace App\Services;

use App\Models\Quiz;
use App\Repositories\QuizRepository;
class QuizService
{
    private $quizRepository;

    public function __construct(QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

    public function getAllQuizzes()
    {
        return $this->quizRepository->index();
    }

    public function createQuiz(array $validatedData)
    {
        // Determine the type based on the start and end dates
        $type = ($validatedData['start_time'] && $validatedData['end_time']) ? 1 : 2;

        return $this->quizRepository->create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'type' => $type
        ]);
    }

    public function updateQuiz(Quiz $quiz, array $validatedData)
    {
        // Determine the type based on the start and end dates
        $type = ($validatedData['start_time'] && $validatedData['end_time']) ? 1 : 2;

        return $this->quizRepository->update($quiz, [
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title']),
            'description' => $validatedData['description'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'type' => $type
        ]);
    }

    public function deleteQuiz(Quiz $quiz)
    {
        return $this->quizRepository->delete($quiz);
    }
}