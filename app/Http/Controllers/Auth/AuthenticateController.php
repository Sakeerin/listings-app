<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthenticateController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Login',[
            'status' => session('status')
        ]);
    }

    public function store(Request $request)
    {
        // sleep(2);
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:3'
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');

    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
