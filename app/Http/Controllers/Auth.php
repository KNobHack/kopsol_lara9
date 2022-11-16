<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Auth extends Controller
{
    public function index()
    {
        return view('auth');
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return redirect('/login');
        }

        if ($user->password != $request->password) {
            return redirect('/login');
        }

        return redirect('/dashboard');
    }
}
