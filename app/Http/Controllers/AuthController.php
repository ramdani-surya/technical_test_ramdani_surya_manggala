<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        // case: gagal login
        if (!Auth::attempt($credentials)) {
            return response()->json([
                "message" => "Login failed.",
                "data"    => null,
                "token"   => null,
            ], 401);
        }

        // case: berhasil login
        $user = User::where('email', $request->email)->firstOrFail();

        return response()->json([
            "message" => "Login success.",
            "data"    => $user,
            "token"   => $request->user()->createToken($user->email)->plainTextToken,
        ]);
    }
}
