<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $loginData = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);
            if(!auth()->attempt($loginData))
            {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return response([
                'user' => auth()->user(), 
                'token' => $accessToken
            ], 200);
        } catch (Exception $error) {
            return response()->json($error->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return response()->json([
                'message' => 'Successfully logged out!'
            ]);
        } catch (Exception $error) {
            return response()->json($error->getMessage(), 500);
        }
    }
}
