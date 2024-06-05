<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Quiz;
use App\Models\MemberQuiz;
use App\Models\QuizAttempt;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionLinkEmail;
use App\Mail\QuizResult;


class QuizSubscribionsController extends Controller
{
    

    public function subscribe(Quiz $quiz)
    {
        $uniqueLink = Str::random(10);
        $memberQuiz = new QuizAttempt([
            'member_id' => auth()->guard('member')->id(),
            'quiz_id' => $quiz->id,
            'link' => $uniqueLink,
            'attempt_number' => 0
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
        $memberQuiz = QuizAttempt::where('link', $link)->first();
      
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

    public function submit(Request $request, Quiz $quiz)
    {
        $quizAttempt = QuizAttempt::where('quiz_id',$quiz->id)->where('member_id',auth('member')->user()->id)->first();
        
        // Process the submitted answers
        $answers = $request->input('answers');

        // Calculate the quiz result
        $totalMark = 0;
        $result['answers'] = [];
        $counter = 0;
        foreach ($answers as $questionId => $answerId) {
            $question = Question::find($questionId);
            $answer = choice::find($answerId);
            $result['answers'][$counter]['question'] = $question->title;
            if ($answer->is_correct) {
                $result['answers'][$counter]['your_answer'] = $answer->title;
                $result['answers'][$counter]['correct_answer'] = $answer->title;
                $totalMark += $question->mark;
            }
            $result['answers'][$counter]['your_answer'] = $answer->title;
            $result['answers'][$counter]['correct_answer'] = $question->choices->where('is_correct', 1)->first() ? $question->choices->where('is_correct', 1)->first()->title : 'No correct answer found';
            $counter++;
        }

        $memberMark = $totalMark / $quiz->mark * 100; // Calculate the percentage mark

        $quizAttempt->score = $memberMark;
        $quizAttempt->passed = $memberMark > $quiz->mark / 2 ?  1 : 0;
        $quizAttempt->attempt_number += 1; // Increment the attempt number
        $quizAttempt->save();

        $result['score'] = $memberMark;
        $result['total'] = $quiz->mark;

        // Create a new row in the member_quiz table for each quiz attempt
        MemberQuiz::create([
            'quiz_id' => $quiz->id,
            'member_id' => auth('member')->user()->id,
            'score' => $memberMark,
            'passed' => $memberMark > $quiz->mark / 2 ? 1 : 0,
        ]);

        // Send the result to the member via email
        Mail::to($request->user()->email)->send(new QuizResult($quiz, $result));
        
        
          // Send the result to the owner of the tenant via email
        $tenantOwnerEmail = tenant('email');
        Mail::to($tenantOwnerEmail)->send(new QuizResult($quiz, $result));



        return redirect()->route('quizes')->with('success', 'You finished exam.');
    }

    public function quizAllResults(Quiz $quiz)
    {
        $quizAttempts = $quiz->quizAttempts()->with('member')->get();

        return view('tenant.quizes.result', compact('quiz', 'quizAttempts'));
    }
}
