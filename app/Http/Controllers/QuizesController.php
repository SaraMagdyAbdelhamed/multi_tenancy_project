<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\CreateQuizRequest;
use App\Services\QuizService;
use App\Models\Quiz;
class QuizesController extends Controller
{
    public function index(QuizService $quizService)
    {
        $quizzes = $quizService->getAllQuizzes();
        return view('tenant.quizes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('tenant.quizes.create');
    }

    public function store(CreateQuizRequest $request, QuizService $quizService)
    {
        
        $validatedData = $request->validated();
        try{
            
               $quiz = $quizService->createQuiz($validatedData);

                // Create the questions and choices
                foreach ($validatedData['questions'] as $questionData) {
                    $question = $quiz->questions()->create([
                        'title' => $questionData['title'],
                        'description' => $questionData['description'],
                    ]);

                    foreach ($questionData['choices'] as $choiceData) {
                        $question->choices()->create([
                            'title' => $choiceData['title'],
                            'is_correct' =>  filter_var($choiceData['is_correct'], FILTER_VALIDATE_BOOLEAN),
                            'order' => $choiceData['order'],
                            'description' => $choiceData['description'],
                            'explanation' => $choiceData['explanation'],
                        ]);
                    }
                }
            return redirect()->route('quizes')->with('success', 'Quiz created successfully');

        } catch (\Exception $e) {
        // Error message
            return redirect()->back()->withErrors(['error' => 'An error occurred during quiz creation.'])->withInput();
        }
    }

    public function edit(Quiz $quiz)
    {
        return view('tenant.quizes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Update the quiz with the validated data
        $quiz->update($validatedData);

        return redirect()->route('quizes')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz, QuizService $quizService)
    {
        $quizService->deleteQuiz($quiz);

        return redirect()->route('quizes')->with('success', 'Quiz deleted successfully.');
    }
}
