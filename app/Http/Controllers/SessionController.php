<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $usernameEmail = $request->input('email');
        $isEmail = filter_var($usernameEmail, FILTER_VALIDATE_EMAIL);
        $validationException = ValidationException::withMessages([
            'login' => 'Sorry, those credentials do not match.',
        ]);

        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if ($isEmail) {
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
        } else {
            if (strpos($isEmail, '@') !== false) {
                throw $validationException;
            }
            $credentials = [
                'username' => $request->input('email'),
                'password' => $request->input('password'),
            ];
        }

        if (! Auth::attempt($credentials)) {
            throw $validationException;
        }

        $request->session()->regenerate();

        return redirect('/');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}
