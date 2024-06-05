@component('mail::message')
# Quiz Result

Hi,

Here is your quiz result for {{$quiz->title}}:

Score: {{$result['score']}}/{{$result['total']}}

Correct Answers:
@foreach ($result['answers'] as $answer)
- Question: {{$answer['question']}}
  Your Answer: {{$answer['your_answer']}}
  Correct Answer: {{$answer['correct_answer']}}
@endforeach

Thank you for taking the quiz!

@endcomponent