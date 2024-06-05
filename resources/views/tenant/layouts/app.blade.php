<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <header class="bg-white py-4 px-6 shadow">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800">Welcome, {{  tenant('name') }}</h1>
                 @php
                    $isGuest = auth()->guard('member')->guest() && auth()->guard('web')->guest();
                    $auth = ! $isGuest;
                @endphp
                @auth('member')
                <form action="{{ route('member.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-blue-500">Logout</button>
                </form>
                @endauth
                @auth('web')
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-blue-500">Logout</button>
                    </form>
                @endauth
                
        </div>
    </header>
    <nav class="bg-gray-200 py-4 px-6">
        <div class="container mx-auto flex justify-between items-center">
            <ul class="flex space-x-8">
                

                @if($isGuest)
                    <li><a href="{{ route('member.register') }}" class="text-gray-700 font-semibold">Register as Member</a></li>
                    <li><a href="{{ route('member.login') }}" class="text-gray-700 font-semibold">Login as Member</a></li>
                    <li><a href="{{ route('login.admin') }}" class="text-gray-700 font-semibold">Login as Admin</a></li>
                @endif
                @auth('member')
                <li><a href="{{ route('tenant.dashboard') }}" class="text-gray-700 font-semibold">Dashboard</a></li>
                <li><a href="{{ route('quizes') }}" class="text-gray-700 font-semibold">Quizes</a></li>
                @endauth
                @auth('web')
                <li><a href="{{ route('tenant.dashboard') }}" class="text-gray-700 font-semibold">Dashboard</a></li>
                <li><a href="{{ route('quizes') }}" class="text-gray-700 font-semibold">Quizes</a></li>
                <li><a href="{{ route('members.index') }}" class="text-gray-700 font-semibold">Members</a></li>
                @endauth
            </ul>
        </div>
    </nav>
    <main>
        <!-- Display success message -->
        @if(session('success'))
        <div class="bg-green-500 text-white p-4 mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Display validation errors or other error messages -->
        @if($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Display specific error message -->
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @yield('content')
    </main>
    @vite('resources/js/app.js')
</body>
</html>