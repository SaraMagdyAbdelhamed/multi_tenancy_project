@extends('tenant.layouts.app')

@section('title', 'Quiz Results')

@section('content')
<div class="flex flex-col">
    <h1 class="text-2xl font-bold mb-4">Quiz Results: {{ $quiz->title }}</h1>

    <x-filament-table :records="$quizAttempts" :columns="['member.name', 'score', 'passed']">
    </x-filament-table>
</div>
@endsection