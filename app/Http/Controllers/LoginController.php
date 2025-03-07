<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Events\NewUserRegistered;

class LoginController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password,  $user->password)) {
            return response()->json([
                'message' => 'incorrect password'
            ], 401);
        }

        $token = $user->createToken($user->name . 'Auth-Token')->plainTextToken;

        return response()->json([
            'message' => 'login Successfully',
            'token_type' => 'Bearer',
            'token' => $token
        ], 200);
    }


    public function registation(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            
            event(new NewUserRegistered($user));
            $token = $user->createToken($user->name . 'Auth-Token')->plainTextToken;

            return response()->json([
                'message' => 'Registation Successfully',
                'token_type' => 'Bearer',
                'token' => $token
            ], 201);
        } else {
            return response()->json([
                'message' => 'something went wrong',
            ], 500);
        }
    }
}
