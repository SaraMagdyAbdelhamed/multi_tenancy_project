<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        
        <style>
            body {
                font-family: 'figtree', sans-serif;
                background-color: #c1b8b8;
                margin: 0;
            }
            
            .card {
                background-color: #fff;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                border-radius: 4px;
                padding: 40px;
                width: 400px;
                margin: 0 auto;
                margin-top: 20vh;
            }
            
            .form-container {
                display: flex;
                align-items: center;
                margin-top: 40px;
            }
            
            .form-container input[type="text"] {
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 16px;
                outline: none;
                margin-right: 10px;
            }
            
            .form-container button {
                padding: 10px 20px;
                background-color: #ddd;
                border: none;
                border-radius: 4px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
            
            .form-container button:hover {
                background-color: #ccc;
            }
            
            .create-tenant-link {
                margin-top: 20px;
                text-align: center;
            }
            
            .create-tenant-link a {
                font-weight: 600;
                color: #333;
                text-decoration: none;
                transition: color 0.3s ease;
            }
            
            .create-tenant-link a:hover {
                color: #666;
            }
        </style>
    </head>
    <body>
       
        <div class="card">
            <div class="form-container">
                <input type="text" name="tenant" placeholder="Enter your tenant URL" class="px-4 py-2 border border-gray-300 focus:outline focus:ring-2 focus:ring-blue-500 rounded-md">
                <button type="submit" class="px-4 py-2 font-semibold text-gray-600 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md">Go</button>
            </div>
            
            <div class="create-tenant-link">
                <a href="{{ route('tenant.showRegistrationForm') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Create Your Own Tenant</a>
            </div>
        </div>
    </body>
</html>