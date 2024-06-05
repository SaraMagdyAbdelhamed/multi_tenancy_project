<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Http\Requests\tenant\MemberAuthRequest;
use Illuminate\Support\Facades\Hash;
class MemberAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('tenant.authmembers.login');
    }

    public function login(MemberAuthRequest $request)
    {
       
        if (Auth::guard('member')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

        
    }

    public function showRegistrationForm()
    {
        return view('tenant.authmembers.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $member = Member::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Auth::guard('member')->login($member);

        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        
           
        Auth::guard('member')->logout();
       

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended('/');
    }
}
