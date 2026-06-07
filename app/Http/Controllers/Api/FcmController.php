<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FcmToken;
use Illuminate\Http\Request;

class FcmController extends Controller
{
    public function store(Request $request)
    {
        FcmToken::updateOrCreate(
            ['token' => $request->token],
            ['token' => $request->token]
        );

        return response()->json([
            'token' => $request->token,
            'message' => 'Token FCM berhasil disimpan',
            'success' => true,
        ]);
    }
}
