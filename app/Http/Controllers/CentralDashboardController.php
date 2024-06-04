<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CentralDashboardController extends Controller
{
    public function index()
    {
       
        return view('welcome');
    }
}
