@extends('tenant.layouts.app')

@section('title', 'Create Quiz')

@section('content')
<div class="flex flex-col justify-center items-center">
    <h1 class="text-2xl font-bold mb-4">Create Quiz</h1>

    <form action="{{ route('quizes.store') }}" method="POST" class="max-w-md mx-auto">
        @csrf

        <div class="mb-4">
            <label for="title" class="block font-semibold">Quiz Title:</label>
            <input type="text" name="title" id="title" class="border border-gray-300 p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="description" class="block font-semibold">Quiz Description:</label>
            <textarea name="description" id="description" class="border border-gray-300 p-2 rounded"></textarea>
        </div>

        <div class="mb-4">
            <label for="start_time" class="block font-semibold">Start Time:</label>
            <input type="datetime-local" name="start_time" id="start_time" class="border border-gray-300 p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="end_time" class="block font-semibold">End Time:</label>
            <input type="datetime-local" name="end_time" id="end_time" class="border border-gray-300 p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="mark" class="block font-semibold">Quiz Mark:</label>
            <input type="number" name="mark" id="mark" class="border border-gray-300 p-2 rounded">
        </div>

        <div id="questions-container">
            <!-- Questions will be dynamically added here -->
        </div>

        <button type="button" class="add-question bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Add Question</button>

        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">Create</button>
    </form>
</div>
    
@vite('resources/js/quizes/create.js')
@endsection