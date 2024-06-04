@extends('tenant.layouts.app')

@section('title', 'Quiz')

@section('content')
    <div class="container mx-auto p-4">
        <div class="quiz-details">
            <h1 class="text-3xl font-bold mb-4">{{ $quiz->title }}</h1>
            <p>{{ $quiz->description }}</p>
        </div>

        <div class="question-list mt-8">
            <h2 class="text-2xl font-bold mb-4">Questions:</h2>
            {{-- <form action="{{ route('quizzes.submit', $quiz) }}" method="POST">
                @csrf --}}
                @foreach ($questions as $question)
                    <div class="question mb-4">
                        <h3 class="text-xl font-bold">{{ $question->title }}</h3>
                        <p>{{ $question->description }}</p>

                        <div class="answer-options mt-4">
                            @foreach ($question->choices->sortBy('order') as $answer)
                                <div class="answer-option flex items-center">
                                    <input type="radio" id="answer-{{ $answer->id }}" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" class="mr-2">
                                    <label for="answer-{{ $answer->id }}">{{ $answer->title }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                 @endforeach

                {{-- <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded mt-4">
                    Submit
                </button> 
            </form> --}}
        </div>
    </div>
@endsection