<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
        public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Email və ya şifrə yanlışdır'], 401);
        }

        return response()->json(['access_token' => $token]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'İstifadəçi uğurla yaradıldı',
            'user' => $user
        ], 201);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Çıxış edildi']);
    }
}


