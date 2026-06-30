<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        $defaultPassword = 'Projecta@';

        if ($request->password !== $defaultPassword) {

            return response()->json([
                'success' => false,
                'message' => 'Password salah'
            ], 401);

        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => env('API_KEY')
        ]);
    }
}
