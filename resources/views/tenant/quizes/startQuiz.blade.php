@extends('tenant.layouts.app')

@section('title', 'Quiz Start')

@section('content')
<div class="flex items-center justify-center h-screen bg-gray-100">
    <div class="text-center">
       
        <h1 class="text-3xl font-bold mb-6">Welcome to the Quiz!</h1>
        <a href="{{ route('quizes.startQuiz', ['link' => $link]) }}" class="py-4 px-12 bg-blue-500 text-white rounded-lg font-semibold uppercase tracking-wide hover:bg-blue-600">Start Quiz</a>
    </div>
</div>
@endsection