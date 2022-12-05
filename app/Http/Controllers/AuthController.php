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
            'email'    => ['required', 'email:rfc,dns', 'exists:users,email'],
            'password' => ['required', 'min:6'],
        ]);

        // case: gagal login
        if (!Auth::attempt($credentials)) {
            return response()->json([
                "message" => "Password is wrong.",
                "errors" => ["email" => ["Password is wrong."]]
            ], 401);
        }

        // case: berhasil login
        $user = User::where('email', $request->email)->firstOrFail();

        return response()->json([
            "message"      => "Login success.",
            "data"         => $user,
            "access_token" => $user->createToken($user->email)->plainTextToken,
            "token_type"   => 'Bearer',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email:rfc,dns', 'unique:users,email'],
            'password' => ['required', 'min:6'],
        ]);

        $user = User::create([
            'email'    => $request->email,
            'password' => bcrypt($request->email),
        ]);

        return response()->json([
            "message"      => "Register success.",
            "data"         => $user,
            "access_token" => $user->createToken($user->email)->plainTextToken,
            "token_type"   => 'Bearer',
        ]);
    }
}
