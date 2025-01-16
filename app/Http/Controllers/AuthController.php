<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
#use App\Mail\UserRegisteredMail;
#use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $fields = $request->validated();

        $user = User::create($fields);

        $token = $user->createToken($request->name);


        return response()->json([
            'data' => [
                'user' => $user,
                'token' => $token->plainTextToken,
            ],
            'message' => 'Korisnik je uspješno napravio svoj profil.',
        ], 201);
    }
    public function login(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Uneseni podaci nijesu tačni.'
            ], 401);
        }


        $token = $user->createToken($user->name);

        return response()->json([
            'data' => [
                'user' => $user,
                'token' => $token->plainTextToken,
            ],
            'message' => 'Korisnik je uspješno prijavljen.',
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Odjavili ste se.'
        ], 200);
    }
}
