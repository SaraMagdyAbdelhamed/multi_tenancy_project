<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\CreateQuizRequest;
use App\Services\QuizService;
use App\Models\Quiz;
use App\Models\MemberQuiz;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionLinkEmail;
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

    public function subscribe(Quiz $quiz)
    {
        $uniqueLink = Str::random(10);
        $memberQuiz = new MemberQuiz([
            'member_id' => auth()->guard('member')->id(),
            'quiz_id' => $quiz->id,
            'link' => $uniqueLink
        ]);

        $memberQuiz->save();
        // Send the subscription link email to the member
        $member = auth()->guard('member')->user();
        $fullRoute = route('quizes.member', ['link' => $uniqueLink]);
        Mail::to($member->email)->send(new SubscriptionLinkEmail($member->name, $fullRoute));

        return redirect()->route('quizes')->with('success', 'Member subscribed successfully.');
    }

    public function openSubscribedQuiz($link)
    {
        $memberQuiz = MemberQuiz::where('link', $link)->first();
        
        // Check if the member is authorized to access the quiz
        if ($memberQuiz && $memberQuiz->member_id == auth()->guard('member')->id()) {
            $quiz = $memberQuiz->quiz;
            if ($quiz->type == 1 && now() < $quiz->start_date) {
                return redirect()->route('quizes')->with('error', 'This quiz is not yet available.');
            }
            $questions = $quiz->questions()->with('choices')->get();

            return view('tenant.quizes.show', compact('quiz', 'questions'));
        } else {
            // Redirect or show an error message if the member is not authorized
            return redirect()->route('quizes')->with('error', 'You are not authorized to access this quiz.');
        }

    }
}
