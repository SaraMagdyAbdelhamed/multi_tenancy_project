@extends('tenant.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex items-center justify-center h-screen">
        <div class="text-center">
            <h1 class="text-6xl font-bold text-gray-800 mb-8">Welcome, {{ tenant('name')}}</h1>
            <!-- Add additional content here if needed -->
        </div>
    </div>
@endsection