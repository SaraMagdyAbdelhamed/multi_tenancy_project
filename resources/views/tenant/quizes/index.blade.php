@extends('tenant.layouts.app')

@section('title', 'Quizes')

@section('content')
<div class="flex flex-col">
    @auth
    <div class="mt-6 mb-2">
        <a href="{{ route('quizes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">Create New Quiz</a>
    </div>
    @endauth
    <table class="min-w-full border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 bg-gray-800 text-white">Title</th>
                <th class="py-2 px-4 bg-gray-800 text-white">Start Date</th>
                <th class="py-2 px-4 bg-gray-800 text-white">End Date</th>
                <th class="py-2 px-4 bg-gray-800 text-white">Mark</th>
                <th class="py-2 px-4 bg-gray-800 text-white">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quizzes as $index => $quiz)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                    <td class="py-2 px-4 text-center">{{ $quiz->title }}</td>
                    <td class="py-2 px-4 text-center">{{ $quiz->start_time }}</td>
                    <td class="py-2 px-4 text-center">{{ $quiz->end_time }}</td>
                    <td class="py-2 px-4 text-center">{{ $quiz->mark }}</td>
                    <td class="py-2 px-4 text-center">
                        @auth('web')
                        <a href="{{ route('quizes.edit', $quiz->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                        <form action="{{ route('quizes.destroy', $quiz->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                        </form>
                        <a href="{{ route('quizes.result', $quiz) }}" class="text-purple-500 hover:text-purple-700 ml-2">Quiz Results</a>
                        @endauth
                        @auth('member')
                            @php
                                $quizAttempt = $quiz->quizAttempts()->where('member_id', auth('member')->user()->id)->first();
                            @endphp
                            @if($quizAttempt)
                                Score: {{ $quizAttempt->score }} | Passed: {{ $quizAttempt->passed ? 'Yes' : 'No' }}
                            @else
                                Not attempted yet
                            @endif
                            @unless(auth('member')->user()->quizAttempts->where('quiz_id', $quiz->id))
                                <form action="{{ route('quizes.subscribe', $quiz) }}" method="POST">
                                    @csrf
                                    <button type="submit">Subscribe</button>
                                </form>
                            @endunless
                        @endauth
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection