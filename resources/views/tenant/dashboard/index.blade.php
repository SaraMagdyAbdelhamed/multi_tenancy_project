@extends('tenant.layouts.app')

@section('title', 'Dashboard')

@section('content')
@auth
<div class="container mx-auto px-4">

    <h1 class="text-3xl font-bold mb-8 mt-4">Dashboard</h1>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Member Count</h2>
            <p class="text-4xl font-bold">{{ $memberCount }}</p>
        </div>

        <div class="bg-white rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Attempt Count</h2>
            <p class="text-4xl font-bold">{{ $attemptCount }}</p>
        </div>

        <div class="bg-white rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Pass Rate</h2>
            <p class="text-4xl font-bold">{{ $passRate }}%</p>
        </div>

        <div class="bg-white rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Fail Rate</h2>
            <p class="text-4xl font-bold">{{ $failRate }}%</p>
        </div>

        <div class="bg-white rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Average Score</h2>
            <p class="text-4xl font-bold">{{ $averageScore }}</p>
        </div>

        <div class="bg-white rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Average Time</h2>
            <p class="text-4xl font-bold">{{ $averageTime }}</p>
        </div>
    </div>
  
   
</div>
@endauth
@guest
<div class="flex items-center justify-center h-screen">
    <div class="text-center"> 
      <h1 class="text-6xl font-bold text-gray-800 mb-8">Welcome</h1>
    </div>
</div>
@endguest
@endsection