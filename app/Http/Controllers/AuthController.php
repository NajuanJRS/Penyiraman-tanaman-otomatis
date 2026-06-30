<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (
            session()->has('is_login') &&
            session()->has('last_activity')
        ) {
            return redirect('/');
        }

        return view('login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        // Password default
        $defaultPassword = 'Project@';

        if ($request->password === $defaultPassword) {

            Session::put('is_login', true);

            Session::put('last_activity', time());

            return redirect('/');
        }

        return back()->with('error', 'Password yang anda masukkan salah');
    }

    public function logout()
    {
        Session::flush();

        return redirect('/login');
    }
}
